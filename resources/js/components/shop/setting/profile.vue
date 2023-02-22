<template>
  <div class="profile">
    <h3 class="head-sett">Profile</h3>
    <div class="profile-cont">
      <div class="img sett-row">
        <label>Profile Picture</label>
        <div class="value">
          <div class="image"><img src="https://secure.gravatar.com/avatar/23b3a4bfdadb21bc68c2d96bed3fa4c7?s=96&d=mm&r=g" alt="image-profile" /></div>
          <button class="btn btn-outline-primary">Change</button>
        </div>
      </div>
      <div class="user-name sett-row">
        <label for="user_name">user name:</label>
        <div class="value">
          <input type="text" value="abdou034" class="form-control regular" id="user_name" disabled />
        </div>
      </div>
      <div class="full-name sett-row">
        <label for="name">Name</label>
        <div class="value">
          <input type="text" id="name" class="form-control regular" />
        </div>
      </div>
      <div class="store-name sett-row">
        <label for="store_name">Store Name</label>
        <div class="value">
          <input type="text" id="store_name" class="form-control regular" />
        </div>
      </div>
      <div class="store-type sett-row">
        <label for="store_type">Store Type</label>
        <div class="value">
          <select name="type" class="form-select form-select-sm regular" id="store_type">
            <option value="">Alimantation</option>
            <option value="">Cosmitique</option>
            <option value="">Cafeteria</option>
            <option value="">Restoront</option>
          </select>
        </div>
      </div>
      <div class="num-tel sett-row">
        <label for="num_phone">No mobile</label>
        <div class="value">
          <input type="number" class="form-control regular" id="num_phone" />
        </div>
      </div>
      <div class="addr sett-row">
        <label for="addr">Address:</label>
        <div class="value">
          <textarea name="" class="form-control regular" id="addr"></textarea>
        </div>
      </div>
      <div class="email sett-row">
        <label for="email">Email</label>
        <div class="value">
          <input type="email" name="email" id="email" class="form-control regular" />
        </div>
      </div>
      <div class="pass sett-row">
        <label>Password</label>
        <div class="value">
          <button class="btn btn-outline-info">Change Password</button>
          <div class="pwd">
            <input type="text" class="form-control regular" />
            <button class="btn btn-outline-secondary"><i class="fas fa-eye-slash"></i> Hide</button>
            <button class="btn btn-outline-secondary">Cancel</button>
          </div>
        </div>
      </div>
      <!-- buttons save & canccel -->
      <div class="btns-act">
        <button class="btn btn-primary">Save Change</button>
        <button class="btn btn-danger">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ProfileSetting",
};
</script>

<style lang="scss">
.profile {
  padding-right: 10px;
  margin-bottom: 60px;
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
