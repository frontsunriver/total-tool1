import { ErrorCode } from '../onboarding/utils/ErrorCode';
import { firebase } from './config';

const getBlob = async (uri) => {
  return await new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    xhr.onload = () => {
      resolve(xhr.response);
    };
    xhr.responseType = 'blob';
    xhr.open('GET', uri, true);
    xhr.send(null);
  });
};

const uploadFileWithProgressTracking = async (
  filename,
  uploadUri,
  callbackProgress,
  callbackSuccess,
  callbackError,
) => {
  // Success handler with SUCCESS is called multiple times on Android. We need work around that to ensure we only call it once
  let finished = false;
  const blob = await getBlob(uploadUri);
  const storageRef = firebase.storage().ref();
  const fileRef = storageRef.child(filename);
  const uploadTask = fileRef.put(blob);

  uploadTask.on(
    firebase.storage.TaskEvent.STATE_CHANGED,
    (snapshot) => {
      if (snapshot.state == firebase.storage.TaskState.SUCCESS) {
        if (finished == true) {
          return;
        }
        finished = true;
      }
      callbackProgress(snapshot);
    },
    callbackError,
    () => {
      uploadTask.snapshot.ref.getDownloadURL().then((downloadURL) => {
        console.log('File available at', downloadURL);
        callbackSuccess(downloadURL);
      });
    },
  );
};

const uploadImage = (uri) => {
  return new Promise(async (resolve, _reject) => {
    console.log('uri ==', uri);
    const filename = uri.substring(uri.lastIndexOf('/') + 1);
    const blob = await getBlob(uri);

    const storageRef = firebase.storage().ref();
    const fileRef = storageRef.child(filename);
    const uploadTask = fileRef.put(blob);

    uploadTask.on(
      firebase.storage.TaskEvent.STATE_CHANGED,
      (snapshot) => {},
      (error) => {
        console.log('upload error:', error);
        resolve({ error: ErrorCode.photoUploadFailed });
      },
      () => {
        uploadTask.snapshot.ref.getDownloadURL().then((downloadURL) => {
          console.log('File available at', downloadURL);
          resolve({ downloadURL: downloadURL });
        });
      },
    );
  });
};

const firebaseStorage = {
  uploadImage,
  uploadFileWithProgressTracking,
};

export { firebaseStorage };
