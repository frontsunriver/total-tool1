import PropTypes from 'prop-types';
import React, { Component } from 'react';
import { connect, ReactReduxContext } from 'react-redux';
import IMConversationList from '../IMConversationList';
import ChannelsTracker from '../firebase/channelsTracker';

class IMConversationListView extends Component {
  static contextType = ReactReduxContext;

  constructor(props) {
    super(props);
    this.state = {
      appStyles:
        (props.navigation &&
          props.navigation.state &&
          props.navigation.state.params &&
          props.navigation.state.params.appStyles) ||
        props.navigation.getParam('appStyles') ||
        props.appStyles,
    };
  }

  componentDidMount() {
    const self = this;
    const userId = self.props.user.id || self.props.user.userID;

    this.channelsTracker = new ChannelsTracker(this.context.store, userId);
    this.channelsTracker.subscribeIfNeeded();
  }

  componentWillUnmount() {
    this.channelsTracker.unsubscribe();
  }

  onConversationPress = (channel) => {
    this.props.navigation.navigate('PersonalChat', {
      channel,
      appStyles: this.state.appStyles,
    });
  };

  render() {
    return (
      <IMConversationList
        loading={this.props.channels == null}
        conversations={this.props.channels}
        onConversationPress={this.onConversationPress}
        appStyles={this.state.appStyles}
        emptyStateConfig={this.props.emptyStateConfig}
        user={this.props.user}
      />
    );
  }
}

IMConversationListView.propTypes = {
  channels: PropTypes.array,
};

const mapStateToProps = ({ chat, auth }) => {
  return {
    channels: chat.channels,
    user: auth.user,
  };
};

export default connect(mapStateToProps)(IMConversationListView);
