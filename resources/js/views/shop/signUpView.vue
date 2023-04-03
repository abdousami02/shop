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
                <select name="num-mob" class="form-select num-mob" v-model="user.pre_mobile">
                  <option value="7">07</option>
                  <option value="5">05</option>
                  <option value="6">06</option>
                </select>
                <input type="number" :class="['form-control num', errors.mobile?'is-invalid':'']" placeholder="Phone Number" v-model="user.mobile" />
              </div>
              <span class="text-danger" v-text="handel_error(errors.mobile[0], 'mobile')" v-if="errors.mobile"></span>
            </div>

            <div class="name">
              <label class="form-label" for="name-user">Name</label>
              <input type="text" :class="['form-control', errors.name?'is-invalid':'']" placeholder="Name Consumer" v-model="user.name" />
            </div>
            <div class="stor-name">
              <label class="form-label" for="name-stor">Name Stor</label>
              <input type="text" :class="['form-control', errors.store_name?'is-invalid':'']" placeholder="Name Stor" v-model="user.store_name"/>
            </div>
            <div class="type">
              <label class="form-label" for="type-stor">Type of Stor</label>
              <select name="type" id="type-stor" :class="['form-select', errors.store_type?'is-invalid':'']" v-model="user.store_type">
                <option v-for="elem in store_type" :key="elem" :value="elem.id">{{elem.name}}</option>
              </select>
            </div>

            <div class="wilaya">
              <label for="wilay-sel" class="form-label">Wilaya</label>
              <select name="wilaya" id="wilay-sel" class="form-select" disabled>
                <option value="" selected>Chlef</option>
              </select>
            </div>
            <div class="adr">
              <label for="adr-inp" class="form-label">Address</label>
              <input type="text" :class="['form-control', errors.address?'is-invalid':'']" placeholder="your address" v-model="user.address"/>
            </div>

          </div>

          <!-- password -->
          <div class="password" v-if="pass">
            <h4 class="head">Password</h4>
            <div class="pasw">
              <label for="pass-user" class="form-label">Password</label>
              <input type="password" :class="['form-control', errors.password?'is-invalid':'']" placeholder="Password" v-model="user.password" />
              <span class="text-danger" v-text="handel_error(errors.password[0], 'password')" v-if="errors.password"></span>
            </div>

            <div class="pasw2">
              <label for="pass2-user" class="form-label">Confirm Password</label>
              <input type="password" id="pass2-user" :class="['form-control', errors.password_confirme?'is-invalid':'']" placeholder="Confirm Password" v-model="password_confirme" />
              <span class="text-danger" v-text="errors.password_confirme" v-if="errors.password_confirme"></span>
            </div>

          </div>

          <div class="btns-sel">
            <button @click="prev" v-if="!info" type="button" class="btn btn-outline-info btn-prev">previous</button>
            <button @click="next" v-if="!pass" type="button" class="btn btn-primary btn-next">next</button>
          </div>
          <button @click.prevent="register" type="submite" class="btn-sub" v-if="pass">Register</button>
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
      pass: false,
      store_type: [],
      password_confirme: '',
      user: {
        pre_mobile: 5,
        mobile: '',
        name: '',
        store_name: '',
        store_type: '',
        wilaya: '',
        address: '',
        password: '',
      },

      errors: {},
    };
  },
  methods: {
    getHelpInfo(){
      axios.post("/api/signup", {action: "getHelpInfo"}).then(resp=>{
        console.log(resp);
        this.store_type = resp.data;
      });
    },
    next: function () {

      let data = this.user;
      axios.post("/api/signup", {action: 'checkData', info: data}).then(resp=>{
        console.log(resp.data);
        if(resp.data.status == 'error'){
          if(resp.data.errors)
          this.errors = resp.data.errors;

        }else if(resp.data.status == 'done'){
          this.info = false;
          this.pass = true;
          setTimeout(e=>{$(".pasw input")[0].focus();},100)
        }

      })
    },
    prev: function () {
      this.info = true;
      this.pass = false;
    },
    register(){
      if(this.user.password != this.password_confirme){
        this.errors.password_confirme = "غير متطابقة";

      }else{
        let data = {info: this.user, action: "register"};
        axios.post("/api/signup", data).then(resp=>{
          console.log(resp.data)
          if(resp.data.status == "error"){
            this.errors = resp.data.errors;

          }else if(resp.data.status == 'done'){
            Swal.fire({
              title: 'تم التسجيل بنجاح',
              text: "سيتم مراجعة طلبك من طرف المسؤول و تستقبل رسالة نصية في رقم هاتفك عند الموافقة على طلبك",
              icon: 'success',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'موافق',

            }).then((result) => {
              if (result.isConfirmed) {
                this.$router.push({name: "store"})
              }
            })
          }
        });
      }
    },
    handel_error(data, error){
      if(error == 'mobile'){
        if(data == 'The mobile has already been taken.'){
          return "هذا الرقم مستخدم بالفعل";
        }else{
          return "الرقم غير صالح";
        }

      }else if(error == 'password'){
        return "كلمة السر ضعيفة يجب ان تحتوي على ارقام و حروف";
      }

    },
    show: function () {
      console.log("hi");
    },
    after(){
      if(this.$root.login == true){
        this.$router.push({name: "store"})

      }else{
        this.getHelpInfo();
      }
    }
  },
  mounted: function(){
    if(this.$root.render == true) {this.after(); }

  },
  watch: {
    '$root.render': function(){ this.after(); },

    'user.mobile': function (e) {
      let mob = e.toString();
      if (mob.length > 8) {
        this.user.mobile = mob.slice(0, 8);
      }
    },
  },
};
</script>

