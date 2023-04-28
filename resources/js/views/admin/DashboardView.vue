<template>
  <div class="dash">
    <div :class="['nav-dash', toggle_nav ? 'close' : '']">
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
          <router-link to="/dashboard/commande?status=1" href="#" class="nav-link"><i class="far fa-clipboard-list-check"></i><span class="txt">Commande</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/product" href="#" class="nav-link"><i class="fas fa-shopping-bag"></i><span class="txt">Product</span></router-link>
        </li>
        <li class="nav-item">
          <router-link to="/dashboard/buy" href="#" class="nav-link"><i class="fas fa-cart-plus"></i><span class="txt">Buy</span></router-link>
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
        <li class="nav-item">
          <router-link to="/dashboard/group" href="/dashboard/group" class="nav-link"><i class="fas fa-key"></i><span class="txt">Group</span></router-link>
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
      toggle_nav: '',

    };
  },
  methods: {
    open_nav() {
      console.log("close");
      this.toggle_nav == '' ? this.toggle_nav = 'close' : this.toggle_nav = '';
    },

    // function for select row
    select_all(e) {
      let ele = $(e.target);
      if (ele.hasClass("active")) {
        $(".elem-row.selected").each(function () {
          $(this).find(".select input").click();
        });
        ele.removeClass("active");
      } else {
        $(".elem-row .select input").each(function () {
          ele.addClass('active');
          $(this).click();
        });
      }
    },


    // function for checkbox action in element row
    sel_row(e) {
      // console.log(this)
      $(e.target).parents(".elem-row").toggleClass("selected");
      $(".t-0 .sel").addClass("active");
    },

    // check login
    check_login(){
      axios.post('/api/auth-admin/refresh').then(response=>{
        console.log('login')
        document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/"
        document.cookie= "token=" + response.data.access_token + "; expires=Thu, 18 Dec 2023 12:00:00 UTC; path=/"

      }).catch(error => {
        if(error.response.data.message == "Unauthenticated."){
          document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/"
          this.$router.push({ name: "Login" })
        }
      });
    },
  },
  beforeMount() {
    setTimeout(this.check_login, 300);
    setInterval(this.check_login, 600000)
  },
};
</script>

