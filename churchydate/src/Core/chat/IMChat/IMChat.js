import React, { useState, useRef } from 'react';
import { Alert, SafeAreaView, View } from 'react-native';
import PropTypes from 'prop-types';
import ActionSheet from 'react-native-actionsheet';
import { KeyboardAwareView } from 'react-native-keyboard-aware-view';
import TNMediaViewerModal from '../../truly-native/TNMediaViewerModal';
import DialogInput from 'react-native-dialog-input';
import BottomInput from './BottomInput';
import MessageThread from './MessageThread';
import dynamicStyles from './styles';
import { useColorScheme } from 'react-native-appearance';
import { IMLocalized } from '../../localization/IMLocalization';

const TrackInteractive = true;

function IMChat(props) {
  const {
    onSendInput,
    onAudioRecordSend,
    thread,
    inputValue,
    onChangeTextInput,
    user,
    inReplyToItem,
    onLaunchCamera,
    onOpenPhotos,
    onAddMediaPress,
    uploadProgress,
    sortMediafromThread,
    isMediaViewerOpen,
    selectedMediaIndex,
    onChatMediaPress,
    onMediaClose,
    onChangeName,
    isRenameDialogVisible,
    groupSettingsActionSheetRef,
    privateSettingsActionSheetRef,
    showRenameDialog,
    onLeave,
    appStyles,
    onUserBlockPress,
    onUserReportPress,
    onSenderProfilePicturePress,
    onReplyActionPress,
    onReplyingToDismiss,
  } = props;

  const colorScheme = useColorScheme();
  const styles = dynamicStyles(appStyles, colorScheme);

  const [channel] = useState({});
  const [temporaryInReplyToItem, setTemporaryInReplyToItem] = useState(null);

  const photoUploadDialogRef = useRef();
  const longPressActionSheetRef = useRef();

  const onChangeText = (text) => {
    onChangeTextInput(text);
  };

  const onAudioRecordDone = (item) => {
    onAudioRecordSend(item);
  };

  const onSend = () => {
    onSendInput();
  };

  const onPhotoUploadDialogDone = (index) => {
    if (index == 0) {
      onLaunchCamera();
    }

    if (index == 1) {
      onOpenPhotos();
    }
  };

  const onGroupSettingsActionDone = (index) => {
    if (index == 0) {
      showRenameDialog(true);
    } else if (index == 1) {
      onLeave();
    }
  };

  const onPrivateSettingsActionDone = (index) => {
    if (index == 2) {
      return;
    }
    var message, actionCallback;
    if (index == 0) {
      actionCallback = onUserBlockPress;
      message = IMLocalized(
        "Are you sure you want to block this user? You won't see their messages again.",
      );
    } else if (index == 1) {
      actionCallback = onUserReportPress;
      message = IMLocalized(
        "Are you sure you want to report this user? You won't see their messages again.",
      );
    }
    Alert.alert(IMLocalized('Are you sure?'), message, [
      {
        text: IMLocalized('Yes'),
        onPress: actionCallback,
      },
      {
        text: IMLocalized('Cancel'),
        style: 'cancel',
      },
    ]);
  };

  const onMessageLongPress = (inReplyToItem) => {
    setTemporaryInReplyToItem(inReplyToItem);
    longPressActionSheetRef.current.show();
  };

  const onReplyPress = (index) => {
    if (index == 0) {
      onReplyActionPress && onReplyActionPress(temporaryInReplyToItem);
    }
  };

  return (
    <SafeAreaView style={styles.personalChatContainer}>
      <MessageThread
        // keyboardDismissMode={TrackInteractive ? 'interactive' : 'none'}
        thread={thread}
        user={user}
        appStyles={appStyles}
        onChatMediaPress={onChatMediaPress}
        onSenderProfilePicturePress={onSenderProfilePicturePress}
        onMessageLongPress={onMessageLongPress}
      />
      <BottomInput
        uploadProgress={uploadProgress}
        value={inputValue}
        onAudioRecordDone={onAudioRecordDone}
        onChangeText={onChangeText}
        onSend={onSend}
        appStyles={appStyles}
        trackInteractive={TrackInteractive}
        onAddMediaPress={() => onAddMediaPress(photoUploadDialogRef)}
        inReplyToItem={inReplyToItem}
        onReplyingToDismiss={onReplyingToDismiss}
      />
      <ActionSheet
        title={IMLocalized('Group Settings')}
        options={[
          IMLocalized('Rename Group'),
          IMLocalized('Leave Group'),
          IMLocalized('Cancel'),
        ]}
        cancelButtonIndex={2}
        destructiveButtonIndex={1}
      />
      <ActionSheet
        title={'Are you sure?'}
        options={['Confirm', 'Cancel']}
        cancelButtonIndex={1}
        destructiveButtonIndex={0}
      />
      <DialogInput
        isDialogVisible={isRenameDialogVisible}
        title={IMLocalized('Change Name')}
        hintInput={channel.name}
        textInputProps={{ selectTextOnFocus: true }}
        submitText={IMLocalized('OK')}
        submitInput={onChangeName}
        closeDialog={() => {
          showRenameDialog(false);
        }}
      />
      <ActionSheet
        ref={photoUploadDialogRef}
        title={IMLocalized('Photo Upload')}
        options={[
          IMLocalized('Launch Camera'),
          IMLocalized('Open Photo Gallery'),
          IMLocalized('Cancel'),
        ]}
        cancelButtonIndex={2}
        onPress={onPhotoUploadDialogDone}
      />
      <ActionSheet
        ref={groupSettingsActionSheetRef}
        title={IMLocalized('Group Settings')}
        options={[
          IMLocalized('Rename Group'),
          IMLocalized('Leave Group'),
          IMLocalized('Cancel'),
        ]}
        cancelButtonIndex={2}
        destructiveButtonIndex={1}
        onPress={onGroupSettingsActionDone}
      />
      <ActionSheet
        ref={privateSettingsActionSheetRef}
        title={IMLocalized('Actions')}
        options={[
          IMLocalized('Block user'),
          IMLocalized('Report user'),
          IMLocalized('Cancel'),
        ]}
        cancelButtonIndex={2}
        onPress={onPrivateSettingsActionDone}
      />
      <ActionSheet
        ref={longPressActionSheetRef}
        title={IMLocalized('Actions')}
        options={[IMLocalized('Reply'), IMLocalized('Cancel')]}
        cancelButtonIndex={1}
        onPress={onReplyPress}
      />
      <TNMediaViewerModal
        mediaItems={sortMediafromThread}
        isModalOpen={isMediaViewerOpen}
        onClosed={onMediaClose}
        selectedMediaIndex={selectedMediaIndex}
      />
    </SafeAreaView>
  );
}

IMChat.propTypes = {
  onSendInput: PropTypes.func,
  onChangeName: PropTypes.func,
  onChangeTextInput: PropTypes.func,
  onLaunchCamera: PropTypes.func,
  onOpenPhotos: PropTypes.func,
  onAddMediaPress: PropTypes.func,
  user: PropTypes.object,
  uploadProgress: PropTypes.number,
  isMediaViewerOpen: PropTypes.bool,
  isRenameDialogVisible: PropTypes.bool,
  selectedMediaIndex: PropTypes.number,
  onChatMediaPress: PropTypes.func,
  onMediaClose: PropTypes.func,
  showRenameDialog: PropTypes.func,
  onLeave: PropTypes.func,
};

export default IMChat;
