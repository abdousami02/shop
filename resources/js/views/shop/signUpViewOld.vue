<template>
  <div class="signup">
    <div class="container">
      <div class="panel">

        <form action="" method="post">

          <!-- info mobile and stor  -->
          <div class="info" v-if="info">
            <h3 class="head">Register</h3>
            <div class="num-tel">
              <label class="form-label" for="phone-user">Number Phone:</label>
              <div class="d-flex">
                <select name="num-mob" class="form-select num-mob">
                  <option value="">07</option>
                  <option value="">05</option>
                  <option value="">06</option>
                </select>
                <input type="number" name="phone" id="phone-user" class="form-control num" placeholder="Phone Number" v-model="num" />
              </div>
            </div>
            <div class="name">
              <label class="form-label" for="name-user">Name</label>
              <input type="text" name="name" id="name-user" class="form-control" placeholder="Name Consumer" />
            </div>
            <div class="stor-name">
              <label class="form-label" for="name-stor">Name Stor</label>
              <input type="text" name="name" id="name-stor" class="form-control" placeholder="Name Stor" />
            </div>
            <div class="type">
              <label class="form-label" for="type-stor">Type of Stor</label>
              <select name="type" id="type-stor" class="form-select">
                <option value="">Alimontation</option>
                <option value="">Supperette</option>
                <option value="">Cosmitique</option>
                <option value="">Caffetirea</option>
                <option value="">Resterant</option>
              </select>
            </div>
          </div>

          <!-- address  -->
          <div v-if="adr">
            <h4 class="head">Address</h4>
            <div class="wilaya">
              <label for="wilay-sel" class="form-label">Wilaya</label>
              <select name="wilaya" id="wilay-sel" class="form-select" disabled>
                <option value="" selected>Chlef</option>
              </select>
            </div>
            <div class="adr">
              <label for="adr-inp" class="form-label">Address</label>
              <input @click="show" type="text" id="adr-inp" name="address" class="form-control" placeholder="your address" />
            </div>
          </div>

          <!-- password -->
          <div class="password" v-if="pass">
            <h4 class="head">Password</h4>
            <div class="pasw">
              <label for="pass-user" class="form-label">Password</label>
              <input type="password" name="pass" id="pass-user" class="form-control" placeholder="Password" />
            </div>
            <div class="pasw2">
              <label for="pass2-user" class="form-label">Confirm Password</label>
              <input type="password" id="pass2-user" class="form-control" placeholder="Confirm Password" />
            </div>

          </div>

          <div class="btns-sel">
            <button @click="prev" v-if="!info" type="button" class="btn btn-outline-info btn-prev">previous</button>
            <button @click="next" v-if="!pass" type="button" class="btn btn-primary btn-next">next</button>
          </div>
          <button @click.prevent="next" type="button" class="btn-sub" v-if="pass">Register</button>
        </form>

        <div>
          <span class="separ" @click="show">OR</span>
          <p class="switch">Have already Account? <router-link to="/login" href="#">Login</router-link></p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  name: "signUp",
  data: function () {
    return {
      pos: 1,
      info: true,
      adr: false,
      pass: false,
      num: '',
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
      // console.log("hi");
    },
  },
  watch: {
    num: function (e) {
      let mob = e.toString();
      // console.log(mob.length);
      if (mob.length > 8) {
        this.num = mob.slice(0, 8);
      }
    },
  },
};
</script>

