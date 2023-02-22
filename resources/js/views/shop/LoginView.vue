<template>
  <div>
    <div class="container">
      <div class="panel">
        <form action="" method="POST" class="login">
          <h3 class="head">Login</h3>
          <div class="name">
            <i class="far fa-user fa-lg icon"></i>
            <input type="text" name="username" placeholder="username or No phone" />
          </div>
          <div class="pass">
            <i class="far fa-lock-alt fa-lg icon"></i>
            <input type="password" name="username" placeholder="password" />
          </div>
          <a to="/signUp" href="#" class="forget">Forget Password?</a>
          <button @click.prevent type="botton" class="btn-sub">Login</button>
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
};
</script>

<style lang="scss">
:root {
  --main-color: #103262;
}

//style for signin & signUp
.panel {
  max-width: 500px;
  width: 90%;
  background: #fff;
  margin: 50px auto;
  border-radius: 20px;
  padding: 35px 25px;

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
    width: 200px;
    margin-left: 15px;
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
