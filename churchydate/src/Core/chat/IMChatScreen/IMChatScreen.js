import PropTypes from 'prop-types';
import React, { Component } from 'react';
import { connect } from 'react-redux';
import { Platform, Alert, BackHandler, Linking } from 'react-native';
import ImagePicker from 'react-native-image-crop-picker';
import { IMIconButton } from '../../truly-native';
import IMChat from '../IMChat/IMChat';
import { channelManager } from '../firebase';
import { firebaseStorage } from '../../firebase/storage';
import { reportingManager } from '../../user-reporting';
import { IMLocalized } from '../../localization/IMLocalization';
import { notificationManager } from '../../notifications';
import { setMediaChatReceivers } from '../audioVideo/redux';
import IMAudioVideoChat from '../audioVideo/IMAudioVideoChat';
import sendCallInitiationRemoteNotification from '../audioVideo/pushKit/sendCallInitiationRemoteNotification';

class IMChatScreen extends Component {
  static navigationOptions = ({ screenProps, navigation }) => {
    const options = {};
    let appStyles = navigation.state.params.appStyles;
    let channel = navigation.state.params.channel;
    let currentTheme = appStyles.navThemeConstants[screenProps.theme];
    let title = channel.name;

    if (!title) {
      title = channel.participants[0].firstName
        ? channel.participants[0].firstName
        : channel.participants[0].fullname;
    }

    options.headerTitle = title;
    options.headerStyle = {
      backgroundColor: currentTheme.backgroundColor,
    };
    options.headerTintColor = currentTheme.fontColor;
    options.headerRight = (
      <>
        <IMIconButton
          source={require('../assets/settings-icon.png')}
          tintColor={appStyles.styleSet.backArrowStyle.tintColor}
          onPress={navigation.state.params?.onSettingsPress}
          marginRight={15}
          width={20}
          height={20}
        />

        <IMIconButton
          source={require('../assets/call.png')}
          tintColor={appStyles.styleSet.backArrowStyle.tintColor}
          onPress={navigation.state.params?.onAudioChat}
          marginRight={15}
          width={20}
          height={20}
        />
        <IMIconButton
          source={require('../assets/video-camera-filled.png')}
          tintColor={appStyles.styleSet.backArrowStyle.tintColor}
          onPress={navigation.state.params?.onVideoChat}
          marginRight={15}
          width={20}
          height={20}
        />
      </>
    );
    return options;
  };

  constructor(props) {
    super(props);
    this.channel = this.props.navigation.getParam('channel');
    this.appStyles = this.props.navigation.getParam('appStyles');
    this.state = {
      thread: [],
      inputValue: '',
      channel: this.channel,
      downloadUrl: '',
      uploadProgress: 0,
      isMediaViewerOpen: false,
      isRenameDialogVisible: false,
      selectedMediaIndex: null,
      inReplyToItem: null,
    };
    this.didFocusSubscription = props.navigation.addListener(
      'didFocus',
      (payload) =>
        BackHandler.addEventListener(
          'hardwareBackPress',
          this.onBackButtonPressAndroid,
        ),
    );

    this.groupSettingsActionSheetRef = React.createRef();
    this.privateSettingsActionSheetRef = React.createRef();
  }

  componentDidMount() {
    this.props.navigation.setParams({
      onSettingsPress: this.onSettingsPress,
      onVideoChat: this.onVideoChat,
      onAudioChat: this.onAudioChat,
    });
    this.willBlurSubscription = this.props.navigation.addListener(
      'willBlur',
      (payload) =>
        BackHandler.removeEventListener(
          'hardwareBackPress',
          this.onBackButtonPressAndroid,
        ),
    );
    this.threadUnsubscribe = channelManager.subscribeThreadSnapshot(
      this.channel,
      this.onThreadCollectionUpdate,
    );
    this.markThreadItemAsReadIfShould(this.channel);
  }

  componentDidUpdate(prevProps, prevState) {
    if (prevProps.channels !== this.props.channels) {
      const updatedChannel = this.props.channels.find(
        (channel) => channel.id === this.channel.id,
      );

      updatedChannel && this.markThreadItemAsReadIfShould(updatedChannel);
    }
  }

