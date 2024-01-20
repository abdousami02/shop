<template>
  <top-nav v-if="top_nav" />
  <navbar />
  <router-view v-if="render" />
  <footers />
</template>

<script>
import navbar from "./components/shop/NavBar.vue";
import footers from "./components/shop/footer.vue";
import TopNav from "./components/shop/TopNav.vue"

export default {
  components: {
    navbar,
    TopNav,
    footers,
  },
  data: function(){
    return {
      login: false,
      user: {},
      render: false,
      top_nav: false,
      lang: "ar",
    }
  },
  methods: {

    // check login
    check_login(){
      axios.post('/api/auth/refresh').then(response=>{
        console.log('login');
        this.login = true;
        this.user = response.data.user_info;
        document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/"
        document.cookie= "token=" + response.data.access_token + "; expires=Thu, 18 Dec 2023 12:00:00 UTC; path=/"
        this.render = true;

      }).catch(error => {
        if(error.response.data.message == "Unauthenticated."){
          console.log('not login');
          this.user = {};
          this.login = false;
          document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/";
          this.render = true;
        }
      });
    },
    change_lang(){
      if(this.lang == "ar"){
        $("body").attr("dir", "rtl");
        localStorage.setItem("lang", this.lang)

      }else{
        localStorage.setItem("lang", this.lang)
        $("body").attr("dir", "")
      }
    },
    sendToken(token){
        let data = {token : token}
        axios.post('/api/setToken', data).then(resp => {
            console.log(resp);
        });
    }

  },
  mounted: function(){
    let lang = localStorage.getItem("lang");
    if(lang){
      this.lang = lang;
    }
    this.check_login();
    this.change_lang();

    document.documentElement.style.width = $('body').width() + 'px';

    // notification
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

    var vapidkey = "BAL4NbPRgnqMgxbchQG17uv-DNmvbZYNpMrBU9WhNk_ZIrl8ZT0g4b9T3Fbw6l1fNUZPuaywQEf1UlH2uormxOs";


    messaging.getToken({vapidkey: vapidkey}).then((currentToken) => {
        console.log(currentToken)
        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            // document.getElementById('content').innerHTML = currentToken;
            sendTokenToServer(currentToken);
        } else {
            // Show permission request UI
            console.log('No registration token available.');
            tokenIsSend(false)
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        // document.getElementById('content').innerHTML = err;
        tokenIsSend(false)
    });

    messaging.onMessage((payload) => {
        console.log(payload);
        document.getElementById('content').innerHTML = JSON.stringify(payload.data, null, 2);
    });

    // sent token to server where it is used for sending notification
    function sendTokenToServer(currentToken){
        // first check if we already send it or not
        if(!isTokenSentToServer()){
            console.log('Sending Token to server...');
            // if token is successfully sent to the server
            // then set setTokenSentToServer to true
            let out = this.sendToken(currentToken);
            if(out){
            }
            tokenIsSend(true)
        }else{
            console.log('Token already available in the server');
        }
    }

    function tokenIsSend(sent){
        window.localStorage.setItem('sentToServer', sent ? '1' : '0');
        console.log('set in local storage')
    }

    function isTokenSentToServer(){
        return window.localStorage.getItem('sentToServer') == 1;
    }

  },
  watch: {
    lang(){
      this.change_lang();
    }
  }
};
</script>
