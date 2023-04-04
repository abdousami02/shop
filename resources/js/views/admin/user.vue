<template>
  <div class="users">
    <panel :title="title" :th="thead" :tb="tbody" :tbkey="tkey"
            :getData_forPag="getData"
            :addData_func="addData"
            :editData_func="editeData"
            :deleteData_func="deleteData"
            :deleteMultiData_func="''" >

      <template v-slot="slotProps">
        <td class="">{{ slotProps.row.id }}</td>
        <td class="">{{ slotProps.row.name }}</td>
        <td class="">{{ '0'+slotProps.row.mobile }}</td>
        <td class="">{{ slotProps.row.email }}</td>
        <td class="">{{ slotProps.row.rank }}</td>
        <td class="status"><span @click="editeStatus(slotProps.row, slotProps.index)" :class="['status-btn', slotProps.row.status == 1 ? 'active':'']" ></span></td>
        <td class="">{{ slotProps.row.group.name }}</td>
        <td class="">{{ slotProps.row.last_login }}</td>
        <td class="">
          <ul>
            <li v-for="elem in slotProps.row.store_info" :key="elem">
              <span>{{elem.name}}</span>, <span>{{elem.address}}</span>
            </li>
          </ul>
        </td>
      </template>
    </panel>


    <!-- ***** Model for add or modifie ***** -->
    <div class="modal fade " id="modal_user" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ modal.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">

            <form action="" id="user_info" @submit.prevent="sendActionUser">
              <div class="info">
                <!-- id User-->
                <div class="id">
                  <span class="name">user ID</span>
                  <div class="inp-form">
                    <input :class="['form-control',errors.id?'is-invalid':'']" type="text" name="id" disabled v-model="user.id" />
                    <span class="invalid-feedback" v-text="errors.id?errors.id[0]:''"></span>
                  </div>
                </div>

                <!-- name User -->
                <div class="name">
                  <label for="name-user" class="name">Name</label>
                  <div class="inp-form">
                    <input :class="['form-control',errors.name?'is-invalid':'']" id="name-user" type="text" name="name" v-model="user.name" required />
                    <span class="invalid-feedback" v-text="errors.name?errors.name[0]:''"></span>
                  </div>
                </div>
                <!-- Password User -->
                <div class="password position-relative" v-if="action_func == 'add' || this.edite_pass">
                  <label for="user-passw" class="name">Password</label>
                  <div class="inp-form">
                    <input :class="['form-control',errors.password?'is-invalid':'']" id="user-passw" :type="user.is_pass_show ? 'text' : 'password'" v-model="user.password" />
                    <span class="invalid-feedback" v-text="errors.password?errors.password[0]:''"></span>
                    <i class="far fa-eye show-pass" @click="show_pass"></i>
                  </div>
                </div>
                <!-- mobile User -->
                <div class="mobile">
                  <label for="user-mobile" class="name">Mobile</label>
                  <div class="inp-form">
                    <input :class="['form-control',errors.mobile?'is-invalid':'']"  id="user-mobile" type="number" name="mobile" v-model="user.mobile" />
                    <span class="invalid-feedback" v-text="errors.mobile?errors.mobile[0]:''"></span>
                  </div>
                </div>
                <!-- email User -->
                <div class="email">
                  <label for="user-email" class="name">Email</label>
                  <div class="inp-form">
                    <input :class="['form-control',errors.email?'is-invalid':'']" id="user-email" type="email" name="email" v-model="user.email" />
                    <span class="invalid-feedback" v-text="errors.email?errors.email[0]:''"></span>
                  </div>
                </div>

                <!-- Group user -->
                <div class="group">
                  <span class="name">Group</span>
                  <div class="inp-form select-form">
                    <select name="status" :class="['form-select from-select-sm', errors.group_id? 'is-invalid':'']" v-model="user.group_id">
                      <option v-for="group in response.groups" :key="group" :value="group.id">{{group.name}}</option>
                    </select>
                  </div>
                </div>

                <!-- status User -->
                <div class="status">
                  <span class="name">Status</span>
                  <div class="inp-form select-form">
                    <select name="status" :class="['form-select from-select-sm', errors.status? 'is-invalid':'']" v-model="user.status" >
                      <option value="1">active</option>
                      <option value="0">inactive</option>
                    </select>
                  </div>
                </div>

                <!-- Rank User -->
                <div class="rank">
                  <span class="name">Rank</span>
                  <div class="inp-form select-form">
                    <input name="rat" :class="['form-control from-control-sm', errors.rank? 'is-invalid':'']" v-model="user.rank" />
                    <span class="invalid-feedback" v-text="errors.name?errors.rank:''"></span>
                  </div>
                </div>

                <button type="button" class="btn btn-primary" v-if="action_func == 'update'" @click="function(){edite_pass = true}">edite Password</button>
              </div>

              <div class="store-info">
                <div class="store-row" v-for="(store, index) in user.store_info" :key="index">  <!-- loop in this  -->
                  <h5>Store: {{index + 1}}</h5>
                  <input type="text" name="id" class="d-none" disabled v-model="store.id">
                  <div class="info-row">
                    <div class="stor-name">
                      <span>Store Name: </span>
                      <input type="text" :class="['form-control form-control-sm',errors.store_info[index].name?'is-invalid':'']" :disabled="!store.not_disabled" v-model="store.name" required />
                    </div>
                    <div class="store-type">
                      <span>Store Type: </span>
                      <select :class="['form-select from-select-sm', errors.store_info[index].type_id? 'is-invalid':'']" :disabled="!store.not_disabled" v-model="store.store_type_id" required>
                      <option v-for="type in response.store_type" :key="type" :value="type.id">{{type.name}}</option>
                    </select>
                    </div>
                  </div>

                  <div class="store_addr">
                    <span>Addresss:</span>
                    <input type="text" :class="['form-control form-control-sm',errors.store_info[index].address?'is-invalid':'']" :disabled="!store.not_disabled" v-model="store.address" required />
                  </div>
                  <!-- buttons -->
                  <div class="btns-edit-store">
                    <button type="button" class="btn btn-outline-primary" v-if="store.edite != true" @click.prevent="edite_store(store, index)"><i class="far fa-pen m-1"></i>Edit</button>
                    <button type="button" class="btn btn-outline-success" v-if="store.edite == true" @click.prevent="edite_store(store, index)"><i class="far fa-save m-1"></i>Save</button>
                    <button type="button" class="btn btn-outline-danger" @click.prevent="delete_store(store, index)"><i class="far fa-trash m-1"></i>Delete</button>
                  </div>
                </div>
                <button type="button" class="btn btn-primary ms-2 add" data-action="add_address" @click.prevent="addStore" ><i class="far fa-plus m-1"></i>Add Store</button>
              </div>

            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="empty_data()" data-bs-dismiss="modal">Canccel</button>
            <button type="submit" form="user_info" class="btn btn-primary">{{ modal.btn }}</button>
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
  name: "userDash",
  data: function() {
    return {
      title: "Users",
      thead: ["ID", "Name", "Mobile", "Email", "Rank", "Status", "Group", "Last Login", "Store Info"],
      tbody: {},
      inp_disable: true,
      mobile: '',
      pref_mobile: '05',
      user: {
        id: "",
        name: "",
        is_pass_show: false,
        mobile: "",
        email: "",
        rank: 1,
        status: 0,
        group_id: 5,
        store_info: [{not_disabled: true, edite: true,},],
      },
      edite_pass: false,
      old_user: '',
      response: {},
      modal: {
        title: 'User',
        btn: 'save',
      },
      errors: {store_info: [{}, {}, {},{},{},{},{}]},
      old_errors: '',
      model_dom: '',
      action_func: '',
      token: localStorage.getItem('token'),
    };
  },
  components:{
    panel,

  },
  methods:{

    // get data
    getData(page = 1){
      axios.post("/api/admin/user?page="+page, {action: 'getData'}).then(response =>{

        console.log(response)
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
          let resp = JSON.parse( JSON.stringify(response.data));
          this.response.data = resp
          this.tbody = response.data;
          // this.convertData(resp)
        }
      })
    },
    getHelpInfo(){
      axios.post("/api/admin/user", {action: "getHelpInfo"}).then(response => {
        console.log(response);
        this.response.groups = response.data.groups;
        this.response.store_type = response.data.store_type;
      });
    },


    //send data for add or update user
    sendActionUser(id){
      let data = this.user;
      let action = this.action_func;
      action == "delete" ? data = {id: id} : '';
      data.action = action;

      axios.post('/api/admin/user', data).then(response=>{

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
          this.responseHandel(response, action);
        }
      })
    },

    // send data for add or update in Store_info
    sendActionStore(method, info, index){
      let data = info;
      data.action = method;
      axios.post('/api/admin/store_info', data).then(response=>{

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
        this.respStoreHandel(response,info , index);
      }
      })
    },