  componentWillUnmount() {
    this.threadUnsubscribe();
    this.didFocusSubscription && this.didFocusSubscription.remove();
    this.willBlurSubscription && this.willBlurSubscription.remove();
  }

  onBackButtonPressAndroid = () => {
    this.props.navigation.goBack();
    return true;
  };

  onVideoChat = async () => {
    await this.props.setMediaChatReceivers({
      receivers: this.channel.participants,
      channelId: this.channel.id,
      channelTitle: this.channel.name || '',
      type: 'video',
    });
    IMAudioVideoChat.showVideoChatModal();
    sendCallInitiationRemoteNotification(
      this.props.user,
      this.channel.participants,
      'video',
      this.channel.id,
      this.channel.name,
    );
  };

  onAudioChat = async () => {
    await this.props.setMediaChatReceivers({
      receivers: this.channel.participants,
      channelId: this.channel.id,
      channelTitle: this.channel.name || '',
      type: 'audio',
    });
    IMAudioVideoChat.showAudioChatModal();
    sendCallInitiationRemoteNotification(
      this.props.user,
      this.channel.participants,
      'video',
      this.channel.id,
      this.channel.name,
    );
  };

  onSettingsPress = () => {
    if (this.state.channel.participants.length > 1) {
      this.groupSettingsActionSheetRef.current.show();
    } else {
      this.privateSettingsActionSheetRef.current.show();
    }
  };

  onChangeName = (text) => {
    this.showRenameDialog(false);

    const channel = { ...this.state.channel };
    delete channel.participants;
    channel.name = text;

    channelManager.onRenameGroup(
      text,
      channel,
      ({ success, error, newChannel }) => {
        if (success) {
          this.setState({ channel: newChannel });
          this.props.navigation.setParams({
            channel: newChannel,
          });
        }

        if (error) {
          alert(error);
        }
      },
    );
  };

  onLeave = () => {
    Alert.alert(
      IMLocalized(`Leave ${this.state.channel.name || 'group'}`),
      IMLocalized('Are you sure you want to leave this group?'),
      [
        {
          text: 'Yes',
          onPress: this.onLeaveDecided,
          style: 'destructive',
        },
        { text: 'No' },
      ],
      { cancelable: false },
    );
  };

  onLeaveDecided = () => {
    channelManager.onLeaveGroup(
      this.state.channel.id,
      this.props.user.id,
      ({ success, error }) => {
        if (success) {
          this.props.navigation.goBack(null);
        }

        if (error) {
          alert(error);
        }
      },
    );
  };

  showRenameDialog = (show) => {
    this.setState({ isRenameDialogVisible: show });
  };

  markThreadItemAsReadIfShould = (channel) => {
    const { user } = this.props;
    const {
      id: channelID,
      lastThreadMessageId,
      readUserIDs,
      participants,
      lastMessage,
    } = channel;
    const userID = user.id || user.userID;
    const isRead = readUserIDs?.includes(userID);

    if (!isRead && channelID && lastMessage) {
      const newReadUserIDs = readUserIDs ? [...readUserIDs, userID] : [userID];

      channelManager.markChannelThreadItemAsRead(
        channelID,
        lastThreadMessageId,
        newReadUserIDs,
        participants,
      );
    }
  };

  onThreadCollectionUpdate = (querySnapshot) => {
    const data = [];
    querySnapshot.forEach((doc) => {
      const message = doc.data();
      data.push({ ...message, id: doc.id });
    });

    this.setState({ thread: data });
  };

  onChangeTextInput = (text) => {
    this.setState({
      inputValue: text,
    });
  };

  createOne2OneChannel = () => {
    const self = this;
    return new Promise((resolve) => {
      channelManager
        .createChannel(self.props.user, self.state.channel.participants)
        .then((response) => {
          self.setState({ channel: response.channel });
          self.threadUnsubscribe = channelManager.subscribeThreadSnapshot(
            response.channel,
            self.onThreadCollectionUpdate,
          );
          resolve(response.channel);
        });
    });
  };

  onSendInput = async () => {
    const self = this;
    if (
      this.state.thread.length > 0 ||
      this.state.channel.participants.length > 1
    ) {
      self.sendMessage();
      return;
    }

    // If we don't have a chat id, we need to create it first together with the participations
    this.createOne2OneChannel().then((_response) => {
      self.sendMessage();
    });
  };

