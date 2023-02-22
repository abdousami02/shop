<template>
  <div class="passwd">
    <form action="">
      <h4 class="head">Password</h4>
      <div class="pasw">
        <label for="pass-user" class="form-label">Password</label>
        <input type="password" name="pass" id="pass-user" class="form-control" placeholder="Password" />
      </div>
      <div class="pasw2">
        <label for="pass2-user" class="form-label">Confirm Password</label>
        <input type="password" id="pass2-user" class="form-control" placeholder="Confirm Password" />
      </div>
      <div class="btns-sel">
        <button @click="func_prev" type="button" class="btn btn-outline-info">previous</button>
      </div>
      <button @click.prevent="func_next" type="submit" class="btn-sub">Register</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "SignupForm",
  props: ["func_next", "func_prev"],
};
</script>