// ******** User Functions ***********

    // handel data came from DataBase to show in table DOM
    responseHandel(response, action){
      let status_resp = response.data.status;

      // if have errore
      if(status_resp == "error" && action != 'delete'){
        console.log('error in form')
        let store_info = this.errors.store_info
        Object.keys(response.data.errors).filter(k=> k.startsWith('store_info')).forEach(elem => {
          let index = elem.split('.')
          this.errors.store_info[index[1]][index[2]] = index[2] + " is invalide";
        })
        this.errors = response.data.errors;
        this.errors.store_info = store_info;


      // if saccess
      } else if(status_resp == "done" && action != 'delete'){
        this.getData();
        this.model_dom.hide();
        this.empty_data();
        Toast.fire({
          icon: 'success',
          title: 'Success '+ action +' User'
        })

       // on success delete
      }else if( action == 'delete' && status_resp == "done"){
        this.getData();
        Swal.fire({
          icon: 'success',
          title: 'User has been deleted.',
          showConfirmButton: false,
          timer: 1000
        });

      // on error delete
      }else if( action == 'delete' && status_resp == "error"){
        Swal.fire({
          icon: 'error',
          title: "Can't delete this User  :(",
          showConfirmButton: false,
          timer: 1000
        });

      }
    },


    // updatae status user
    editeStatus(elem, index){
      let data = { id: elem.id, status: elem.status == 1 ? 0 : 1, action: "updateStatus"}
      axios.post("/api/admin/user", data).then(resp=>{
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

    // conver data come white DataBas to show in table user
    convertData(resp){
      let my = [];
      let i =0;

      resp.data.forEach(user =>{
        user.group = user.group.name;
        user.mobile = '0' + user.mobile;

        // for store info
        user.storeName = [];
        user.storeType = [];
        for(let elem in user.store_info){
          user.storeName.push(user.store_info[elem].name);
          user.storeType.push(this.search_id(user.store_info[elem].type_id, this.response.store_type ).name)
        }
        user.storeName = user.storeName.join("\r\n");
        user.storeType = user.storeType.join("\r\n");

        //for put just in {tkey}
         my[i] = {};
        this.tkey.forEach(elem =>{
          my[i][elem] = user[elem]
        });
        i++;

      });

      let dom = resp
      dom.data = my;
      this.tbody = resp;
    },

    // change sum element in add
    addData(){
      this.inp_disable = false;
      this.modal.title = "Add User";
      this.modal.btn = "Add";

      this.model_dom.show();
      this.action_func = "add";

    },

    // change sum element on edit, on click in 3dot
    editeData(e){

      this.user = this.search_id(e.id, this.response.data.data) // get the data from response register and put it in Modal

      this.inp_disable = true;          // modifie element Modal in DOM
      this.modal.title = "Edit User";
      this.modal.btn = "Update";

      this.model_dom.show();
      this.action_func = "update";

    },

    // show message whene delete, on click 3dot
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
          this.sendActionUser(elem.id);
        }
      })
    },
    search_id(id_search, from_search){
      for(let elem of from_search){           // loop in response and get data of element with id
        if(id_search == elem.id){return elem; };
      };
    },

