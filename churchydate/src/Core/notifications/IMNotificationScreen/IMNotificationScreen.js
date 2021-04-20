import React, { PureComponent } from 'react';
import { BackHandler } from 'react-native';
import { connect } from 'react-redux';
import IMNotification from '../Notification/IMNotification';
import { firebaseNotification } from '../../notifications';
import { setNotifications } from '../redux';
import AppStyles from '../../../AppStyles';

class IMNotificationScreen extends PureComponent {
  static navigationOptions = ({ screenProps }) => {
    let currentTheme = AppStyles.navThemeConstants[screenProps.theme];

    return {
      headerTitle: 'Notifications',
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
    if (!this.lastScreenTitle) {
      this.lastScreenTitle = 'Profile';
    }
    this.appStyles =
      this.props.navigation.state.params.appStyles ||
      this.props.navigation.getParam('appStyles') ||
      this.props.appStyles;
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
    this.notificationUnsubscribe = firebaseNotification.subscribeNotifications(
      this.props.user.id,
      this.onNotificationCollection,
    );
  }

  componentWillUnmount() {
    this.notificationUnsubscribe();
    this.didFocusSubscription && this.didFocusSubscription.remove();
    this.willBlurSubscription && this.willBlurSubscription.remove();
  }

  onBackButtonPressAndroid = () => {
    this.props.navigation.goBack();
    return true;
  };

  onNotificationCollection = (notifications) => {
    this.props.setNotifications(notifications);
  };

  onNotificationPress = async (notification) => {};

  render() {
    return (
      <IMNotification
        onNotificationPress={this.onNotificationPress}
        notifications={this.props.notifications}
        appStyles={this.appStyles}
      />
    );
  }
}

IMNotificationScreen.propTypes = {};

const mapStateToProps = ({ notifications, auth }) => {
  return {
    user: auth.user,
    notifications: notifications.notifications,
  };
};

export default connect(mapStateToProps, { setNotifications })(
  IMNotificationScreen,
);
