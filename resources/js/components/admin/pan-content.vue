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
          <button class="btn btn-outline-danger remove deleteMultiData" data-action="delete_multie" @click="deleteMultie_func"><i class="far fa-trash"></i> Delete</button>
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
            <tr class="elem-row" v-for="(row, index) in tb.data" :key="index" :data-id="row.id" @click="selected(row.id,$event)">
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
                  <a class="dropdown-item edit-elem editData" data-action="edit" href="#" @click="editData_func(row, tb.type)"><i class="far fa-pen c"></i> Edit</a>
                  <a class="dropdown-item delet-elem deleteData" data-action="delete" href="#" @click="deleteData_func(row, tb.type)"><i class="far fa-trash remove"></i> Remove</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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
      temp: 1,
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
    'selected',
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
  },
  mounted: function(){
    // setInterval(this.getData_forPag, 10000);
    setTimeout(e=>{
      console.log(this.tb)
    }, 1500)
  },
  watch: {
    search(str){

      if(this.temp == 1){
        this.temp = 0;
        setTimeout(e=>{
          this.search_str(str);
            this.temp = 1;
        },500)
      }

    }
  }
};
</script>

<style lang="scss">
.panel-dash {
  background: #fff;
  border-radius: 15px;
  font-size: 14px;
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
  .panel-head {
    padding: 15px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #eee;
    .links {
      display: flex;
      font-size: 14px;
      .link a {
        margin-left: 5px;
        text-decoration: none;
        .count {
          color: #646970;
          font-weight: 400;
        }
        &.active {
          color: #000;
          font-weight: 600;
        }
      }
    }
  }
  .panel-body {
    padding: 15px;
    .edit {
      display: flex;
      justify-content: space-between;
      margin-bottom: 20px;
      .search {
        width: 370px;
      }
    }
    .info-num {
      display: flex;
      justify-content: space-between;
      font-size: 14px;
      margin-bottom: 14px;
      padding: 0 10px;
    }
    .opt {
      width: 40px;
      .dot-opt {
        position: relative;
        cursor: pointer;
        z-index: 1;
        margin: 0 10px;
        &:hover::after {
          opacity: 1;
        }
        &::after {
          content: "";
          position: absolute;
          opacity: 0;
          left: 50%;
          top: 50%;
          transform: translate(-50%, -50%);
          width: 37px;
          height: 37px;
          border-radius: 50%;
          background: #eee;
          z-index: -1;
        }
      }
    }
  }
  .panel-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
  }
}

// table content
table {
  .t-0 {
    padding: 0;
    padding-top: 10px;
    width: 30px;
    .sel {
      position: relative;
      display: inline-block;
      width: 16px;
      height: 15px;
      border: 1px solid #666;
      border-radius: 2px;
      top: -3px;
      margin: 0 9px;
      cursor: pointer;
      &::after {
        content: "";
        position: absolute;
        width: 10px;
        height: 3px;
        background: #fff;
        top: calc(50% - 2px);
        left: 2px;
      }
      &.active {
        background: rgb(0, 153, 255);
        border-color: rgb(0, 153, 255);
      }
    }
  }
  .elem-row:hover{
    background: #93d6f03b;
  }
  .elem-row.selected {
    background: #10bdff6e;
  }
}
</style>
