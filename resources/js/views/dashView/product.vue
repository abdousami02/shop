<template>
  <div class="product">
    <p>product</p>
    <panel :title="title" :th="thead" :tb="tbody" />
  </div>
</template>

<script>
import panel from "../../components/pan-content.vue";
export default {
  name: "ProductDash",
  components: {
    panel,
  },
  data: function () {
    return {
      title: "product",
      thead: ["ID", "Name", "No Telphon", "Stor Name", "Stor Type", "Status", "Order In Progress", "All Order"],
      tbody: {
        4: [4, "amin", "0699426634", "Adam Shop", "Supperett", "actvie", "2", "14"],
        8: [8, "abdelrahman", "0773982345", "Abdou Shop", "Alimantation", "inactive", "0", "0"],
      },
    };
  },
};
</script>
