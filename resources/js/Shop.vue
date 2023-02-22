<template>
  <navbar />
  <router-view />
  <footers />
</template>

<script>
import navbar from "./components/shop/NavBar.vue";
import footers from "./components/shop/footer.vue";

export default {
  components: {
    navbar,
    footers,
  },
};
</script>
