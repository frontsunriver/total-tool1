import { combineReducers } from 'redux';
import { createNavigationReducer } from 'react-navigation-redux-helpers';
import { RootNavigator } from '../navigations/AppNavigation';
import { auth } from '../Core/onboarding/redux/auth';
import { chat } from '../Core/chat/redux';
import { userReports } from '../Core/user-reporting/redux';
import { dating } from './reducers';
import { audioVideoChat } from '../Core/chat/audioVideo/redux';
import { inAppPurchase } from '../Core/inAppPurchase/redux';

const navReducer = createNavigationReducer(RootNavigator);

const AppReducer = combineReducers({
  nav: navReducer,
  auth,
  userReports,
  chat,
  dating,
  audioVideoChat,
  inAppPurchase,
});

export default AppReducer;
