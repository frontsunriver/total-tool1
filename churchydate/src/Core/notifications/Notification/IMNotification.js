import React from 'react';
import { FlatList, View } from 'react-native';

import IMNotificationItem from './IMNotificationItem';
import dynamicStyles from './styles';
import { useColorScheme } from 'react-native-appearance';

function IMNotification({ notifications, onNotificationPress, appStyles }) {
  const colorScheme = useColorScheme();
  const styles = dynamicStyles(appStyles, colorScheme);

  const renderItem = ({ item }) => (
    <IMNotificationItem
      onNotificationPress={onNotificationPress}
      appStyles={appStyles}
      item={item}
    />
  );

  return (
    <View style={styles.container}>
      <FlatList
        data={notifications}
        renderItem={renderItem}
        keyExtractor={(item) => item.id}
        removeClippedSubviews={true}
      />
    </View>
  );
}

IMNotification.propTypes = {};

export default IMNotification;
