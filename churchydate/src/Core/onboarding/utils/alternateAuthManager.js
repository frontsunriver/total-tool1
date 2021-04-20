import adminManager from './instamobileAdminManager';
import { firebaseAuth, firebaseUser } from '../../firebase';
import { firebaseStorage } from '../../firebase/storage';
import WooCommerceManager from '../../wooCommerce';
import { stripeDataManager } from '../../stripe';
import { ErrorCode } from './ErrorCode';
import Geolocation from '@react-native-community/geolocation';
import * as Facebook from 'expo-facebook';
import * as Permissions from 'expo-permissions';

const defaultProfilePhotoURL =
  'https://www.iosapptemplates.com/wp-content/uploads/2019/06/empty-avatar.jpg';

const loginWithEmailAndPassword = (email, password, appConfig) => {
  if (!appConfig.API_TO_USE) {
    return firebaseLogin(email, password);
  }
  switch (appConfig.API_TO_USE.toLowerCase()) {
    case appConfig.APIs.wooCommerce.toLowerCase():
      return wooCommerceLogin(email, password, appConfig);

    case appConfig.APIs.firebase.toLowerCase():
      return firebaseLogin(email, password, appConfig);

    default:
      return firebaseLogin(email, password, appConfig);
  }
};

const createAccountWithEmailAndPassword = (userDetails, appConfig) => {
  if (!appConfig.API_TO_USE) {
    return createFirebaseAccount(userDetails, appConfig);
  }
  switch (appConfig.API_TO_USE.toLowerCase()) {
    case appConfig.APIs.wooCommerce.toLowerCase():
      return createWooCommerceAccount(userDetails, appConfig);
    case appConfig.APIs.firebase.toLowerCase():
      return createFirebaseAccount(userDetails, appConfig);
    default:
      return createFirebaseAccount(userDetails, appConfig);
  }
};

const retrievePersistedAuthUser = (appConfig) => {
  if (!appConfig.API_TO_USE) {
    return retrieveFirebaseAuthUser();
  }
  switch (appConfig.API_TO_USE.toLowerCase()) {
    case appConfig.APIs.wooCommerce.toLowerCase():
      return retrieveWooCommerceAuthUser(appConfig);
    case appConfig.APIs.firebase.toLowerCase():
      return retrieveFirebaseAuthUser();
    default:
      return retrieveFirebaseAuthUser();
  }
};

const retrieveWooCommerceAuthUser = async (appConfig) => {
  return new Promise(async (resolve, reject) => {
    const authResponse = await WooCommerceManager.configWooCommerceAuth(
      appConfig.wooCommerceConfig,
    ).wooCommerceAuthManager.retrievePersistedAuthUser();

    if (authResponse.success && authResponse?.response?.token) {
      const res = await getWooCommerceUser(
        authResponse.response.user_email,
        appConfig,
      );

      if (res.success && res.user) {
        res.user.stripeCustomer = res.stripeCustomer;
        resolve({
          user: res.user,
        });
      } else {
        resolve(null);
      }
    } else {
      resolve({
        error: ErrorCode.noUser,
      });
    }
  });
};

const getWooCommerceUser = async (email, appConfig) => {
  const userResponse = await WooCommerceManager.configWooCommerceData(
    appConfig.wooCommerceConfig,
  ).wooCommerceDataManager.getCustomer({ email });

  if (userResponse.response.length > 0) {
    const user = userResponse.response[0];
    const authUser = {
      id: user.id,
      email,
      firstName: user.first_name,
      lastName: user.last_name,
      photoURI: user.avatar_url,
      shipping: { ...user.shipping },
      billing: { ...user.billing },
      phone: user.billing.phone,
    };

    return {
      success: true,
      user: authUser,
      stripeCustomer: user.billing.address_1,
    };
  }

  return {
    success: false,
  };
};

const onVerification = (phone) => {
  firebaseAuth.onVerificationChanged(phone);
};

const retrieveFirebaseAuthUser = () => {
  return new Promise((resolve) => {
    firebaseAuth.retrievePersistedAuthUser().then((user) => {
      if (user) {
        handleSuccessfulLogin(user, false).then((res) => {
          // Persisted login successful, push token stored, login credential persisted, so we log the user in.peCustomer =
          resolve({
            user: res.user,
          });
        });
      } else {
        resolve(null);
      }
    });
  });
};

