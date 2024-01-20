/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts("https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js");
importScripts("https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js");

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/


const firebaseConfig = {
    apiKey: "AIzaSyD3rsNtXTf0x9oIaNn3rsMcIIYyUPs-5eg",
    authDomain: "notificationtest-9949a.firebaseapp.com",
    projectId: "notificationtest-9949a",
    storageBucket: "notificationtest-9949a.appspot.com",
    messagingSenderId: "678357974407",
    appId: "1:678357974407:web:22a349926afb1b4703e722",
    measurementId: "G-SY3S2BLTT2"
  };

    // Initialize Firebase
    // const app = firebase.initializeApp(firebaseConfig);
    // const messaging = firebase.messaging();

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/

// messaging.setBackgroundMessageHandler(function (payload) {
//     console.log('notification');
// });
// messaging.onBackgroundMessage(  function (payload) {
//     console.log("[firebase-messaging-sw.js] Received background message ",payload)
//     /* Customize notification here */
//     var not = payload.data;
//     const notificationTitle = not.title;
//     const notificationOptions = {
//         body: not.body,
//         image: not.image,
//         icon: not.icon,
//     };

//     self.registration.showNotification(
//         notificationTitle,
//         notificationOptions
//     );
//     self.addEventListener('notificationclick', function(event){
//         const clickedNot = event.notification
//         clickedNot.close();
//         event.waitUntil(
//             clients.openWindow(not.click_action)
//         )
//     })
// });
