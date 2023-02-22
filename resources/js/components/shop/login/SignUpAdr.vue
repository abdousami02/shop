<template>
  <div class="signup-addr">
    <div class="container">
      <form action="">
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
        <div class="btns-sel">
          <button @click="func_prev" type="button" class="btn btn-outline-info btn-next">previous</button>
          <button @click.prevent="func_next" type="submit" class="btn btn-primary btn-prev">next</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "adddressForm",
  props: ["func_next", "func_prev"],
  methods: {
    show() {
      console.log("dd");
    },
  },
};
</script>

<style lang="scss">
.btns-sel {
  display: flex;
  justify-content: space-between;
  .btn-next,
  .btn-prev {
    width: 70px;
  }
}
</style>
