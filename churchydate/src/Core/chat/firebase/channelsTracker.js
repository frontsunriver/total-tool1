import { setChannelsSubcribed, setChannels } from '../redux';
import { setUsers, setUserData } from '../../onboarding/redux/auth';
import { setBannedUserIDs } from '../../user-reporting/redux';
import { firebaseUser } from './../../firebase';
import { reportingManager } from '../../user-reporting';
import { channelManager } from '../firebase';

export default class ChannelsTracker {
  constructor(reduxStore, userID) {
    this.reduxStore = reduxStore;
    this.userID = userID;
    this.reduxStore.subscribe(this.syncTrackerToStore);
  }

  syncTrackerToStore = () => {
    const state = this.reduxStore.getState();
    this.users = state.auth.users;
  };

  subscribeIfNeeded = () => {
    const userId = this.userID;
    const state = this.reduxStore.getState();
    if (!state.chat.areChannelsSubcribed) {
      this.reduxStore.dispatch(setChannelsSubcribed());
      this.currentUserUnsubscribe = firebaseUser.subscribeCurrentUser(
        userId,
        this.onCurrentUserUpdate,
      );
      this.usersUnsubscribe = firebaseUser.subscribeUsers(
        userId,
        this.onUsersCollection,
      );
      this.abusesUnsubscribe = reportingManager.unsubscribeAbuseDB(
        userId,
        this.onAbusesUpdate,
      );
      this.channelParticipantUnsubscribe = channelManager.subscribeChannelParticipation(
        userId,
        this.onChannelParticipationCollectionUpdate,
      );
      this.channelsUnsubscribe = channelManager.subscribeChannels(
        this.onChannelCollectionUpdate,
      );
    }
  };

  unsubscribe = () => {
    if (this.currentUserUnsubscribe) {
      this.currentUserUnsubscribe();
    }
    if (this.usersUnsubscribe) {
      this.usersUnsubscribe();
    }
    if (this.channelsUnsubscribe) {
      this.channelsUnsubscribe();
    }
    if (this.channelParticipantUnsubscribe) {
      this.channelParticipantUnsubscribe();
    }
    if (this.abusesUnsubscribe) {
      this.abusesUnsubscribe();
    }
  };

  updateUsers = (users) => {
    // We remove all friends and friendships from banned users
    const state = this.reduxStore.getState();
    const bannedUserIDs = state.userReports.bannedUserIDs;

    if (bannedUserIDs) {
      this.users = users.filter((user) => !bannedUserIDs.includes(user.id));
    } else {
      this.users = users;
    }
    this.reduxStore.dispatch(setUsers(this.users));
    this.hydrateChannelsIfNeeded();
  };

  onCurrentUserUpdate = (user) => {
    this.reduxStore.dispatch(setUserData({ user }));
  };

  onUsersCollection = (data, completeData) => {
    this.updateUsers(data);
  };

  onAbusesUpdate = (abuses) => {
    var bannedUserIDs = [];
    abuses.forEach((abuse) => bannedUserIDs.push(abuse.dest));
    this.reduxStore.dispatch(setBannedUserIDs(bannedUserIDs));
    this.bannedUserIDs = bannedUserIDs;
    this.purgeBannedUsers();
    this.updateChannelsStore();
  };

  onChannelParticipationCollectionUpdate = (participations) => {
    this.participations = participations;
    this.hydrateChannelsIfNeeded();
  };

  onChannelCollectionUpdate = (channels) => {
    this.channels = channels;
    this.hydrateChannelsIfNeeded();
  };

  updateUsers = (users) => {
    // We remove all 1:1 channels from banned users
    const state = this.reduxStore.getState();
    const bannedUserIDs = state.userReports.bannedUserIDs;

    if (bannedUserIDs) {
      this.users = users.filter((user) => !bannedUserIDs.includes(user.id));
    } else {
      this.users = users;
    }
    this.reduxStore.dispatch(setUsers(this.users));
    this.hydrateChannelsIfNeeded();
  };

  hydrateChannelsIfNeeded = () => {
    const channels = this.channels;
    const allUsers = this.users;
    const participations = this.participations;
    if (!channels || !allUsers || !participations) {
      return;
    }
    // we fetched all the data that we need
    const myChannels = channels.filter((channel) =>
      participations.find(
        (participation) => participation.channel == channel.id,
      ),
    );
    const participantIDsByChannelHash = {};

    var channelParticipantPromises = myChannels.map((channel) => {
      return new Promise((resolve, _reject) => {
        channelManager.fetchChannelParticipantIDs(channel, (participantIDs) => {
          participantIDsByChannelHash[channel.id] = participantIDs;
          resolve();
        });
      });
    });
    Promise.all(channelParticipantPromises).then((_values) => {
      var hydratedChannels = [];
      myChannels.forEach((channel) => {
        const participantIDs = participantIDsByChannelHash[channel.id];
        if (participantIDs) {
          // filter out current user
          const finalParticipantIDs = participantIDs.filter(
            (id) => id != this.userID,
          );
          if (finalParticipantIDs && finalParticipantIDs.length > 0) {
            var hydratedParticipants = [];
            finalParticipantIDs.forEach((userID) => {
              const user = allUsers.find((user) => user.id == userID);
              if (user) {
                // we have an hydrated user for this current participant
                hydratedParticipants.push(user);
              }
            });
            hydratedChannels.push({
              ...channel,
              participants: hydratedParticipants,
            });
          }
        }
      });
      this.hydratedChannels = hydratedChannels;
      this.updateChannelsStore();
    });
  };

  updateChannelsStore() {
    const channels = this.hydratedChannels;
    const bannedUserIDs = this.bannedUserIDs;
    if (channels && bannedUserIDs) {
      const sortedChannels = channels.sort(function (a, b) {
        if (!a.lastMessageDate) {
          return 1;
        }
        if (!b.lastMessageDate) {
          return -1;
        }
        a = new Date(a.lastMessageDate.seconds);
        b = new Date(b.lastMessageDate.seconds);
        return a > b ? -1 : a < b ? 1 : 0;
      });
      this.reduxStore.dispatch(
        setChannels(
          this.channelsWithNoBannedUsers(sortedChannels, bannedUserIDs),
        ),
      );
    }
  }

  channelsWithNoBannedUsers = (channels, bannedUserIDs) => {
    const channelsWithNoBannedUsers = [];
    channels.forEach((channel) => {
      if (
        channel.participants &&
        channel.participants.length > 0 &&
        (!bannedUserIDs ||
          channel.participants.length != 1 ||
          !bannedUserIDs.includes(channel.participants[0].id))
      ) {
        channelsWithNoBannedUsers.push(channel);
      }
    });
    return channelsWithNoBannedUsers;
  };

  purgeBannedUsers() {
    const state = this.reduxStore.getState();
    const bannedUserIDs = this.bannedUserIDs;
    if (bannedUserIDs) {
      const users = state.auth.users.filter(
        (user) => !bannedUserIDs.includes(user.id),
      );
      this.reduxStore.dispatch(setUsers(users));
    }
  }
}
