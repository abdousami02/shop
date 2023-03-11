<template>

        <table class="table table-bordered">
          <thead>
            <tr class="head-row">
              <th class="t-0">
                <span class="sel" @click="select_all"></span>
              </th>
              <th>Name</th>
              <th>Price</th>
              <th></th>
            </tr>
          </thead>
          <!-- table body -->
          <tbody>
            <tr class="elem-row">
              <td class="t-0">
                <span class="select"><input type="checkbox"/></span>
              </td>
                <slot></slot>
              <td class="opt dropdown">
                <i data-bs-toggle="dropdown" class="fas fa-ellipsis-v dot-opt" aria-expanded="false"></i>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item edit-elem editData" data-action="edit" href="#" ><i class="far fa-pen c"></i> Edit</a>
                  <a class="dropdown-item delet-elem deleteData" data-action="delete" href="#" ><i class="far fa-trash remove"></i> Remove</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>

</template>

<script>
import $ from "jquery";
export default {
  name: "panelHeader",
  components:{

  },
  props: [
    'tb',
    'th',
    'tbkey',
    'title',
    'addData_func',
    'deleteMultie_func',
    'selected',
    'getData_forPag',
  ],
  methods: {
    // function for select row
    select_all(e) {
      let ele = $(e.target);
      if (ele.hasClass("active")) {
        $(".elem-row.selected").each(function () {
          $(this).find(".select input").click();
        });
        ele.removeClass("active");
      } else {
        $(".elem-row .select input").each(function () {
          ele.addClass('active');
          $(this).click();
        });
      }
    },
    // function for checkbox action in element row
    sel_row(e) {
      // console.log(e)
      // $(e.target).parents(".elem-row").toggleClass("selected");
      // $(".t-0 .sel").addClass("active");
    },
  },
  mounted: function(){
    // setInterval(this.getData_forPag, 10000);
  },
};
</script>

<style lang="scss">

</style>