// ********** Store Info **********

    respStoreHandel(resp, target, index){
      this.errors.store_info[index] = {}; // empty old errors

      if(resp.data.status == "done"){
        target.not_disabled = false;
        target.edite = false;
        Toast.fire({
          icon: 'success',
          title: 'Save successfully'
        });

      }else if(resp.data.status == "error"){
        for(let elem in resp.data.errors){
          this.errors.store_info[index][elem] = resp.data.errors[elem];
        }
      }else if(resp.data.status == "deleted"){
        this.user.store_info.splice(index, 1);

        Swal.fire({
            icon: 'success',
            title: 'User has been deleted.',
            showConfirmButton: false,
            timer: 1000
          });
      }
    },
    // add store to user
    addStore(){
      this.user.store_info.push({not_disabled: true, edite: true,});
      this.errors.store_info.push({})

    },

    // edite store to user
    edite_store(e, index){
      if(e.edite == true){
        if(this.action_func == "add"){
          e.not_disabled = false;
          e.edite = false;
        }else if(this.action_func == "update"){

          // if update store in user
          if(e.id != undefined && e.user_id == this.user.id){

            this.sendActionStore('update_store', e, index)

          // if add store to user
          }else if(e.id === undefined){

            e.user_id = this.user.id
            this.sendActionStore('add_store', e, index);
          }
        }
      }else{
        e.not_disabled = true;
        e.edite = true;
      }
    },

    // delete store from user
    delete_store(e, index){

      // if not in database
      if(e.id == undefined && e.edite == true){
        this.user.store_info.splice(index, 1)

      }else{
        Swal.fire({
          title: 'Are you sure to delete?',
          text: "Delete This Address",
          icon: 'warning',
          reverseButtons: true,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'

        }).then((result) => {
          // if it is in database
          if (result.isConfirmed && e.id != undefined) {
            this.sendActionStore("delete_store", e, index)

          }else if(result.isConfirmed && e.edite == false){
            this.user.store_info.splice(index, 1)
          }
        })


      }
    },


