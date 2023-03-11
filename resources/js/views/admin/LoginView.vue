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
        <div>
          <span class="separ">OR</span>
          <p class="switch">Dont have Account? <router-link to="/signUp" href="#">Create Account</router-link></p>
        </div>
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
      axios.post('/api/auth-admin/login', data).then(response=>{
        if(response.data.access_token){
          document.cookie= "token=" + response.data.access_token, + ";expires=Thu, 18 Dec 2023 12:00:00 UTC; path=/"
          this.$router.push({ path: "dashboard" })

        }else{
          this.error_login = true;
        }
      });
    },

    // check login
    check_login(){
      axios.post('/api/auth-admin/refresh').then(response=>{
        document.cookie= "token=" + response.data.access_token + "; expires=Thu, 18 Dec 2023 12:00:00 UTC; path=/"
        this.$router.push({ name: "Dashboard" })

      }).catch(error => {
        if(error.response.data.message == "Unauthenticated."){
          document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/"
        }
      });
    },
  },
  beforeMount() {
    this.check_login();
  },
};
</script>

<style lang="scss">
:root {
  --main-color: #103262;
}

input.hidden-arrow {
  -moz-appearance: textfield;
}
input.hidden-arrow::-webkit-outer-spin-button,
input.hidden-arrow::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

//style for signin & signUp
.panel {
  max-width: 500px;
  width: 90%;
  background: #fff;
  margin: 50px auto;
  border-radius: 20px;
  padding: 35px 25px;

  .login {
    .mobile {
      position: relative;
      &::before {
        content: "0";
        position: absolute;
        top: 7px;
        left: 35px;
        font-size: 17px;
      }
    }
    .invalid {
      border-color: #dc3545;
      position: relative;
      &::after {
        content: "!";
        position: absolute;
        right: 12px;
        border: 1px solid #dc3545;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        text-align: center;
        color: #dc3545;
        font-size: 16px;
      }
    }
  }
  form {
    max-width: 250px;
    margin: auto;
    position: relative;
    overflow: hidden;
  }
  .head {
    text-align: center;
    font-size: 40px;
    font-weight: 700;
    color: var(--main-color);
    margin-bottom: 50px;
  }
  .btn-sub {
    display: block;
    margin: 40px auto;
    border: none;
    padding: 12px;
    width: 100%;
    border-radius: 24px;
    background: var(--main-color);
    color: #fff;
  }
  .separ {
    display: block;
    color: #555;
    position: relative;
    width: fit-content;
    margin: auto;

    &::before,
    &::after {
      content: "";
      display: inline-block;
      position: absolute;
      width: 30px;
      height: 1px;
      background-color: #555;
      top: 50%;
    }
    &::before {
      left: 30px;
    }
    &::after {
      right: 30px;
    }
  }
  .switch {
    margin-top: 20px;
    text-align: center;
  }
}

// tyle for just login
.login {
  .name,
  .pass {
    width: fit-content;
    margin: auto;
    border-bottom: 2px solid #ccc;
    padding: 7px;
    margin-bottom: 10px;
    font-size: 16px;
  }
  .name {
    margin-bottom: 30px;
  }
  .icon {
    color: var(--main-color);
  }

  input {
    border: none;
    outline: none;
    width: 190px;
    margin-left: 18px;
  }
  .forget {
    display: block;
    text-align: right;
    color: var(--main-color);
    font-size: 13px;
    margin-top: 15px;
  }
}
</style>