const wooCommerceLogin = async (email, password, appConfig) => {
  return new Promise(async (resolve, reject) => {
    const wooResponse = await WooCommerceManager.configWooCommerceAuth(
      appConfig.wooCommerceConfig,
    ).wooCommerceAuthManager.authCustomer({
      username: email,
      password: password,
    });

    if (wooResponse.success && wooResponse.response.token) {
      const res = await getWooCommerceUser(email, appConfig);

      if (res.success && res.user) {
        if (!res.stripeCustomer) {
          const stripeCustomer = await createStripeCustomer(
            res.user.email,
            appConfig,
          );

          if (stripeCustomer) {
            await WooCommerceManager.configWooCommerceData(
              appConfig.wooCommerceConfig,
            ).wooCommerceDataManager.updateCustomer(res.user.id, {
              billing: {
                company: 'stripe',
                address_1: stripeCustomer,
              },
            });
            res.stripeCustomer = stripeCustomer;
          }
        }

        res.user.stripeCustomer = res.stripeCustomer;

        resolve({
          user: res.user,
        });
      } else {
        resolve({
          user: res.user,
        });
      }
    } else {
      resolve({ error: ErrorCode.noUser });
    }
  });
};

const firebaseLogin = (email, password, appConfig) => {
  return new Promise(function (resolve, _reject) {
    firebaseAuth.loginWithEmailAndPassword(email, password).then((response) => {
      if (!response.error) {
        handleSuccessfulLogin({ ...response.user }, false).then(async (res) => {
          // Login successful, push token stored, login credential persisted, so we log the user in.

          // handle no stripeCustomerId
          if (!res.stripeCustomer) {
            const stripeCustomer = await createStripeCustomer(
              res.user.email,
              appConfig,
            );

            if (stripeCustomer) {
              firebaseUser.updateUserData(res.user.id, {
                stripeCustomer,
              });
              res.user.stripeCustomer = stripeCustomer;
            }
          }

          resolve({ user: res.user });
        });
      } else {
        resolve({ error: response.error });
      }
    });
  });
};

const sendPasswordResetEmail = (email) => {
  return new Promise((resolve) => {
    firebaseAuth.sendPasswordResetEmail(email);
    resolve();
  });
};

const logout = (user) => {
  const userData = {
    ...user,
    isOnline: false,
  };
  firebaseAuth.updateUser(user.id || user.userID, userData);
  firebaseAuth.logout();
};

const loginOrSignUpWithApple = (appConfig) => {
  return new Promise(async (resolve, _reject) => {
    try {
      const appleAuthRequestResponse = await appleAuth.performRequest({
        requestedOperation: AppleAuthRequestOperation.LOGIN,
        requestedScopes: [
          AppleAuthRequestScope.EMAIL,
          AppleAuthRequestScope.FULL_NAME,
        ],
      });

      const { identityToken, nonce } = appleAuthRequestResponse;

      firebaseAuth
        .loginWithApple(identityToken, nonce, appConfig.appIdentifier)
        .then(async (response) => {
          if (response.user) {
            const newResponse = {
              user: { ...response.user },
              accountCreated: response.accountCreated,
            };
            handleSuccessfulLogin(
              newResponse.user,
              response.accountCreated,
            ).then((response) => {
              // resolve(response);
              resolve({
                ...response,
                stripeCustomer: '',
              });
            });
          } else {
            resolve({ error: ErrorCode.appleAuthFailed });
          }
        });
    } catch (error) {
      console.log(error);
      resolve({ error: ErrorCode.appleAuthFailed });
    }
  });
};

const createStripeCustomer = async (email, appConfig) => {
  if (!appConfig.API_TO_USE) {
    return false;
  }

  const stripeCustomer = await stripeDataManager.createStripeCustomer(
    email,
    appConfig,
  );

  if (stripeCustomer.success) {
    return stripeCustomer.data.customer.id;
  }

  return false;
};

const createWooCommerceAccount = async (userDetails, appConfig) => {
  return new Promise(async (resolve, reject) => {
    const { firstName, lastName, email, password } = userDetails;

    const wooCustomer = {
      email,
      first_name: firstName,
      password,
      last_name: lastName,
    };

    const res = await WooCommerceManager.configWooCommerceData(
      appConfig.wooCommerceConfig,
    ).wooCommerceDataManager.createCustomer(wooCustomer);

    if (res.success && res.response.id) {
      const userResponse = await WooCommerceManager.configWooCommerceData(
        appConfig.wooCommerceConfig,
      ).wooCommerceDataManager.getCustomer({ email });
      const user = userResponse.response[0];
      const authUser = {
        id: user.id,
        email,
        firstName: user.first_name,
        lastName: user.last_name,
        photoURI: user.avatar_url,
        shipping: { ...user.shipping },
        billing: {
          ...user.billing,
        },
        phone: user.billing.phone,
      };

      const stripeCustomer = await createStripeCustomer(email, appConfig);
      if (stripeCustomer) {
        await WooCommerceManager.configWooCommerceData(
          appConfig.wooCommerceConfig,
        ).wooCommerceDataManager.updateCustomer(authUser.id, {
          billing: {
            company: 'stripe',
            address_1: stripeCustomer,
          },
        });
      }

      authUser.stripeCustomer = stripeCustomer;

      resolve({
        user: authUser,
      });
    } else {
      resolve({ error: res.error });
    }
  });
};

