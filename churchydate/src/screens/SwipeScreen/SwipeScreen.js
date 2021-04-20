import React, { useState, useEffect, useRef, useContext } from 'react';
import {
  StyleSheet,
  View,
  Alert,
  StatusBar,
  SafeAreaView,
  Platform,
  AppState,
  PermissionsAndroid, // eslint-disable-line react-native/split-platform-components
} from 'react-native';
import { useSelector, useDispatch, ReactReduxContext } from 'react-redux';
import Geolocation from '@react-native-community/geolocation';
import { firebase } from '../../Core/firebase/config';
import ActivityModal from '../../components/ActivityModal';
import Deck from '../../components/swipe/deck';
import NoMoreCard from '../../components/swipe/no_more_card';
import NewMatch from '../../components/swipe/newMatch';
import DynamicAppStyles from '../../DynamicAppStyles';
import DatingConfig from '../../DatingConfig';
import { setUserData } from '../../Core/onboarding/redux/auth';
import { isDatingProfileCompleteForUser } from '../../utils';
import { TNTouchableIcon } from '../../Core/truly-native';
import SwipeTracker from '../../firebase/tracker';
import { IMLocalized } from '../../Core/localization/IMLocalization';
import dynamicStyles from './styles';
import { useColorScheme } from 'react-native-appearance';
import { notificationManager } from '../../Core/notifications';
import IMAudioVideoChat from '../../Core/chat/audioVideo/IMAudioVideoChat';
import { useIap } from '../../Core/inAppPurchase/context';
import { getUserAwareCanUndoAsync } from '../../utils';

