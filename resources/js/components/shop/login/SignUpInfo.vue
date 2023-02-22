<template>
  <div>
    <form action="" method="post">
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
      <div class="btns-sel justify-content-end">
        <button @click.prevent="func_next" type="submit" class="btn btn-primary btn-next">next</button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: "SignUp1",
  data: function () {
    return {
      num: "",
    };
  },
  props: ["func_next"],
  watch: {
    num: function (e) {
      console.log(e.length);
      if (e.length > 8) {
        this.num = e.slice(0, 8);
      }
    },
  },
};
</script>

<style lang="scss">
.num-tel {
  .num-mob {
    width: 80px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
  }
  .num {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
  }
}
</style>
