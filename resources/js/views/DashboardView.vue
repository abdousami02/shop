<template>
  <div class="dash">
    <div class="nav-dash">
      <div class="nav-head">
        <i class="far fa-bars open" @click="open_nav"></i>
        <span class="txt">Setting</span>
        <i class="far fa-times close_btn" @click="open_nav"></i>
      </div>
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link to="/dashboard" href="#" class="nav-link"><i class="fas fa-tachometer-alt"></i><span class="txt">Dashboard</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/order" href="#" class="nav-link"><i class="fas fa-box-open"></i><span class="txt">Orders</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/product" href="#" class="nav-link"><i class="fas fa-shopping-bag"></i><span class="txt">Product</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/cat" href="#" class="nav-link"><i class="far fa-th-large"></i><span class="txt">Categories</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/user" href="#" class="nav-link"><i class="fas fa-user"></i><span class="txt">Users</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/saller" href="#" class="nav-link"><i class="fas fa-store"></i><span class="txt">Sallers</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/anal" href="#" class="nav-link"><i class="fas fa-chart-line"></i><span class="txt">Analytics</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/setting" href="#" class="nav-link"><i class="fas fa-wrench"></i><span class="txt">Setting</span></router-link>
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
  name: "DashboardView",
  data: function () {
    return {
      connect: "php/init.php",
    };
  },
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
.dash {
  height: 100%;
  display: flex;
  position: relative;
  .nav-dash {
    height: 100%;
    z-index: 20;
    width: 180px;
    background: #fff;
    transition: width 0.5s;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important /* global class */;
    .nav-head {
      position: relative;
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
    background: #f1f1f1;
    padding: 20px;
    flex-grow: 1;
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
