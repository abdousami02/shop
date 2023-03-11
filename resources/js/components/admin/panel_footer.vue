<template>
<div class="product">
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
          <button class="btn btn-outline-danger remove deleteMultiData" data-action="delete_multie"><i class="far fa-trash"></i> Delete</button>
          <button class="btn btn-outline-primary add m-2 addData" data-action="add" @click="addData" ><i class="far fa-plus"></i> Add</button>
          <button class="btn btn-outline-success" @click="getData"><i class="fas fa-sync-alt"></i> Sync</button>
        </div>
        <div class="search">
          <input type="text" class="form-control" placeholder="Search..." />
        </div>
      </div>
      <div class="info-num">
        <div class="num-select"><span class="count">0</span> element selected</div>
        <div class="page-tab"><span class="count1">{{tbody.to}}</span> of <span class="count2">{{tbody.total}}</span> element showing</div>
      </div>

      <div class="panel-content">
        <!-- table heading -->
        <table class="table table-bordered">
          <thead>
            <tr class="head-row">
              <th class="t-0">
                <span class="sel" @click="select_all"></span>
              </th>
              <th v-for="(col) in thead" :key="col">{{ col }}</th>
              <th></th>
            </tr>
          </thead>
          <!-- table body -->
          <tbody>
            <tr class="elem-row" v-for="(row, index) in tbody.data" :key="index" :data-id="row.id" >
              <td class="t-0">
                <span class="select"><input type="checkbox" @click="sel_row($event)" /></span>
              </td>

              <td v-for="(col) in tbkey" :key="col">
                {{ row[col] }}
              </td>
              <!-- <td>none</td>
              <td>none</td> -->

              <td class="opt dropdown">
                <i data-bs-toggle="dropdown" class="fas fa-ellipsis-v dot-opt" aria-expanded="false"></i>
                <div class="dropdown-menu dropdown-menu-end">
                  <a class="dropdown-item edit-elem editData" data-action="edit" href="#" @click="editeData"><i class="far fa-pen c"></i> Edit</a>
                  <a class="dropdown-item delet-elem deleteData" data-action="delete" href="#" @click="deleteData"><i class="far fa-trash remove"></i> Remove</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <!-- pagination -->
      <div class="panel-footer">
        <div class="page-tab"><span class="count1">{{tbody.to}}</span> of <span class="count2">{{tbody.total}}</span> element showing</div>

        <pagination :data="tb" @pagination-change-page="getData_forPag" />

      </div>
    </div>
  </div>

  </div>

</template>

<script>
import $ from "jquery";
export default {
  name: "panelContent",
  components:{

  },
  props: [
    'tb',
    'editData_func',
    'deleteData_func',
    'getData_forPag',
  ],
}


