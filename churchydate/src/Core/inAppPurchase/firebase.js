import { firebase } from '../firebase/config';

const db = firebase.firestore();
const subcriptionsRef = db.collection('subcriptions');

export const updateUserSubscription = async (userID, subscriptionPlan) => {
  subcriptionsRef.doc(userID).set({ ...subscriptionPlan }, { merge: true });
};

export const getUserSubscription = async (userID) => {
  try {
    const subscription = await subcriptionsRef.doc(userID).get();

    if (subscription.data()) {
      return {
        sucess: true,
        subscription: { ...subscription.data(), id: subscription.id },
      };
    }

    return { sucess: false };
  } catch (error) {
    console.log(error);

    return { sucess: false, error };
  }
};