  sendMessage = () => {
    const self = this;
    const inputValue = this.state.inputValue;
    const downloadURL = this.state.downloadUrl;
    const inReplyToItem = this.state.inReplyToItem;
    const participants = this.channel.participants;
    self.setState({
      inputValue: '',
      downloadUrl: '',
      inReplyToItem: null,
    });
    channelManager
      .sendMessage(
        this.props.user,
        this.state.channel,
        inputValue,
        downloadURL,
        inReplyToItem,
        participants,
      )
      .then((response) => {
        if (response.error) {
          alert(error);
          self.setState({
            inputValue: inputValue,
            downloadUrl: downloadURL,
            inReplyToItem: inReplyToItem,
          });
        } else {
          self.broadcastPushNotifications(inputValue, downloadURL);
        }
      });
  };

  broadcastPushNotifications = (inputValue, downloadURL) => {
    const channel = this.state.channel;
    const participants = channel.participants;
    if (!participants || participants.length == 0) {
      return;
    }
    const sender = this.props.user;
    const isGroupChat = channel.name && channel.name.length > 0;
    const fromTitle = isGroupChat
      ? channel.name
      : sender.firstName + ' ' + sender.lastName;
    var message;
    if (isGroupChat) {
      if (downloadURL) {
        if (downloadURL.mime && downloadURL.mime.startsWith('video')) {
          message =
            sender.firstName +
            ' ' +
            sender.lastName +
            ' ' +
            IMLocalized('sent a video.');
        } else {
          message =
            sender.firstName +
            ' ' +
            sender.lastName +
            ' ' +
            IMLocalized('sent a photo.');
        }
      } else {
        message = sender.firstName + ' ' + sender.lastName + ': ' + inputValue;
      }
    } else {
      if (downloadURL) {
        if (downloadURL.mime && downloadURL.mime.startsWith('video')) {
          message = sender.firstName + ' ' + IMLocalized('sent you a video.');
        } else {
          message = sender.firstName + ' ' + IMLocalized('sent you a photo.');
        }
      } else {
        message = inputValue;
      }
    }

    participants.forEach((participant) => {
      if (participant.id != this.props.user.id) {
        notificationManager.sendPushNotification(
          participant,
          fromTitle,
          message,
          'chat_message',
          { channelID: this.state.channel.id },
        );
      }
    });
  };

  onAddMediaPress = (photoUploadDialogRef) => {
    photoUploadDialogRef.current.show();
  };

  onAudioRecordSend = (audioRecord) => {
    this.startUpload({ ...audioRecord, source: audioRecord.uri });
  };

  onLaunchCamera = () => {
    const self = this;
    const { id, firstName, profilePictureURL } = this.props.user;

    ImagePicker.openCamera({
      cropping: false,
    })
      .then((image) => {
        const source = image.path;
        const mime = image.mime;

        const data = {
          content: '',
          created: channelManager.currentTimestamp(),
          senderFirstName: firstName,
          senderID: id,
          senderLastName: '',
          senderProfilePictureURL: profilePictureURL,
          url: 'http://fake',
        };

        self.startUpload({ source, mime }, data);
      })
      .catch(function (error) {
        console.log(error);
        self.setState({ loading: false });
      });
  };

  onOpenPhotos = () => {
    const { id, firstName, profilePictureURL } = this.props.user;
    const self = this;

    ImagePicker.openPicker({
      cropping: false,
      multiple: false,
    })
      .then((image) => {
        const source = image.path;
        const mime = image.mime;

        const data = {
          content: '',
          created: channelManager.currentTimestamp(),
          senderFirstName: firstName,
          senderID: id,
          senderLastName: '',
          senderProfilePictureURL: profilePictureURL,
          url: 'http://fake',
        };

        self.startUpload({ source, mime }, data);
      })
      .catch(function (error) {
        console.log(error);
        self.setState({ loading: false });
      });
  };

