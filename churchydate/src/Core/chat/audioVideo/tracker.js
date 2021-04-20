import { DeviceEventEmitter } from 'react-native';
import {
  subscribeVideoChat,
  subscribeAudioChat,
  subscribeChatRoomParticipants,
  subscribeCallConnectionData,
  exitAudioVideoChatRoom,
  addChatRoomParticipants,
  addCallConnectionData,
  updateChatRoomStatus,
  cleanChatRoomParticipants,
  cleanSignalCollection,
} from './firebase';
import {
  setMediaChatReceivers,
  setIsMediaChatVisible,
  setMediaChatData,
  setCanRecieveMediaChatData,
} from './redux';
import messaging from '@react-native-firebase/messaging';

export default class MediaChatTracker {
  constructor(reduxStore, userID, chatTimeout) {
    this.reduxStore = reduxStore;
    this.userID = userID;
    this.chatTimeout = chatTimeout;
    this.state = reduxStore.getState();
    this.reduxStore.subscribe(this.syncTrackerToStore);
    this.isAudioChatVisible = false;
    this.isVideoChatVisible = false;
    this.callConnectionDataUnsubscribe = null;
  }

  syncTrackerToStore = () => {
    this.state = this.reduxStore.getState();
  };

  async subscribe(shouldClean = true) {
    if (shouldClean) {
      await cleanSignalCollection(this.userID);
    }

    this.videoModalSubscription = DeviceEventEmitter.addListener(
      'showVideoChatModal',
      this.displayVideoChat,
    );
    this.audioModalSubscription = DeviceEventEmitter.addListener(
      'showAudioChatModal',
      this.displayAudioChat,
    );
    this.videoChatUnsubscribe = subscribeVideoChat(
      this.userID,
      this.chatTimeout,
      this.onVideoChatDataUpdate,
    );
    this.audioChatUnsubscribe = subscribeAudioChat(
      this.userID,
      this.chatTimeout,
      this.onAudioChatDataUpdate,
    );
  }

  unsubscribe = () => {
    if (this.videoChatUnsubscribe) {
      this.videoChatUnsubscribe();
    }
    if (this.audioChatUnsubscribe) {
      this.audioChatUnsubscribe();
    }
    if (this.videoModalSubscription) {
      this.videoModalSubscription.remove();
    }
    if (this.audioModalSubscription) {
      this.audioModalSubscription.remove();
    }
  };

  subscribeChatRoomParticipants = (data, callback) => {
    this.chatRoomParticipantsUnsubscribe = subscribeChatRoomParticipants(
      data,
      (participants) => {
        callback(participants);
      },
    );
  };

  subscribeCallConnectionData = (data, callback) => {
    this.callConnectionDataUnsubscribe = subscribeCallConnectionData(
      data,
      (data) => {
        callback(data);
      },
    );
  };

  subscribeMessaging = (callback) => {
    this.unsubscribeMessaging = messaging().onMessage((remoteMessage) =>
      this.onMessaging(remoteMessage, callback),
    );
    messaging().setBackgroundMessageHandler((remoteMessage) =>
      this.onMessaging(remoteMessage, callback),
    );
  };

  onMessaging = async (remoteMessage, callback) => {
    if (remoteMessage.notification) {
      return;
    }

    const {
      data: { channelTitle, caller },
    } = remoteMessage;

    this.caller = caller;
    this.channelTitle = channelTitle;

    callback(remoteMessage);

    // const {
    //   data: {
    //     callerName,
    //     callId,
    //     callStatus,
    //     // type,
    //     // channelId,
    //     channelTitle,
    //     caller,
    //   },
    // } = remoteMessage;
    // const handled = ' ';
    // const handleType = 'generic';
    // const localizedCallerName = callerName;
    // this.currentCallId = callId;

    // console.log('remoteMessage==-=', remoteMessage);
    // this.caller = caller;
    // this.channelTitle = channelTitle;

    // if (callStatus === 'IncomingCall') {
    // await this.reduxStore.dispatch(
    //   setMediaChatReceivers({
    //     receivers: [caller],
    //     type,
    //     channelId,
    //     channelTitle,
    //     callStatus: 'IncomingCall',
    //   }),
    // ),

    // callback(remoteMessage);
    // RNCallKeep.displayIncomingCall(
    //   this.currentCallId,
    //   handled,
    //   localizedCallerName,
    //   handleType,
    //   true,
    // );
    // return;
    // }
    // if (callStatus === 'CallEnded') {
    //   this.hangup();
    //   return;
    // }
  };

  cleanChatRoomParticipants = (data) => {
    return cleanChatRoomParticipants(data);
  };

  addChatRoomParticipants = (data) => {
    addChatRoomParticipants(data);
  };

  addCallConnectionData = (data) => {
    addCallConnectionData(data);
  };

  updateChatRoomStatus = (channelId, status) => {
    updateChatRoomStatus(channelId, status);
  };

  unsubscribeChatRoomParticipants = async (channelId) => {
    if (this.callConnectionDataUnsubscribe) {
      await this.callConnectionDataUnsubscribe();
    }

    await exitAudioVideoChatRoom({ channelId, userId: this.userID });
    if (this.chatRoomParticipantsUnsubscribe) {
      await this.chatRoomParticipantsUnsubscribe();
    }
  };

  onVideoChatDataUpdate = async (data) => {
    if (this.isAudioChatVisible) {
      return;
    }

    this.onMediaChatDataUpdate(data);
  };

  onAudioChatDataUpdate = async (data) => {
    if (this.isVideoChatVisible) {
      return;
    }

    this.onMediaChatDataUpdate(data);
  };

  onMediaChatDataUpdate = async (data) => {
    if (data.length > 0) {
      const signalData = data[0];

      if (signalData.receiverId === this.userID) {
        await this.setMediaChatReceivers(signalData);
        if (signalData.status === 'cancel') {
          this.reduxStore.dispatch(setIsMediaChatVisible(false));
          return;
        }
        if (
          this.state.audioVideoChat.canReceiveMediaData &&
          signalData.status !== 'cancel'
        ) {
          await this.reduxStore.dispatch(setMediaChatData(signalData));
        }

        if (signalData.status === 'request') {
          await this.reduxStore.dispatch(setIsMediaChatVisible(true));
        }
      }
    }
  };

  setMediaChatReceivers = async (data) => {
    await this.reduxStore.dispatch(
      setMediaChatReceivers({
        receivers: data.receiver.length > 1 ? data.receiver : [data.sender],
        type: data.type,
        channelId: data.channelId,
        channelTitle: data.channelTitle,
      }),
    );
  };

  displayVideoChat = () => {
    this.isVideoChatVisible = true;
    this.displayMediaChat();
  };

  displayAudioChat = () => {
    this.isAudioChatVisible = true;
    this.displayMediaChat();
  };

  displayMediaChat = async () => {
    await this.reduxStore.dispatch(setMediaChatData(null));
    await this.reduxStore.dispatch(setIsMediaChatVisible(true));
  };

  onMediaChatDismiss = async () => {
    this.isVideoChatVisible = false;
    this.isAudioChatVisible = false;
    await this.reduxStore.dispatch(setMediaChatData(null));
    await this.reduxStore.dispatch(setIsMediaChatVisible(false));
    await this.reduxStore.dispatch(setCanRecieveMediaChatData(false));
    setTimeout(
      () => this.reduxStore.dispatch(setCanRecieveMediaChatData(true)),
      5000,
    );
  };
}
