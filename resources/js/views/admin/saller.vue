<template>
  <div class="saller">
    <panel-template :title="title" :th="thead" :tb="tbody" :tbkey="tkey"
                  :getData_forPag="getData"
                  :addData_func="addData"
                  :editData_func="editeData"
                  :deleteData_func="deleteData"
                  :deleteMultiData_func="''" >


      <template v-slot="slotProps">
        <td class="id">{{slotProps.row.id}}</td>
        <td class="name">{{slotProps.row.name}}</td>
        <td class="mobile">0{{slotProps.row.mobile || slotProps.row.user.mobile}}</td>
        <td class="type">{{slotProps.row.type}}</td>
        <td class="address">{{slotProps.row.address}}</td>
        <td class="status">
          <span @click="editeStatus(slotProps.row, slotProps.index)"
                :class="['status-btn', slotProps.row.status == 1 ? 'active':'']" >
          </span>
        </td>
        <td class="login">{{slotProps.row.user.last_login}}</td>
      </template>

    </panel-template>

    <!-- Model for Order-->
    <div class="modal fade " id="modal_saller" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ modal.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <div class="info">

              <!-- id User-->
                <div class="id">
                  <span class="name">Saller ID</span>
                  <div class="inp-form">
                    <input :class="['form-control',errors.id?'is-invalid':'']" type="text" name="id" disabled v-bind="saller.id" />
                  </div>
                </div>

                  <!-- User -->
                  <div class="user">
                    <span>User</span>
                    <div class="inp-form">
                      <input type="text" :class="['form-control', errors.name? 'is-invalid':'']" v-model="saller.name">
                      <span class="invalid-feedback" v-text="errors.name?errors.name[0]:''"></span>
                    </div>
                  </div>

                  <!-- Store -->
                  <div class="store">
                    <span>Type</span>
                    <div class="inp-form">
                      <select class="form-select" v-model="saller.type">
                        <option value="Alimontation">Alimontation</option>
                        <option value="Boisson">Boisson</option>
                        <option value="Detergent">Détergent</option>
                        <option value="Froid">Froide</option>
                      </select>
                      <span class="invalid-feedback" v-text="errors.type?errors.type[0]:''"></span>
                    </div>
                  </div>

                  <!-- Saller -->
                  <div class="saller">
                    <span>Mobile</span>
                    <div class="inp-form">
                      <input type="number" :class="['form-control', errors.mobile? 'is-invalid':'']" v-model="saller.mobile">
                      <span class="invalid-feedback" v-text="errors.mobile?errors.mobile[0]:''"></span>
                    </div>
                  </div>

                  <!-- Status -->
                  <div class="addr">
                    <span class="name">Address</span>
                    <div class="inp-form">
                      <input type="text" :class="['form-control', errors.address? 'is-invalid':'']" v-model="saller.address">
                      <span class="invalid-feedback" v-text="errors.address?errors.address[0]:''"></span>
                    </div>
                  </div>

                  <!-- Status -->
                  <div class="status">
                    <span class="name">Status</span>
                    <div class="inp-form select-form">
                      <select name="status" :class="['form-select from-select-sm', errors.status? 'is-invalid':'']" v-model="saller.status" >
                        <option value="0">inactive</option>
                        <option value="1">active</option>
                      </select>
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
import PanelTemplate from "../../components/admin/pan-content.vue";
export default {
  name: "sallerDash",
  components: {
    PanelTemplate,
  },
  data: function () {
    return {
      title: "Saller",
      thead: ["ID", "Name", "mobile", "Type", "Address", "status", "last_login"],
      tbody:{data:{},},
      saller: {},
      modal: {},
      errors: {},
      action_func: '',
    };
  },
  methods: {
    getData(){
      axios.post("/api/admin/saller", {action: "getData"}).then(resp=>{
        console.log(resp);
        this.tbody = resp.data.data;
      })
    },
    editeStatus(elem, index){
      let data = { id: elem.id, status: elem.status == 1 ? 0 : 1, action: "updateStatus"}
      axios.post("/api/admin/saller", data).then(resp=>{
        console.log(resp);

        if(resp.data.status == "done"){
          this.tbody.data[index] = resp.data.data;
          Toast.fire({
            icon: 'success',
            title: 'Success update Status :)'
          })

        }

      })
    },

    //send data and action
    sendAction(){

      let data = this.saller,
      action = this.action_func;
      data.action = action;

      axios.post('/api/admin/saller', data).then(response=>{

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
      this.modal.title = "Add Saller";
      this.modal.btn = "Add";

      this.model_dom.show();
      this.action_func = "add";

    },

    // change sum element in edit
    editeData(elem, index){
      this.inp_disable = true;          // modifie element in DOM
      this.modal.title = "Edit Saller";
      this.modal.btn = "Update";

      console.log(elem)
      let data = Object.assign({},elem);   // get the data and put it in Modal
      this.saller = data;

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
    },

    empty_data(){
      this.modal = {};
      this.errors = {};
    }

  },
  mounted: function(){
    this.getData();
    this.model_dom = new bootstrap.Modal(document.getElementById('modal_saller'), {});
  }
};
</script>
