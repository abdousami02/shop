<template>
  <div class="signup">
    <div class="container">
      <div class="panel">
        <form-info v-if="info" :func_next="next" />
        <form-adr v-if="adr" :func_next="next" :func_prev="prev" />
        <form-pass v-if="pass" :func_prev="prev" />
        <div>
          <span class="separ" @click="show">OR</span>
          <p class="switch">Have already Account? <router-link to="/login" href="#">Login</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import formInfo from "../../components/shop/login/SignUpInfo.vue";
import formAdr from "../../components/shop/login/SignUpAdr.vue";
import formPass from "../../components/shop/login/SignUpPass.vue";

export default {
  name: "signUp",
  components: {
    formInfo,
    formAdr,
    formPass,
  },
  data: function () {
    return {
      pos: 1,
      info: true,
      adr: false,
      pass: false,
    };
  },
  methods: {
    next: function () {
      if (this.pos == 1) {
        this.info = false;
        this.adr = true;
        this.pos = 2;
      } else if (this.pos == 2) {
        this.adr = false;
        this.pass = true;
        this.pos = 3;
      }
    },
    prev: function () {
      if (this.pos == 2) {
        this.info = true;
        this.adr = false;
        this.pos = 1;
      } else if (this.pos == 3) {
        this.adr = true;
        this.pass = false;
        this.pos = 2;
      }
    },
    show: function () {
      console.log("hi");
    },
  },
};
</script>

<style lang="scss">
.signup {
  .panel {
    .head {
      text-align: center;
    }
    form {
      max-width: 300px;
      & > div {
        margin-bottom: 20px;
        padding: 0 5px;
      }
    }
  }
}
</style>
