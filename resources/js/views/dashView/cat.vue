<template>
  <div class="cat">
    <p>categories</p>
    <panel />
  </div>
</template>

<script>
import panel from "../../components/pan-content.vue";
export default {
  name: "categorieDash",
  components: {
    panel,
  },
};
</script>
