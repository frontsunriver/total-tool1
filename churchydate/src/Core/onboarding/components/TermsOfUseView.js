import React from 'react';
import { Text, Linking, View } from 'react-native';
import { IMLocalized } from '../../localization/IMLocalization';

const TermsOfUseView = (props) => {
  const { tosLink, style } = props;
  return (
    <View style={style}>
      <Text style={{ fontSize: 12 }}>
        {IMLocalized('By creating an account you agree with our')}
      </Text>
      <Text
        style={{ color: 'blue', fontSize: 12 }}
        onPress={() => Linking.openURL(tosLink)}>
        {IMLocalized('Terms of Use')}
      </Text>
    </View>
  );
};

export default TermsOfUseView;
