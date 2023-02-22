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
    <div class="panel-body">
      <div class="edit">
        <div class="btns">
          <button class="btn btn-outline-danger remove"><i class="far fa-trash"></i> Delete</button>
          <button class="btn btn-outline-primary add ms-2"><i class="far fa-plus"></i> Add</button>
        </div>
        <div class="search">
          <input type="text" class="form-control" placeholder="Search..." />
        </div>
      </div>
      <div class="info-num">
        <div class="num-select"><span class="count">0</span> element selected</div>
        <div class="page-tab"><span class="count1">10</span> of <span class="count2">32</span> element showing</div>
      </div>
      <div class="panel-content">
        <table class="table table-bordered">
          <thead>
            <tr class="head-row">
              <th class="t-0">
                <span class="sel" @click="select_all"></span>
              </th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr class="hid-row d-none">
              <td class="t-0">
                <span class="select"><input type="checkbox" /></span>
              </td>
              <td class="opt dropdown">
                <i data-bs-toggle="dropdown" class="fas fa-ellipsis-v dot-opt" aria-expanded="false"></i>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item edit-elem" data-action="edit" href="" data-toggle="modal" data-target="#"><i class="far fa-pen c"></i> Edit</a>
                  <a class="dropdown-item delet-elem" data-action="delete" href=""><i class="far fa-trash remove"></i> Remove</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="panel-footer">
        <div class="page-tab"><span class="count1">10</span> of <span class="count2">32</span> element showing</div>
        <ul class="pagination" aria-label="Page navigation">
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a>
          </li>
          <li class="page-item"><a class="page-link" href="#">1</a></li>
          <li class="page-item"><a class="page-link" href="#">2</a></li>
          <li class="page-item"><a class="page-link" href="#">3</a></li>
          <li class="page-item">
            <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  name: "panelContent",
  props: {
    th: Array,
    tb: Object,
    title: String,
  },
  // data: function () {
  //   return {
  //     title: "",
  //     th: ["ID", "Name", "No Telphon", "Stor Name", "Stor Type", "Status", "Order In Progress", "All Order"],
  //     tb: {
  //       4: [4, "amin", "0699426634", "Adam Shop", "Supperett", "actvie", "2", "14"],
  //       8: [8, "abdelrahman", "0773982345", "Abdou Shop", "Alimantation", "inactive", "0", "0"],
  //     },
  //   };
  // },
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
          $(this).click();
        });
      }
    },
    // function for checkbox action in element row
    sel_row(e) {
      $(e.target).parents(".elem-row").toggleClass("selected");
      $(".t-0 .sel").addClass("active");
    },
    // ince data in DOM (this fucntion run automaticly)
    data_in() {
      //inc table heade
      let tab_head = $(".head-row .t-0");
      console.log();
      let v = this.th;
      console.log(v);
      v.reverse().forEach((elem) => {
        let e = $(`<th>${elem}</th>`);
        tab_head.after(e);
      });
      //inc table body content
      let tab_cont = $("tbody");
      let tab_cont_first = $(".hid-row .t-0")[0].outerHTML;
      let tab_cont_last = $(".hid-row .opt")[0].outerHTML;

      for (let elem in this.tb) {
        let e = $(`<tr class="elem-row" data-userID="${elem}">dd</tr>`);
        e.append(tab_cont_first);
        this.tb[elem].forEach((el) => {
          $(e).append(`<td>${el}</td>`);
        });
        e.append(tab_cont_last);
        tab_cont.append(e);
      }
    },
  },
  mounted: function () {
    // run auto this function for inc data in DOM
    if (this.th) {
      this.data_in();
    }
    //run this function for elemen incriment to DOM
    $(".elem-row .select input").click((e) => {
      this.sel_row(e);
    });
    console.log(this.tb);
    console.log(this.th);
  },
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
  tr.selected {
    background: #10bdff6e;
  }
}
</style>
