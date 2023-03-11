<template>
  <div class="saller">
    <panel-template :title="title" :th="thead" :tb="tbody" :tbkey="tkey"
                  :getData_forPag="getData"
                  :addData_func="addData"
                  :editData_func="editeData"
                  :deleteData_func="deleteData"
                  :deleteMultiData_func="''" >


    <template #default>
      <td>sami</td>
      <td>354</td>
    </template>

  </panel-template>
  </div>
</template>

<script>
import PanelTemplate from "../../components/admin/pan-content.vue";
export default {
  name: "sallerDash",
  components: {
    PanelTemplate,
  },
  data: function () {
    return {
      title: "Saller",
      thead: ["ID", "Name", "Type", "Address", "status",],
      tbody:{data:{},},
    };
  },
};
</script>
