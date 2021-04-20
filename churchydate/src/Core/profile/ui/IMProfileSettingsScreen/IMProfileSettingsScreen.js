import React, { Component } from 'react';
import { BackHandler } from 'react-native';
import { connect } from 'react-redux';
import IMProfileSettings from '../components/IMProfileSettings/IMProfileSettings';
import { logout } from '../../../onboarding/redux/auth';
import { IMLocalized } from '../../../localization/IMLocalization';

class IMProfileSettingsScreen extends Component {
  static navigationOptions = ({ screenProps, navigation }) => {
    let appStyles = navigation.state.params.appStyles;
    let currentTheme = appStyles.navThemeConstants[screenProps.theme];

    return {
      headerTitle: IMLocalized('Profile Settings'),
      headerStyle: {
        backgroundColor: currentTheme.backgroundColor,
        borderBottomColor: currentTheme.hairlineColor,
      },
      headerTintColor: currentTheme.fontColor,
    };
  };

  constructor(props) {
    super(props);
    this.didFocusSubscription = props.navigation.addListener(
      'didFocus',
      (payload) =>
        BackHandler.addEventListener(
          'hardwareBackPress',
          this.onBackButtonPressAndroid,
        ),
    );
    this.lastScreenTitle = this.props.navigation.getParam('lastScreenTitle');
    this.appStyles = this.props.navigation.getParam('appStyles');
    this.appConfig = this.props.navigation.getParam('appConfig');
    if (!this.lastScreenTitle) {
      this.lastScreenTitle = 'Profile';
    }
  }

  componentDidMount() {
    this.willBlurSubscription = this.props.navigation.addListener(
      'willBlur',
      (payload) =>
        BackHandler.removeEventListener(
          'hardwareBackPress',
          this.onBackButtonPressAndroid,
        ),
    );
  }

  componentWillUnmount() {
    this.didFocusSubscription && this.didFocusSubscription.remove();
    this.willBlurSubscription && this.willBlurSubscription.remove();
  }

  onBackButtonPressAndroid = () => {
    this.props.navigation.goBack();
    return true;
  };

  onLogout = () => {
    this.props.logout();
  };

  render() {
    return (
      <IMProfileSettings
        navigation={this.props.navigation}
        onLogout={this.onLogout}
        lastScreenTitle={this.lastScreenTitle}
        user={this.props.user}
        appStyles={this.appStyles}
        appConfig={this.appConfig}
      />
    );
  }
}

IMProfileSettingsScreen.propTypes = {};

const mapStateToProps = ({ auth }) => {
  return {
    user: auth.user,
  };
};

export default connect(mapStateToProps, {
  logout,
})(IMProfileSettingsScreen);
