<template>
  <div class="setting">
    <div class="nav-setting close">
      <div class="nav-head">
        <i class="far fa-bars open" @click="open_nav"></i>
        <span class="txt">Setting</span>
        <i class="far fa-times close_btn" @click="open_nav"></i>
      </div>
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link to="/setting" href="#" class="nav-link"><i class="fas fa-tachometer-alt"></i><span class="txt">Dashboard</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/setting/profile" href="#" class="nav-link"><i class="fas fa-user"></i><span class="txt">Profile</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/setting/logout" href="#" class="nav-link"><i class="fas fa-sign-out-alt"></i><span class="txt">LogOut</span></router-link>
        </li>
      </ul>
    </div>
    <div class="content">
      <router-view />
    </div>
  </div>
</template>

<script>
export default {
  name: "SettingView",
  methods: {
    open_nav() {
      console.log("close");
      document.querySelector(".nav-setting").classList.toggle("close");
    },
    check_login(){
      if(!this.$root.login){
        this.$router.push({path: '/'})
      }
    }
  },
  mounted: function(){
    this.check_login();
  }
};
</script>