const SwipeScreen = (props) => {
  const colorScheme = useColorScheme();
  const styles = dynamicStyles(colorScheme);

  const { store } = useContext(ReactReduxContext);

  const { setSubscriptionVisible } = useIap();
  const user = useSelector((state) => state.auth.user);
  const swipes = useSelector((state) => state.dating.swipes);
  const bannedUserIDs = useSelector((state) => state.userReports.bannedUserIDs);
  const matches = useSelector((state) => state.dating.matches);
  const audioVideoChatConfig = useSelector((state) => state.audioVideoChat);
  const isPlanActive = useSelector((state) => state.inAppPurchase.isPlanActive);
  // const incomingSwipes = useSelector(state => state.dating.incomingSwipes);
  const dispatch = useDispatch();

  const [recommendations, setRecommendations] = useState([]);
  const [
    hasStartedFetchingFirstRecommendationsBatch,
    setHasStartedFetchingFirstRecommendationsBatch,
  ] = useState(false);
  const [showMode, setShowMode] = useState(0);
  const [currentMatchData, setCurrentMatchData] = useState(null);
  const [appState, setAppState] = useState(AppState.currentState);
  const [positionWatchID, setPositionWatchID] = useState(null);
  const [userSettingsDidChange, setUserSettingsDidChange] = useState(false);
  const [
    hasConsumedRecommendationsStream,
    setHasConsumedRecommendationsStream,
  ] = useState(false);
  const [hasValidatedCurrentProfile, setHasValidatedCurrentProfile] = useState(
    false,
  );
  const [canUserSwipe, setCanUserSwipe] = useState(false);

  const recommendationBatchLimit = 75;
  const swipeThreshold = 5;
  const usersRef = firebase.firestore().collection('users');
  var userRef = null;

  const userAwareCanUndo = useRef(false);
  const isLoadingRecommendations = useRef(false);
  const swipeCountDetail = useRef({});
  const didFocusSubscription = useRef(null);
  const swipeTracker = useRef(new SwipeTracker(store, user.id));
  const recommendationRef = useRef(
    usersRef.orderBy('id', 'desc').limit(recommendationBatchLimit),
  );

  useEffect(() => {
    StatusBar.setHidden(false);
    swipeTracker.current.subscribeIfNeeded();

    didFocusSubscription.current = props.navigation.addListener(
      'didFocus',
      (payload) => handleComponentDidFocus(),
    );

    AppState.addEventListener('change', handleAppStateChange);

    if (user) {
      userRef = usersRef.doc(user.id);
    }

    // if (!isDatingProfileCompleteForUser(user)) {
    //   handleIncompleteUserData();
    // } else {
    //   setHasValidatedCurrentProfile(true);
    // }

    getUserSwipeCount();

    watchPositionChange();

    return () => {
      didFocusSubscription.current && didFocusSubscription.current.remove();
      AppState.removeEventListener('change', handleAppStateChange);
      positionWatchID != null && Geolocation.clearWatch(positionWatchID);
      swipeTracker.current.unsubscribe();
    };
  }, []);

  useEffect(() => {
    if (matches != null) {
      // We retrieve all new matches and notify the user
      const unseenMatches = matches.filter((match) => !match.matchHasBeenSeen);
      if (unseenMatches.length > 0) {
        // Send push notification
        notificationManager.sendPushNotification(
          unseenMatches[0],
          IMLocalized('New match!'),
          IMLocalized('You just got a new match!'),
          'dating_match',
          { fromUser: user },
        );
        setCurrentMatchData(unseenMatches[0]);
      }
    }
  }, [matches]);

  useEffect(() => {
    if (currentMatchData) {
      swipeTracker.current.markSwipeAsSeen(currentMatchData, user);
      setShowMode(2);
    }
  }, [currentMatchData]);

  useEffect(() => {
    if (recommendations.length === 0 && swipes) {
      getMoreRecommendationsIfNeeded();
    }
  }, [swipes, recommendations]);

  const getUserSwipeCount = async () => {
    const userID = user.id || user.userID;

    const swipeCountInfo = await swipeTracker.current.getUserSwipeCount(userID);

    if (swipeCountInfo) {
      swipeCountDetail.current = swipeCountInfo;
    } else {
      resetSwipeCountDetail();
    }

    getCanUserSwipe(false);
  };

  const resetSwipeCountDetail = () => {
    swipeCountDetail.current = {
      count: 0,
      createdAt: {
        seconds: Date.now() / 1000,
      },
    };
  };

  const updateSwipeCountDetail = () => {
    const userID = user.id || user.userID;

    swipeTracker.current.updateUserSwipeCount(
      userID,
      swipeCountDetail.current.count,
    );
  };

  const getSwipeTimeDifference = (swipeCountDetail) => {
    let now = +new Date();
    let createdAt = +new Date();

    if (swipeCountDetail?.createdAt?.seconds) {
      createdAt = +new Date(swipeCountDetail.createdAt.seconds * 1000);
    }

    return now - createdAt;
  };

  const getCanUserSwipe = (shouldUpdate = true) => {
    if (isPlanActive) {
      setCanUserSwipe(true);

      return true;
    }

    const oneDay = 60 * 60 * 24 * 1000;

    const swipeTimeDifference = getSwipeTimeDifference(
      swipeCountDetail.current,
    );

    if (swipeTimeDifference > oneDay) {
      resetSwipeCountDetail();
      updateSwipeCountDetail();

      setCanUserSwipe(true);

      return true;
    }

    if (
      swipeTimeDifference < oneDay &&
      swipeCountDetail.current.count < DatingConfig.dailySwipeLimit
    ) {
      if (shouldUpdate) {
        swipeCountDetail.current.count += 1;
        updateSwipeCountDetail();
      }

      setCanUserSwipe(
        swipeCountDetail.current.count + 1 <= DatingConfig.dailySwipeLimit,
      );

      return true;
    }

    if (
      swipeTimeDifference < oneDay &&
      swipeCountDetail.current.count >= DatingConfig.dailySwipeLimit
    ) {
      setCanUserSwipe(false);

      return false;
    }
  };

  const handleAppStateChange = (nextAppState) => {
    if (appState.match(/inactive|background/) && nextAppState === 'active') {
      userRef
        .update({
          isOnline: true,
        })
        .then(() => {
          dispatch(setUserData({ user: { ...user, isOnline: true } }));
        })
        .then(() => {
          setAppState(nextAppState);
        })
        .catch((error) => {
          console.log(error);
        });
    } else {
      userRef
        .update({
          isOnline: false,
        })
        .then(() => {
          dispatch(setUserData({ user: { ...user, isOnline: false } }));
        })
        .then(() => {
          setAppState(nextAppState);
        })
        .catch((error) => {
          console.log(error);
        });
    }
  };

  const watchPositionChange = async () => {
    if (Platform.OS === 'ios') {
      setPositionWatchID(watchPosition());
    } else {
      handleAndroidLocationPermission();
    }
  };

  const handleAndroidLocationPermission = async () => {
    try {
      const granted = await PermissionsAndroid.request(
        PermissionsAndroid.PERMISSIONS.ACCESS_FINE_LOCATION,
        {
          title: IMLocalized('Instadating App'),
          message: IMLocalized(
            'Instadating App wants to access your location ',
          ),
        },
      );

      if (granted === PermissionsAndroid.RESULTS.GRANTED) {
        setPositionWatchID(watchPosition());
      } else {
        alert(
          IMLocalized(
            'Location permission denied. Turn on location to use the app.',
          ),
        );
      }
    } catch (err) {
      console.log(err);
    }
  };

  const watchPosition = () => {
    return Geolocation.watchPosition((position) => {
      const locationDict = {
        position: {
          // for legacy reasons
          latitude: position.coords.latitude,
          longitude: position.coords.longitude,
        },
        location: {
          latitude: position.coords.latitude,
          longitude: position.coords.longitude,
        },
      };
      userRef
        .update(locationDict)
        .then(() => {
          dispatch(setUserData({ user: { ...user, ...locationDict } }));
        })
        .catch((error) => {
          console.log(error);
        });
    });
  };

  const handleComponentDidFocus = () => {
    // if (userSettingsDidChange) {
    //   setUserSettingsDidChange(false);
    //   setRecommendations([]);
    //   setHasConsumedRecommendationsStream(false);
    //   isLoadingRecommendations = false;
    //   recommendationRef.current = usersRef
    //     .orderBy("id", "desc")
    //     .limit(recommendationBatchLimit);
    // }
  };

  const handleIncompleteUserData = () => {
    Alert.alert(
      IMLocalized("Let's complete your dating profile"),
      IMLocalized(
        "Welcome to Instadating. Let's complete your dating profile to let other people find you.",
      ),
      [
        {
          text: IMLocalized("Let's go"),
          onPress: () => {
            user.profilePictureURL
              ? props.navigation.navigate('AccountDetails', {
                  screenTitle: IMLocalized('Dating Profile'),
                  appStyles: DynamicAppStyles,
                  form: DatingConfig.editProfileFields,
                  onComplete: () => {},
                })
              : props.navigation.navigate('AddProfilePicture');
          },
        },
      ],
      { cancelable: false },
    );
  };

  const handleNewMatchButtonTap = (nextScreen) => {
    setShowMode(0);
    if (nextScreen) {
      props.navigation.navigate(nextScreen);
    }
  };

  /*
   ** Returns null if otherUser is not compatible with the search filters of the current user
   ** Otherwise, it appends the distance property to the otherUser object.
   */
  const hydratedValidRecommendation = (otherUser) => {
    const myLocation = user.location;
    const myGenderPre =
      (user.settings && user.settings?.gender_preference) || 'all';
    const appDistance = (user.settings &&
      user.settings.distance_radius &&
      user.settings.distance_radius.toLowerCase() != 'unlimited' &&
      user.settings.distance_radius.split(' ')) || ['100000'];
    const distanceValue = Number(appDistance[0]);
    const { firstName, email, phone, profilePictureURL, id } = otherUser;
    const defaultAvatar =
      'https://www.iosapptemplates.com/wp-content/uploads/2019/06/empty-avatar.jpg';
    const gender = otherUser.settings ? otherUser.settings.gender : 'none';
    const genderPre = otherUser.settings
      ? otherUser.settings.gender_preference
      : 'all';
    const location = otherUser.location
      ? otherUser.location
      : otherUser.position;
    const isNotCurrentUser = id != user.id;
    const hasNotBeenBlockedByCurrentUser =
      bannedUserIDs != null && !bannedUserIDs.includes(id);
    const hasPreviouslyNotBeenSwiped =
      swipes != null && !swipes.find((user) => user.id == id);

    const isGenderCompatible =
      myGenderPre == 'all' || myGenderPre == 'Both'
        ? true
        : gender == genderPre;
    const otherUserProfileIsPublic =
      otherUser.settings && otherUser.settings.show_me != null
        ? otherUser.settings.show_me == 'true'
        : true;

    if (
      firstName &&
      firstName.length > 0 &&
      (email || phone) &&
      profilePictureURL &&
      profilePictureURL != defaultAvatar &&
      (location || appDistance == '100000') &&
      isNotCurrentUser &&
      hasPreviouslyNotBeenSwiped &&
      isGenderCompatible &&
      otherUserProfileIsPublic &&
      hasNotBeenBlockedByCurrentUser
    ) {
      if (!location || !myLocation) {
        otherUser.distance = IMLocalized('> 100 miles away');
        return otherUser;
      }

      otherUser.distance = distance(
        location.latitude,
        location.longitude,
        myLocation.latitude,
        myLocation.longitude,
      );

      if (appDistance == '100000' || otherUser.distance <= distanceValue) {
        return otherUser;
      }
    }
    return null;
  };

  const distance = (lat1, lon1, lat2, lon2, unit = 'M') => {
    if (lat1 == lat2 && lon1 == lon2) {
      return '< 1 mile away';
    } else {
      const radlat1 = (Math.PI * lat1) / 180;
      const radlat2 = (Math.PI * lat2) / 180;
      const theta = lon1 - lon2;
      const radtheta = (Math.PI * theta) / 180;
      let dist =
        Math.sin(radlat1) * Math.sin(radlat2) +
        Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);

      if (dist > 1) {
        dist = 1;
      }

      dist = Math.acos(dist);
      dist = (dist * 180) / Math.PI;
      dist = dist * 60 * 1.1515;

      if (unit == 'K') {
        dist = dist * 1.609344;
      }

      if (unit == 'N') {
        dist = dist * 0.8684;
      }

      const distance = Math.round(dist);
      if (distance >= 2.0) {
        return distance + ' ' + IMLocalized('miles away');
      }
      return IMLocalized('1 mile away');
    }
  };

  const getMoreRecommendationsIfNeeded = async () => {
    if (isLoadingRecommendations.current || hasConsumedRecommendationsStream) {
      return;
    }

    isLoadingRecommendations.current = true;

    try {
      const documentSnapshots = await recommendationRef.current.get();
      const docs = documentSnapshots.docs;

      if (docs.length > 0) {
        // Get the last visible recommendation document and construct a new query starting at this document,
        recommendationRef.current = usersRef
          .orderBy('id', 'desc')
          .startAfter(documentSnapshots.docs[docs.length - 1])
          .limit(recommendationBatchLimit);

        // Filter out invalid recommendations and update the UI data source
        const newRecommendations = filteredAndHydratedRecommendations(docs);

        isLoadingRecommendations.current = false;

        if (newRecommendations.length > 0) {
          setRecommendations([...recommendations, ...newRecommendations]);
        } else {
          getMoreRecommendationsIfNeeded();
        }
      } else {
        isLoadingRecommendations.current = false;
        setHasConsumedRecommendationsStream(true);
      }
    } catch (error) {
      console.log(error);
      alert(error);
      isLoadingRecommendations.current = false;
    }
  };

  const filteredAndHydratedRecommendations = (docs) => {
    const hydratedRecommendations = docs.map((doc) => {
      return hydratedValidRecommendation(doc.data());
    });
    return hydratedRecommendations.filter(
      (recommendation) => recommendation != null,
    );
  };

  const undoSwipe = (swipeToUndo) => {
    if (!swipeToUndo) {
      return;
    }

    const swipeToUndoId = swipeToUndo.id || swipeToUndo.userID;
    const userID = user.id || user.userID;

    swipeTracker.current.removeSwipe(swipeToUndoId, userID);
  };

  const onSwipe = (type, swipeItem) => {
    const canSwipe = getCanUserSwipe();

    if (!canSwipe) {
      return;
    }

    if (swipeItem && canSwipe) {
      swipeTracker.current.addSwipe(user, swipeItem, type, (response) => {});

      if (!userAwareCanUndo.current && type === 'dislike' && !isPlanActive) {
        shouldAlertCanUndo();
      }
    }
  };

  const onAllCardsSwiped = () => {
    // empty recommendations to trigger fetch of new recommendation stream;
    setRecommendations([]);
  };

  const shouldAlertCanUndo = async () => {
    const isUserAware = await getUserAwareCanUndoAsync();

    if (isUserAware) {
      userAwareCanUndo.current = true;

      return;
    }

    Alert.alert(
      IMLocalized('Pardon the interruption'),
      IMLocalized(
        "Don't lose this amazing friend just because you accidentally swiped left. Upgrade your account now to see them again.",
      ),
      [
        {
          text: IMLocalized('Upgrade Now'),
          onPress: () => setSubscriptionVisible(true),
        },
        {
          text: IMLocalized('Cancel'),
        },
      ],
      { cancelable: true },
    );
    userAwareCanUndo.current = true;
  };

  const renderEmptyState = () => {
    return <NoMoreCard profilePictureURL={user.profilePictureURL} />;
  };

  const renderNewMatch = () => {
    return (
      <NewMatch
        url={currentMatchData.profilePictureURL}
        onSendMessage={() => handleNewMatchButtonTap('Conversations')}
        onKeepSwiping={handleNewMatchButtonTap}
      />
    );
  };

  return (
    <View style={styles.container}>
      <SafeAreaView style={styles.safeAreaContainer}>
        <View style={styles.container}>
          {(recommendations.length > 0 || hasConsumedRecommendationsStream) && (
            <Deck
              data={recommendations}
              setShowMode={setShowMode}
              onUndoSwipe={undoSwipe}
              onSwipe={onSwipe}
              showMode={showMode}
              onAllCardsSwiped={onAllCardsSwiped}
              isPlanActive={isPlanActive}
              setSubscriptionVisible={setSubscriptionVisible}
              renderEmptyState={renderEmptyState}
              renderNewMatch={renderNewMatch}
              canUserSwipe={canUserSwipe}
            />
          )}
          <ActivityModal
            loading={
              !hasConsumedRecommendationsStream && recommendations.length === 0
            }
            title={IMLocalized('Please wait')}
            size={'large'}
            activityColor={'white'}
            titleColor={'white'}
            activityWrapperStyle={{
              backgroundColor: '#404040',
            }}
          />
        </View>
      </SafeAreaView>
      {audioVideoChatConfig && <IMAudioVideoChat {...audioVideoChatConfig} />}
    </View>
  );
};

