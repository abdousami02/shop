<template>
  <navbar />
  <router-view />
  <footers />
</template>

<script>
import navbar from "./components/NavBar.vue";
import footers from "./components/footer.vue";

export default {
  name: 'Admin',
  components: {
    navbar,
    footers,
  },
};
</script>
