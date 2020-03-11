importScripts('https://www.gstatic.com/firebasejs/6.2.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.2.2/firebase-messaging.js');

var config = {
  apiKey: "AIzaSyB7plMdLEI9IkHEYQIYHI_btxj5sYElhn8",
  authDomain: "elsalamapp.firebaseapp.com",
  databaseURL: "https://elsalamapp.firebaseio.com",
  projectId: "elsalamapp",
  storageBucket: "elsalamapp.appspot.com",
  messagingSenderId: "844700117021",
  appId: "1:844700117021:web:afdaf9090454799d"
};


firebase.initializeApp(config);


const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
 console.log('[firebase-messaging-sw.js] Received background message ', payload);
 const notificationTitle = 'Background Message from html';
  const notificationOptions = {
   body: 'Background Message body.',
   icon: '/favicon.png',
   sound:'default'
 };


});

  