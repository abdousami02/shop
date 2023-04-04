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
                <select name="num-mob" class="form-select num-mob" v-model="saller.pre_mobile">
                  <option value="7">07</option>
                  <option value="5">05</option>
                  <option value="6">06</option>
                </select>
                <input type="number" :class="['form-control num', errors.mobile?'is-invalid':'']" placeholder="Phone Number" v-model="saller.mobile" />
              </div>
              <span class="text-danger" v-text="handel_error(errors.mobile[0], 'mobile')" v-if="errors.mobile"></span>
            </div>

            <div class="name">
              <label class="form-label" for="name-user">Name</label>
              <input type="text" :class="['form-control', errors.name?'is-invalid':'']" placeholder="Name" v-model="saller.name" />
            </div>
            <div class="type">
              <label class="form-label" for="type-stor">Type</label>
              <select class="form-select" v-model="saller.type">
                <option value="Alimontation">Alimontation</option>
                <option value="Boisson">Boisson</option>
                <option value="Detergent">Détergent</option>
                <option value="Froid">Froide</option>
              </select>
            </div>
            <div class="adr">
              <label for="adr-inp" class="form-label">Address</label>
              <input type="text" :class="['form-control', errors.address?'is-invalid':'']" placeholder="address" v-model="saller.address"/>
            </div>

            <div class="pasw">
              <label for="pass-user" class="form-label">Password</label>
              <input type="password" name="password" :class="['form-control', errors.password?'is-invalid':'']" placeholder="Password" v-model="saller.password" />
              <span class="text-danger" v-text="handel_error(errors.password[0], 'password')" v-if="errors.password"></span>
            </div>

            <div class="pasw2">
              <label for="pass2-user" class="form-label">Confirm Password</label>
              <input type="password" id="pass2-user" :class="['form-control', errors.password_confirme?'is-invalid':'']" placeholder="Confirm Password" v-model="password_confirme" />
              <span class="text-danger" v-text="errors.password_confirme" v-if="errors.password_confirme"></span>
            </div>

          </div>
          <button @click.prevent="register" type="submite" class="btn-sub" >Register</button>
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
      saller: {
        pre_mobile: 5,
        mobile: '',
        name: '',
        type: '',
        address: '',
        password: '',
      },

      errors: {},
    };
  },
  methods: {

    register(){
      if(this.saller.password != this.password_confirme){
        this.errors.password_confirme = "غير متطابقة";

      }else{
        let data = {info: this.saller, action: "registerSaller"};
        axios.post("/api/signup", data).then(resp=>{
          // console.log(resp.data)
          if(resp.data.status == "error"){
            this.errors = resp.data.errors;

          }else if(resp.data.status == 'done'){
            Swal.fire({
              title: 'تم التسجيل بنجاح',
              text: "سيتم مراجعة طلبك من طرف المسؤول",
              icon: 'success',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'موافق',

            }).then((result) => {
              if (result.isConfirmed) {
                this.$router.push({path: "/"})
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
      // console.log("hi");
    },
    after(){
      if(this.$root.login == true){
        // this.$router.push({name: "store"})
      }
    }
  },
  mounted: function(){
    if(this.$root.render == true) {this.after(); }

  },
  watch: {
    '$root.render': function(){ this.after(); },

    'saller.mobile': function (e) {
      let mob = e.toString();
      if (mob.length > 8) {
        this.saller.mobile = mob.slice(0, 8);
      }
    },
  },
};
</script>

