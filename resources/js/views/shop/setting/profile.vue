<template>
  <div class="profile">
    <h3 class="head-sett">Profile</h3>
    <div class="profile-cont">
    <form action="" method="post" id="info">
      <div class="img sett-row">
        <label>Profile Picture</label>
        <div class="value">
          <div class="image"><img src="https://secure.gravatar.com/avatar/23b3a4bfdadb21bc68c2d96bed3fa4c7?s=96&d=mm&r=g" alt="image-profile" /></div>
          <button class="btn btn-outline-primary" @click="upload()">Change</button>
          <input type="file" ref="image_inp" name="image" id="image-profile" class="d-none" accept="Image/.*">
        </div>
      </div>
      <!-- <div class="user-name sett-row">
        <label for="user_name">user name:</label>
        <div class="value">
          <input type="text" value="abdou034" class="form-control regular" id="user_name" disabled />
        </div>
      </div> -->
      <!-- name -->
      <div class="full-name sett-row">
        <label for="name">Name</label>
        <div class="value">
          <input type="text" name="name" v-model="user_info.name" id="name" class="form-control regular" />
        </div>
      </div>

      <!-- mobile -->
      <div class="num-tel sett-row">
        <label for="num_phone">No mobile</label>
        <div class="value">
          <input type="text" name="mobile" v-model="user_info.mobile" class="form-control regular" id="num_phone" />
        </div>
      </div>

      <!-- email -->
      <div class="email sett-row">
        <label for="email">Email</label>
        <div class="value">
          <input type="email" name="email" id="email" v-model="user_info.email" class="form-control regular" />
        </div>
      </div>

      <!-- password -->
      <div class="pass sett-row">
        <label>Password</label>
        <div class="value">
          <button class="btn btn-outline-info" @click="inp_pwd = true">Change Password</button>
          <div class="pwd" v-if="inp_pwd">
            <input name="password" :type="show_password == false ? 'password' : 'text'" class="form-control regular"  />
            <button class="btn btn-outline-secondary" @click="show_password = show_password ? false : true"><i class="fas fa-eye-slash"></i> {{ show_password ? 'Hide' : 'Show' }}</button>
            <button class="btn btn-outline-secondary" @click="inp_pwd = false">Cancel</button>
          </div>
        </div>
      </div>




      <!-- buttons save & canccel -->
      <div class="btns-act">
        <button class="btn btn-primary" @click="sendForm()">Save Change</button>
        <button class="btn btn-danger">Cancel</button>
      </div>
    </form>
    </div>

    <div>
      <h5>Address</h5>
      <div class="store-name sett-row">
        <label for="store_name">Store Name</label>
        <div class="value">
          <input type="text" v-model="user_info.store_name" id="store_name" class="form-control regular" />
        </div>
      </div>
      <div class="store-type sett-row">
        <label for="store_type">Store Type</label>
        <div class="value">
          <select name="type" v-model="user_info.store_type" class="form-select form-select-sm regular" id="store_type">
            <option value="">Alimantation</option>
            <option value="">Cosmitique</option>
            <option value="">Cafeteria</option>
            <option value="">Restoront</option>
          </select>
        </div>
      </div>

      <div class="addr sett-row">
        <label for="addr">Address:</label>
        <div class="value">
          <textarea name="" v-bind="user_info.address" class="form-control regular" id="addr"></textarea>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from '../../../components/shop/form.vue';
export default {
  name: "ProfileSetting",
  components: {
    Form

  },
  data: function(){
    return {
      user_info: {
        name: '',
      },
      inp_pwd : false,
      show_password: false,
    }
  },
  methods: {
    sendData(){
      axios.post('/api/profile-info', this.group).then(respons=>{
        console.log(respons)
        // this.user_info = respons.data.user;
        let ininfo = respons.data.user;
        this.user_info.name = ininfo.name;
        this.user_info.mobile = ininfo.mobile

      })
    },
    sendForm(e){
      e.preventDefault;
      console.log(e);
    },
    upload(){
      console.log(this.$refs.image_inp.click)
      this.$refs.image_inp.click();
    },
    changpwd(){
      this.$refs.pwd
    }

  },
  mounted: function() {

    this.sendData();
  },
  watch: {

  }
};
</script>

<style lang="scss">
.profile {
  padding-right: 10px;
  margin-bottom: 60px;
  .profile-cont {
    padding: 21px 15px;
    background: #fff;
    border-radius: 6px;
  }
  .sett-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 17px;
    label {
      font-weight: 600;
    }
    .value {
      // max-width: 350px;
      flex-basis: calc(100% - 150px);
      .regular {
        max-width: 350px;
        display: inline-block;
      }
    }
    .pwd {
      input {
        margin: 15px 0;
        margin-right: 5px;
      }
      .btn {
        margin: 0 3px;
      }
    }
  }
  .img {
    .image {
      width: 100px;
    }
    .btn {
      margin-top: 10px;
    }
  }
  .btns-act {
    margin-top: 60px;
    .btn {
      margin-right: 10px;
      min-width: 60px;
    }
  }
}
</style>