SwipeScreen.navigationOptions = ({ screenProps, navigation }) => {
  let currentTheme = DynamicAppStyles.navThemeConstants[screenProps.theme];
  return {
    headerTitle: (
      <TNTouchableIcon
        imageStyle={{
          tintColor:
            DynamicAppStyles.colorSet[screenProps.theme]
              .mainThemeForegroundColor,
        }}
        iconSource={DynamicAppStyles.iconSet.fireIcon}
        onPress={() =>
          navigation.navigate('MainStack', { appStyles: DynamicAppStyles })
        }
        appStyles={DynamicAppStyles}
      />
    ),
    headerRight: (
      <TNTouchableIcon
        imageStyle={{ tintColor: '#d1d7df' }}
        iconSource={DynamicAppStyles.iconSet.conversations}
        onPress={() =>
          navigation.navigate('Conversations', { appStyles: DynamicAppStyles })
        }
        appStyles={DynamicAppStyles}
      />
    ),
    headerLeft: (
      <TNTouchableIcon
        imageStyle={{ tintColor: '#d1d7df' }}
        iconSource={DynamicAppStyles.iconSet.userProfile}
        onPress={() =>
          navigation.navigate('MyProfileStack', { appStyles: DynamicAppStyles })
        }
        appStyles={DynamicAppStyles}
      />
    ),
    headerStyle: {
      backgroundColor: currentTheme.backgroundColor,
      borderBottomWidth: 0,
    },
    headerTintColor: currentTheme.fontColor,
  };
};

//'https://pbs.twimg.com/profile_images/681369932207013888/CHESpTzF.jpg'

export default SwipeScreen;
