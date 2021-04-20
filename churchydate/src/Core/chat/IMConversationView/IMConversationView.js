import React from 'react';
import { View, Text, TouchableOpacity } from 'react-native';
import { useColorScheme } from 'react-native-appearance';
import PropTypes from 'prop-types';
import IMConversationIconView from './IMConversationIconView/IMConversationIconView';
import { timeFormat } from '../..';
import dynamicStyles from './styles';

function IMConversationView(props) {
  const { onChatItemPress, formatMessage, item, user, appStyles } = props;
  const colorScheme = useColorScheme();
  const styles = dynamicStyles(appStyles, colorScheme);

  const userID = user.userID || user.id;

  let title = item.name;
  if (!title) {
    if (item.participants.length > 0) {
      let friend = item.participants[0];
      title = friend.firstName + ' ' + friend.lastName;
    }
  }

  const getIsRead = () => {
    return item.readUserIDs?.includes(userID);
  };

  return (
    <TouchableOpacity
      onPress={() => onChatItemPress(item)}
      style={styles.chatItemContainer}>
      <IMConversationIconView
        participants={item.participants}
        appStyles={appStyles}
      />
      <View style={styles.chatItemContent}>
        <Text
          style={[styles.chatFriendName, !getIsRead() && styles.unReadmessage]}>
          {title}
        </Text>
        <View style={styles.content}>
          <Text
            numberOfLines={1}
            ellipsizeMode={'middle'}
            style={[styles.message, !getIsRead() && styles.unReadmessage]}>
            {formatMessage(item)} {' · '}
            <Text
              numberOfLines={1}
              ellipsizeMode={'middle'}
              style={[styles.message, !getIsRead() && styles.unReadmessage]}>
              {timeFormat(item.lastMessageDate)}
            </Text>
          </Text>
        </View>
      </View>
    </TouchableOpacity>
  );
}

IMConversationView.propTypes = {
  formatMessage: PropTypes.func,
  item: PropTypes.object,
  onChatItemPress: PropTypes.func,
};

export default IMConversationView;
