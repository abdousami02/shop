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
          <router-link to="/dashboard/product" href="#" class="nav-link"><i class="fas fa-shopping-bag"></i><span class="txt">Product</span></router-link>
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
  name: "sallerSetting",
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

    after(){
      console.log('check')
      if(this.$root.login == false){
        this.$router.push({name: "Login"})

      }

    }
  },
  mounted: function() {
    if(this.$root.render == true) {this.after(); }
  },
  watch: {
    '$root.render': function(){ this.after(); }
  }
};
</script>