const createFirebaseAccount = (userDetails, appConfig) => {
  const { photoURI } = userDetails;
  const accountCreationTask = (userData) => {
    return new Promise((resolve, _reject) => {
      firebaseAuth
        .register(userData, appConfig.appIdentifier)
        .then(async (response) => {
          if (response.error) {
            resolve({ error: response.error });
          } else {
            // We created the user succesfully, time to upload the profile photo and update the users table with the correct URL
            let user = response.user;
            const stripeCustomer = await createStripeCustomer(
              userDetails.email,
              appConfig,
            );
            if (stripeCustomer) {
              user.stripeCustomer = stripeCustomer;
              firebaseUser.updateUserData(user.id, {
                stripeCustomer,
              });
            }
            if (photoURI) {
              firebaseStorage.uploadImage(photoURI).then((response) => {
                if (response.error) {
                  // if account gets created, but photo upload fails, we still log the user in
                  resolve({
                    nonCriticalError: response.error,
                    user: {
                      ...user,
                      profilePictureURL: defaultProfilePhotoURL,
                    },
                  });
                } else {
                  firebaseAuth
                    .updateProfilePhoto(user.id, response.downloadURL)
                    .then((_result) => {
                      resolve({
                        user: {
                          ...user,
                          profilePictureURL: response.downloadURL,
                        },
                      });
                    });
                }
              });
            } else {
              resolve({
                user: {
                  ...response.user,
                  profilePictureURL: defaultProfilePhotoURL,
                },
              });
            }
          }
        });
    });
  };

  return new Promise(function (resolve, _reject) {
    const userData = {
      ...userDetails,
      profilePictureURL: defaultProfilePhotoURL,
    };
    accountCreationTask(userData).then((response) => {
      if (response.error) {
        resolve({ error: response.error });
      } else {
        // We signed up successfully, so we are logging the user in (as well as updating push token, persisting credential,s etc.)
        handleSuccessfulLogin(response.user, true).then((response) => {
          resolve({
            ...response,
          });
        });
      }
    });
  });
};

const loginOrSignUpWithFacebook = (appConfig) => {
  Facebook.initializeAsync(appConfig.facebookIdentifier);

  return new Promise(async (resolve, _reject) => {
    try {
      const {
        type,
        token,
        expires,
        permissions,
        declinedPermissions,
      } = await Facebook.logInWithReadPermissionsAsync({
        permissions: ['public_profile', 'email'],
      });

      if (type === 'success') {
        // Get the user's name using Facebook's Graph API
        // const response = await fetch(`https://graph.facebook.com/me?access_token=${token}`);
        // Alert.alert('Logged in!', `Hi ${(await response.json()).name}!`);
        firebaseAuth
          .loginWithFacebook(token, appConfig.appIdentifier)
          .then(async (response) => {
            if (response.user) {
              const newResponse = {
                user: { ...response.user },
                accountCreated: response.accountCreated,
              };
              const stripeCustomer = await createStripeCustomer(
                response.user.email,
                appConfig,
              );
              if (stripeCustomer) {
                response.user.stripeCustomer = stripeCustomer;
                firebaseUser.updateUserData(response.user.id, {
                  stripeCustomer,
                });
              }
              handleSuccessfulLogin(
                newResponse.user,
                response.accountCreated,
              ).then((response) => {
                // resolve(response);
                resolve({
                  ...response,
                });
              });
            } else {
              resolve({ error: ErrorCode.fbAuthFailed });
            }
          });
      } else {
        resolve({ error: ErrorCode.fbAuthCancelled });
      }
    } catch (error) {
      resolve({ error: ErrorCode.fbAuthFailed });
    }
  });
};

const retrieveUserByPhone = (phone) => {
  return firebaseAuth.retrieveUserByPhone(phone);
};

const sendSMSToPhoneNumber = (phoneNumber, captchaVerifier) => {
  return firebaseAuth.sendSMSToPhoneNumber(phoneNumber, captchaVerifier);
};

