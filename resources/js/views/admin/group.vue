<template>
  <div class="group">

    <panel :title="title" :th="thead" :tb="tbody" :tbkey="tkey"
            :getData_forPag="getData"
            :addData_func="addData"
            :editData_func="editeData"
            :deleteData_func="deleteData"
            :deleteMultiData_func="''" >

        <template v-slot="slotProps">
          <td class="">{{ slotProps.row.id }}</td>
          <td class="">{{ slotProps.row.name }}</td>
          <td class=""><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td>
        </template>
    </panel>

    <!-- Model for add or modifie -->
    <div class="modal fade " id="modal_group" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ modal.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="info">
              <!-- id Group-->
              <div class="id">
                <span class="name">Group ID</span>
                <div class="inp-form">
                  <input :class="['form-control',errors.id?'is-invalid':'']" type="text" name="id" :disabled="inp_disable" v-model="group.id" />
                  <span class="invalid-feedback" v-text="errors.id?errors.id[0]:''"></span>
                </div>
              </div>
              <!-- name Group -->
              <div class="name">
                <span class="name">Group Name</span>
                <div class="inp-form">
                  <input :class="['form-control',errors.name?'is-invalid':'']" type="text" name="name" v-model="group.name" />
                  <span class="invalid-feedback" v-text="errors.name?errors.name[0]:''"></span>
                </div>
              </div>

              <!-- status Group -->
              <div class="status">
                <span class="name">Status</span>
                <div class="inp-form">
                  <select name="status" :class="['form-select from-select-sm',errors.status?'is-invalid':'']" v-model="group.status" >
                    <option value="1">active</option>
                    <option value="0">inactive</option>
                  </select>
                  <span class="invalid-feedback" v-text="errors.status?errors.status[0]:''"></span>
                </div>
              </div>
            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="empty_data()" data-bs-dismiss="modal">Canccel</button>
            <button type="button" class="btn btn-primary" @click="sendAction()">{{ modal.btn }}</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
import panel from "../../components/admin/pan-content.vue";

export default {
  name: "group",
  data: function() {
    return {
      title: "Permition",
      thead: ["GroupID", "Name", "status", ], //"Number in Group", "user in Group"
      tbody: '',
      tkey: ['id', 'name', 'status'],
      inp_disable: true,
      group: {
        id: "",
        name: "",
        status: 0,
      },
      old_group: Object.assign({},this.group),
      modal: {
        title: 'Groupe',
        btn: 'save',
      },

      errors: {},
      model_dom: '',
      action_func: '',
    };
  },
  components:{
    panel,

  },
  methods: {

    //empty modal from data
    empty_data(){
      this.group = this.old_group;
    },


    // get data
    getData(page = 1, id = 'all'){
      let action = 'getData';
      axios.post("/api/group?page="+ page, {action: action, id: id}).then(response =>{

          // if don't have permition
        if(response.data.status == "permition"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Don't have Permition!",
            // footer: '<a href="">Why do I have this issue?</a>'
          })

        // if not
        }else{
          this.tbody = '';
          this.tbody = response.data.data
        }
      })
    },


    //send data and action
    sendAction(selected){

      let data = this.group,
      action = this.action_func;

      (selected != undefined && action == 'delete') ? data = {id: selected} : '';
      data.action = action;

      axios.post('/api/group', data).then(response=>{

        // if have errore
        if(response.data.status == "permition"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Don't have Permition!",
          })

          // if not
        }else{
          this.responseHandel(response, action);
        }
      })
    },

    //response handele data
    responseHandel(response, action){
      let status_resp = response.data.status;

      // if haver error
      if(status_resp == "error" && action != 'delete'){
        this.errors = response.data.errors;

      // if not have error
      } else if(status_resp == "done" && action != 'delete'){
        this.errors = "";
        this.getData();
        this.model_dom.hide();
        this.empty_data();
        Toast.fire({
          icon: 'success',
          title: 'Success '+ action +' Group'
        })

      }else if( action == 'delete' && status_resp == "done"){
        this.getData();
        Swal.fire(
          'Deleted!',
          'Group has been deleted.',
          'success'
        );

      }else if( action == 'delete' && status_resp == "error"){
        Swal.fire(
          'Error',
          "Can't delete this group  :(",
          'error'
        );
      }
    },

    // change sum element in add
    addData(){
      this.inp_disable = false;
      this.modal.title = "Add Group";
      this.modal.btn = "Add";

      this.model_dom.show();
      this.action_func = "add";

    },

    // change sum element in edit
    editeData(e){
      this.inp_disable = true;          // modifie element in DOM
      this.modal.title = "Edit Group";
      this.modal.btn = "Update";

      let data = Object.assign({},e);   // get the data and put it in Modal
      this.group = data;

      this.model_dom.show();
      this.action_func = "update";

    },

    // show message whene delete
    deleteData(elem){
      Swal.fire({
        title: 'Are you sure to delete?',
        text: "Delete Group: " + elem.name,
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

      }).then((result) => {
        if (result.isConfirmed) {

          this.action_func = "delete";
          this.sendAction(elem.id);
        }
      })
    }
  },
  mounted: function (){
    setTimeout(this.getData, 200);
    this.model_dom = new bootstrap.Modal(document.getElementById('modal_group'), {});
  },
};
</script>

<style lang="scss" scoped>
.group .table {
  max-width: 800px;
}
.modal-dialog {
    margin-top: 200px;
  }
</style>
