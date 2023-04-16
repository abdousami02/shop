<template>
  <top-nav v-if="top_nav" />
  <navbar />
  <router-view />
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

  },
  watch: {
    lang(){
      this.change_lang();
    }
  }
};
</script>
