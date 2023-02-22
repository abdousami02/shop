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
  },
};
</script>

<style lang="scss">
// 103262
.setting {
  height: 100%;
  display: flex;
  position: relative;
  .nav-setting {
    height: 100%;
    position: absolute;
    left: 0;
    z-index: 20;
    width: 180px;
    background: #fff;
    transition: width 0.5s;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important /* global class */;
    .nav-head {
      background: #103262;
      color: #fff;
      font-size: 20px;
      padding: 5px 10px;
      white-space: nowrap;
      .open {
        cursor: pointer;
      }
      .txt {
        margin-left: 10px;
      }
      .close_btn {
        position: absolute;
        top: 10px;
        right: 15px;
        color: #f6a823;
        cursor: pointer;
      }
    }
    .navbar-nav {
      padding: 10px;
      .nav-item {
        font-size: 16px;
        color: #103262;
        border-radius: 6px;
        white-space: nowrap;
        .router-link-exact-active {
          color: #f6a823;
        }
        .txt {
          margin-left: 10px;
        }
      }
    }
  }
  .content {
    width: calc(100% - 45px);
    margin-left: 45px;
    background: #f1f1f1;
    padding: 10px;
  }
  .close {
    width: 45px;
    span,
    .close_btn {
      display: none;
    }
  }
}
</style>
