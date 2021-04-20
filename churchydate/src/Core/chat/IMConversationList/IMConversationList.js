import React, { memo } from 'react';
import PropTypes from 'prop-types';
import { ScrollView, View, FlatList, ActivityIndicator } from 'react-native';

import IMConversationView from '../IMConversationView';
import dynamicStyles from './styles';
import { useColorScheme } from 'react-native-appearance';
import { IMLocalized } from '../../localization/IMLocalization';
import { TNEmptyStateView } from '../../truly-native';

const IMConversationList = memo((props) => {
  const {
    onConversationPress,
    emptyStateConfig,
    conversations,
    loading,
    user,
    appStyles,
  } = props;
  const colorScheme = useColorScheme();
  const styles = dynamicStyles(appStyles, colorScheme);
  const formatMessage = (item) => {
    if (item?.lastMessage?.mime?.startsWith('video')) {
      return IMLocalized('Someone sent a video.');
    } else if (item?.lastMessage?.mime?.startsWith('audio')) {
      return IMLocalized('Someone sent an audio.');
    } else if (item?.lastMessage?.mime?.startsWith('image')) {
      return IMLocalized('Someone sent a photo.');
    } else if (item?.lastMessage) {
      return item.lastMessage;
    }
    return '';
  };

  const renderConversationView = ({ item }) => (
    <IMConversationView
      formatMessage={formatMessage}
      onChatItemPress={onConversationPress}
      item={item}
      appStyles={appStyles}
      user={user}
    />
  );

  if (loading) {
    return (
      <View style={styles.container}>
        <ActivityIndicator style={{ marginTop: 15 }} size="small" />
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <ScrollView
        style={styles.container}
        showsHorizontalScrollIndicator={false}
        showsVerticalScrollIndicator={false}>
        <View style={styles.chatsChannelContainer}>
          {conversations && conversations.length > 0 && (
            <FlatList
              vertical={true}
              showsHorizontalScrollIndicator={false}
              showsVerticalScrollIndicator={false}
              data={conversations}
              renderItem={renderConversationView}
              keyExtractor={(item) => `${item.id}`}
              removeClippedSubviews={true}
            />
          )}
          {conversations && conversations.length <= 0 && (
            <View style={styles.emptyViewContainer}>
              <TNEmptyStateView
                emptyStateConfig={emptyStateConfig}
                appStyles={appStyles}
              />
            </View>
          )}
        </View>
      </ScrollView>
    </View>
  );
});

IMConversationList.propTypes = {
  onConversationPress: PropTypes.func,
  conversations: PropTypes.array,
};

export default IMConversationList;
