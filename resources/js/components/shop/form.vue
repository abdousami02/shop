<template>
  <div class="form">
    <form action="">
      <input type="text" :value="age" />
      <input type="text" />
      <input type="submit" />
    </form>
    <div class="container">
      <div class="alert alert-primary alert-dismissible fade show" role="alert">
        A simple primary alert—check it out!
        <button type="button" class="btn-close close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "form-contact",
  props: ["age"],
};
</script>
