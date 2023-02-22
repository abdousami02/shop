<template>
  <div class="contact">
    <a href="#">hello</a>
    <forme :age="ssd" />
    <textarea name="test"></textarea>
  </div>
</template>

<script>
import forme from "../../components/shop/form.vue";
export default {
  name: "contact-page",
  data: function () {
    return {
      ssd: "34",
    };
  },
  components: {
    forme,
  },
};
</script>