// ****** Othe Function ********

    //empty modal from data
    empty_data(){
      // this.user = '';
      this.user = JSON.parse(this.old_user);
      this.errors = JSON.parse(this.old_errors);
      this.edite_pass = false;
    },

    //============================
    // function to send witch element update
    user_update(method, element){
      if(method == "info_store"){
        element

      }else if(element == "info_user"){

      }
    },

    // data stor user
    user_store(data){
      let user_info = {},
        id = '',
        i = 0;

      data.forEach(info => {
        for(let elem in info){
          if(elem == 'id'){
            id = info[elem];
            user_info[id] == undefined ? user_info[id] = {} : '';

          }else{
            user_info[id][i] = user_info[id][i] || {};
            user_info[id][i][elem] = info[elem];
          }
        }
        i++;
      });

      return user_info;
    },
    dblclick_row(elem){
      this.editeData(elem);
    }
  },
  mounted: function (){
    this.old_user = JSON.stringify(this.user);
    this.old_errors = JSON.stringify(this.errors);

    this.getHelpInfo();
    this.getData();

    this.model_dom = new bootstrap.Modal(document.getElementById('modal_user'), {});
  },
  watch: {
    'user.mobile': function(e) {
      let mob = e.toString();
      mob.length > 9 ? this.user.mobile = mob.slice(0, 9) : '';

    }
  },
};
</script>