const loginWithSMSCode = (smsCode, verificationID) => {
  return new Promise(function (resolve, _reject) {
    firebaseAuth.loginWithSMSCode(smsCode, verificationID).then((response) => {
      if (response.error) {
        resolve({ error: response.error });
      } else {
        // successful phone number login, we fetch the push token
        handleSuccessfulLogin(response.user, false).then((response) => {
          resolve(response);
        });
      }
    });
  });
};

const registerWithPhoneNumber = (
  userDetails,
  smsCode,
  verificationID,
  appIdentifier,
) => {
  const { photoURI } = userDetails;
  const accountCreationTask = (userData) => {
    return new Promise(function (resolve, _reject) {
      firebaseAuth
        .registerWithPhoneNumber(
          userData,
          smsCode,
          verificationID,
          appIdentifier,
        )
        .then((response) => {
          if (response.error) {
            resolve({ error: response.error });
          } else {
            // We created the user succesfully, time to upload the profile photo and update the users table with the correct URL
            let user = response.user;
            if (photoURI) {
              firebaseStorage.uploadImage(photoURI).then((response) => {
                if (response.error) {
                  // if account gets created, but photo upload fails, we still log the user in
                  resolve({
                    nonCriticalError: response.error,
                    user: {
                      ...user,
                      profilePictureURL: defaultProfilePhotoURL,
                    },
                  });
                } else {
                  firebaseAuth
                    .updateProfilePhoto(user.id, response.downloadURL)
                    .then((_res) => {
                      resolve({
                        user: {
                          ...user,
                          profilePictureURL: response.downloadURL,
                        },
                      });
                    });
                }
              });
            } else {
              resolve({
                user: {
                  ...response.user,
                  profilePictureURL: defaultProfilePhotoURL,
                },
              });
            }
          }
        });
    });
  };

  return new Promise(function (resolve, _reject) {
    const userData = {
      ...userDetails,
      profilePictureURL: defaultProfilePhotoURL,
    };
    accountCreationTask(userData).then((response) => {
      if (response.error) {
        resolve({ error: response.error });
      } else {
        handleSuccessfulLogin(response.user, true).then((response) => {
          resolve(response);
        });
      }
    });
  });
};

const handleSuccessfulLogin = (user, accountCreated) => {
  // After a successful login, we fetch & store the device token for push notifications, location, online status, etc.
  // we don't wait for fetching & updating the location or push token, for performance reasons (especially on Android)
  fetchAndStoreExtraInfoUponLogin(user, accountCreated);
  if (accountCreated && adminManager) {
    adminManager.handleNewAccountCreation(user);
  }
  return new Promise((resolve) => {
    resolve({ user: { ...user } });
  });
};

const fetchAndStoreExtraInfoUponLogin = async (user, accountCreated) => {
  getCurrentLocation(Geolocation).then(async (location) => {
    const latitude = location.coords.latitude;
    const longitude = location.coords.longitude;
    var locationData = {};
    if (location) {
      locationData = {
        location: {
          latitude: latitude,
          longitude: longitude,
        },
      };
      if (accountCreated) {
        locationData = {
          ...locationData,
          signUpLocation: {
            latitude: latitude,
            longitude: longitude,
          },
        };
      }
    }

    const userData = {
      ...user,
      ...locationData,
      isOnline: true,
    };

    firebaseAuth.updateUser(user.id || user.userID, userData);

    const pushToken = await firebaseAuth.fetchPushTokenIfPossible();

    if (pushToken) {
      userData.pushToken = pushToken;

      firebaseAuth.updateUser(user.id || user.userID, userData);
    }
  });
};

const getCurrentLocation = (geolocation) => {
  return new Promise(async (resolve) => {
    let { status } = await Permissions.askAsync(Permissions.LOCATION);
    if (status !== 'granted') {
      resolve({ coords: { latitude: '', longitude: '' } });
      return;
    }

    geolocation.getCurrentPosition(
      (location) => {
        console.log(location);
        resolve(location);
      },
      (error) => {
        console.log(error);
      },
    );

    // setRegion(location.coords);
    // onLocationChange(location.coords);

    // geolocation.getCurrentPosition(
    //     resolve,
    //     () => resolve({ coords: { latitude: "", longitude: "" } }),
    //     { enableHighAccuracy: false, timeout: 20000, maximumAge: 1000 }
    // );
  });
};

const authManager = {
  retrievePersistedAuthUser,
  loginWithEmailAndPassword,
  sendPasswordResetEmail,
  logout,
  createAccountWithEmailAndPassword,
  loginOrSignUpWithApple,
  loginOrSignUpWithFacebook,
  sendSMSToPhoneNumber,
  loginWithSMSCode,
  registerWithPhoneNumber,
  retrieveUserByPhone,
};

export default authManager;
