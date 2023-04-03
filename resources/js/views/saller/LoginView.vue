<template>
  <div>
    <div class="container">
      <div class="panel">
        <form action="" @submit.prevent="sendData"  method="" class="login" id="login-data">
          <h3 class="head">Login</h3>
          <div :class="['mobile name' , error_login ? 'invalid' : '' ]">
            <i class="far fa-user fa-lg icon"></i>
            <input type="number" name="username" class="hidden-arrow" placeholder="No phone" v-model="user.mobile" required/>
          </div>
          <div :class="['pass', error_login ? 'invalid' : '' ]">
            <i class="far fa-lock-alt fa-lg icon"></i>
            <input type="password" name="username" placeholder="password" v-model="user.password" min="8" required/>
          </div>
          <a to="/signUp" href="#" class="forget">Forget Password?</a>
          <button type="submit" form="login-data" class="btn-sub">Login</button>
        </form>
        <!-- <div>
          <span class="separ">OR</span>
          <p class="switch">Dont have Account? <router-link to="/signUp" href="#">Create Account</router-link></p>
        </div> -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginRegister",
  data: function() {
    return {
      user: {
        mobile: "",
        password: "",
      },
      error_login: "",
    };
  },
  methods: {
    sendData(){
      let data = this.user;
      axios.post('/api/auth/login?permition=saller', data).then(response=>{
        if(response.data.access_token){
          this.$root.login = true;
          this.$root.user = response.data.user_info;
          document.cookie= "token=" + response.data.access_token, + ";expires=Thu, 18 Dec 2023 12:00:00 UTC; path=/"

          this.$router.push({path: "/dashboard/order"});


        }else if(response.data.status == 'permition'){
          Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: "Can't login, contact admin!",
        })

        }else{
          this.error_login = true;
        }

      });
    },
    after(){
      if(this.$root.login == true){
        this.$router.push({path: "/dashboard/order"});
      }
    },
  },
  mounted: function() {
    if(this.$root.render == true) {this.after(); }
  },
  watch: {
    '$root.render': function(){ this.after(); }
  }

};
</script>