  startUpload = (uploadData, data) => {
    const { source, mime } = uploadData;
    const self = this;

    const filename =
      new Date() + '-' + source.substring(source.lastIndexOf('/') + 1);
    const uploadUri =
      Platform.OS === 'ios' ? source.replace('file://', '') : source;

    firebaseStorage.uploadFileWithProgressTracking(
      filename,
      uploadUri,
      async (snapshot) => {
        const uploadProgress =
          (snapshot.bytesTransferred / snapshot.totalBytes) * 100;
        self.setState({ uploadProgress });
      },
      async (url) => {
        if (url) {
          self.setState(
            {
              downloadUrl: { ...uploadData, source: url, uri: url, url, mime },
              uploadProgress: 0,
            },
            () => {
              self.onSendInput();
            },
          );
        }
      },
      (error) => {
        self.setState({ uploadProgress: 0 });
        alert(IMLocalized('Oops! An error has occurred. Please try again.'));
        console.log(error);
      },
    );
  };

  sortMediafromThread = () => {
    this.imagesUrl = [];
    this.images = [];

    this.state.thread.forEach((item) => {
      if (item.url && item.url != '') {
        if (item.url.mime && item.url.mime.startsWith('image')) {
          this.imagesUrl.push(item.url.url);
          this.images.push({
            id: item.id,
            url: item.url,
          });
        } else if (!item.url.mime && item.url.startsWith('https://')) {
          // To handle old format before video feature
          this.imagesUrl.push(item.url);
          this.images.push({
            id: item.id,
            url: item.url,
          });
        }
      }
    });

    return this.imagesUrl;
  };

  onChatMediaPress = (item) => {
    const index = this.images.findIndex((image) => {
      return image.id === item.id;
    });

    this.setState({
      selectedMediaIndex: index,
      isMediaViewerOpen: true,
    });
  };

  onMediaClose = () => {
    this.setState({ isMediaViewerOpen: false });
  };

  onUserBlockPress = () => {
    this.reportAbuse('block');
  };

  onUserReportPress = () => {
    this.reportAbuse('report');
  };

  reportAbuse = (type) => {
    const participants = this.state.channel.participants;
    if (!participants || participants.length != 1) {
      return;
    }
    const myID = this.props.user.id;
    const otherUserID = participants[0].id || participants[0].userID;
    reportingManager.markAbuse(myID, otherUserID, type).then((response) => {
      if (!response.error) {
        this.props.navigation.goBack(null);
      }
    });
  };

  onReplyActionPress = (inReplyToItem) => {
    this.setState({ inReplyToItem });
  };

  onReplyingToDismiss = () => {
    this.setState({ inReplyToItem: null });
  };

  render() {
    return (
      <IMChat
        appStyles={this.appStyles}
        user={this.props.user}
        thread={this.state.thread}
        inputValue={this.state.inputValue}
        inReplyToItem={this.state.inReplyToItem}
        onAddMediaPress={this.onAddMediaPress}
        onSendInput={this.onSendInput}
        onAudioRecordSend={this.onAudioRecordSend}
        onChangeTextInput={this.onChangeTextInput}
        onLaunchCamera={this.onLaunchCamera}
        onOpenPhotos={this.onOpenPhotos}
        uploadProgress={this.state.uploadProgress}
        sortMediafromThread={this.sortMediafromThread()}
        isMediaViewerOpen={this.state.isMediaViewerOpen}
        selectedMediaIndex={this.state.selectedMediaIndex}
        onChatMediaPress={this.onChatMediaPress}
        onMediaClose={this.onMediaClose}
        isRenameDialogVisible={this.state.isRenameDialogVisible}
        groupSettingsActionSheetRef={this.groupSettingsActionSheetRef}
        privateSettingsActionSheetRef={this.privateSettingsActionSheetRef}
        showRenameDialog={this.showRenameDialog}
        onChangeName={this.onChangeName}
        onLeave={this.onLeave}
        onUserBlockPress={this.onUserBlockPress}
        onUserReportPress={this.onUserReportPress}
        onReplyActionPress={this.onReplyActionPress}
        onReplyingToDismiss={this.onReplyingToDismiss}
      />
    );
  }
}

IMChatScreen.propTypes = {
  thread: PropTypes.array,
  setChatThread: PropTypes.func,
  createThread: PropTypes.func,
  createChannel: PropTypes.func,
  user: PropTypes.object,
};

const mapStateToProps = ({ chat, auth }) => {
  return {
    user: auth.user,
    thread: chat.thread,
    channels: chat.channels,
  };
};

export default connect(mapStateToProps, { setMediaChatReceivers })(
  IMChatScreen,
);
