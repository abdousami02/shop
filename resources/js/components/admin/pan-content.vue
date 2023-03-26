<template>
  <div class="panel-dash">
    <div class="panel-head">
      <h4 class="title" v-text="title"></h4>
      <ul class="links">
        <li class="link">
          <a href="#" class="active">All <span class="count">(44)</span></a> |
        </li>
        <li class="link">
          <a href="#">Pending <span class="count">(12)</span></a> |
        </li>
        <li class="link">
          <a href="#">Canccel <span class="count">(8)</span></a>
        </li>
      </ul>
    </div>
    <!-- btn top & searchBar to edit or deleat multi -->
    <div class="panel-body">
      <div class="edit">
        <div class="btns">

          <!-- buttons slot -->
          <slot name="btns"></slot>
          <button class="btn btn-outline-primary add m-2 addData" data-action="add" @click="addData_func(tb.type)" ><i class="far fa-plus"></i> Add</button>
          <button class="btn btn-outline-success" @click="getData_forPag(tb.current_page,tb.type)"><i class="fas fa-sync-alt"></i> Sync</button>
        </div>
        <div class="search">
          <input type="text" class="form-control" placeholder="Search..." v-model="search"/>
          <div class="resulte">
            <slot name="search"></slot>
          </div>
        </div>
      </div>

      <!-- header Slot -->
      <slot name="header"></slot>

      <div class="info-num">
        <div class="num-select"><span class="count">0</span> element selected</div>
        <div class="page-tab"><span class="count1">{{tb.to}}</span> of <span class="count2">{{tb.total}}</span> element showing</div>
      </div>

      <div class="panel-content">
        <!-- table heading -->
        <table class="table table-bordered">
          <thead>
            <tr class="head-row">
              <th class="t-0">
                <span class="sel" @click="select_all"></span>
              </th>
              <th v-for="(col) in th" :key="col">{{ col }}</th>
              <th></th>
            </tr>
          </thead>
          <!-- table body -->
          <tbody>
            <tr class="elem-row" v-for="(row, index) in tb.data" :key="index" :data-id="row.id" @click="click_row(row.id,$event)" @dblclick="dblclick_row(row)">
              <td class="t-0">
                <span class="select"><input type="checkbox" @click="sel_row($event)" /></span>
              </td>

              <slot :row="row" :index="index"></slot>
              <!-- <td v-for="(col) in row" :key="col">
                {{ col }}
              </td> -->

              <td class="opt dropdown">
                <i data-bs-toggle="dropdown" class="fas fa-ellipsis-v dot-opt" aria-expanded="false"></i>
                <div class="dropdown-menu dropdown-menu-end">
                  <slot name="btns_opt" :row="row" :index="index">
                    <a class="dropdown-item edit-elem editData" data-action="edit" @click="editData_func(row, tb.type)"><i class="far fa-pen c"></i> Edit</a>
                    <a class="dropdown-item delet-elem deleteData" data-action="delete" @click="deleteData_func(row, tb.type)"><i class="far fa-trash remove"></i> Remove</a>

                  </slot>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- footer Slot -->
      <slot name="footer"></slot>

      <!-- pagination -->
      <div class="panel-footer">
        <div class="page-tab"><span class="count1">{{tb.to}}</span> of <span class="count2">{{tb.total}}</span> element showing</div>

        <pagination :data="tb" @pagination-change-page="getData_forPag" />

      </div>
    </div>

  <!-- for user as components -->

  <!-- <panel-template :title="title" :th="thead" :tb="tbody" :tbkey="tkey"
                  :getData_forPag="getData"
                  :addData_func="addData"
                  :editData_func="editeData"
                  :deleteData_func="deleteData"
                  :deleteMultiData_func="''" >

    <template #search>
      <p>hello</p>
    </template>

    <template #default>
      <td>sami</td>
      <td>354</td>
    </template>

  </panel-template> -->
  </div>

</template>
<script>
import $ from "jquery";
export default {
  name: "panelContent",
  components:{

  },
  data: function(){
    return {
      search: '',
      search_temp: 1,
      search_length: 0,
      str: '',
    };
  },
  props: [
    'tb',
    'th',
    'tbkey',
    'title',
    'addData_func',
    'deleteMultie_func',
    'editData_func',
    'deleteData_func',
    'getData_forPag',
    'search_str',
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
    click_row(id,event){
      this.$parent.click_row ? this.$parent.click_row(id,event, this.tb.type) : '';

      let row = $(event.target).parents('.elem-row');
      if(row.hasClass('selected')){
        row.removeClass('selected')

      }else{
        row.siblings().removeClass('selected');
        row.addClass('selected')
      }
    },
    dblclick_row(row){
      // console.log('dbl click');
      this.$parent.dblclick_row ? this.$parent.dblclick_row(row, this.tb.type):'';

    },
  },
  mounted: function(){
    // setInterval(this.getData_forPag, 10000);
  },
  watch: {
    search(str){
      this.search_str(str);
    }
  }
};
</script>

