import React from 'react';
import { SafeAreaView } from 'react-native';

import dynamicStyles from './styles';
import { useColorScheme } from 'react-native-appearance';
import Tab from './Tab';

export const tabBarBuilder = (tabIcons, appStyles) => {
  return (props) => {
    const { navigation } = props;
    const colorScheme = useColorScheme();
    const styles = dynamicStyles(appStyles, colorScheme);
    return (
      <SafeAreaView style={styles.tabBarContainer}>
        {navigation.state.routes.map((route, index) => {
          return (
            <Tab
              key={index + ''}
              route={route}
              tabIcons={tabIcons}
              appStyles={appStyles}
              focus={navigation.state.index === index}
              onPress={() => navigation.navigate(route.routeName)}
            />
          );
        })}
      </SafeAreaView>
    );
  };
};

export default tabBarBuilder;
