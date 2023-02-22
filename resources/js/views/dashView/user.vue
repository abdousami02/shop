<template>
  <div class="users">
    <p>users</p>
    <panel />
  </div>
</template>

<script>
import $ from "jquery";
import panel from "../../components/pan-content.vue";
export default {
  name: "userDash",
  data: function () {
    return {
      connect: "http://localhost/php/init.php?page=user",
    };
  },
  components: {
    panel,
  },
  methods: {
    getData() {
      console.log(this.connect);
      $.get(this.connect + "page=user", function (data) {
        console.log(data);
      });
    },
  },
  mounted: function () {
    this.getData();
  },
};
</script>
