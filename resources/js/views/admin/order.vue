<template>
  <div class="order">

    <div class="template">
        <panel-template class="pan"  v-if="!show_details"
                    :title="title" :th="thead" :tb="tbody"
                    :getData_forPag="getData"
                    :addData_func="addData"
                    :editData_func="editeData"
                    :deleteData_func="deleteData"
                    :deleteMultiData_func="nothing" >

            <!-- link top -->
          <template v-slot:link_top>
            <li class="link"><router-link to="?status=0">Draft <span class="count">({{response.order_draft}})</span></router-link> |</li>
            <li class="link"><router-link to="?status=9">Canccel <span class="count">({{response.order_canccel}})</span></router-link></li>
          </template>

          <template v-slot="slotProps">
            <td class="id">{{ slotProps.row.id }}</td>
            <td class="date">{{ convert_date(slotProps.row.created_at)}}<span :class="['new-show',slotProps.row.show_admin > 0?'':'active' ]"></span></td>
            <td class="user info-order" v-if="slotProps.row">
              <b>User :</b>
              <p class="info-elem" v-if="slotProps.row.user">
                <span class="name"> Name: <i>{{ slotProps.row.user.name }}, </i></span>
                <span> Mobile: <i>{{ '0'+slotProps.row.user.mobile }}</i></span>
              </p>
              <b>Store :</b>
              <p class="info-elem" v-if="slotProps.row.store_info">
                <span class="name">Name: <i>{{ slotProps.row.store_info.name }}, </i></span>
                <span class="name"> Address: <i>{{ slotProps.row.store_info.address }}, </i></span>
                <!-- <span> Store Type: <i>{{ slotProps.row.store_info.store_type.name }}</i></span> -->
              </p>
            </td>

            <td class="saller info-order">
              <b>Saller :</b>
              <p class="info-elem" v-if="slotProps.row.saller">
                <span class="name"> Name: <i>{{ slotProps.row.saller.name }}, </i></span><span> Mobile: <i>{{ '0'+slotProps.row.saller.user.mobile }}</i></span><br>
                <span>Address: <i>{{ slotProps.row.saller.address }}</i></span>
              </p>
              <div class="inp-form" v-if="slotProps.row.saller == false">
                <select name="saller" :class="['form-select from-select-sm', errors.saller? 'is-invalid':'']" v-model="slotProps.row.saller_id">
                  <option v-for="elem in response.sallers" :key="elem" :value="elem.id">{{elem.name+ ' -  '+elem.address }}</option>
                </select>
                <button class="btn btn-outline-success ms-2" @click="change_saller(slotProps.row)"><i class="far fa-save m-1"></i></button>
              </div>
              <button class="btn btn-primary edite-order" @click="edite_saller(slotProps.index)"><i class="far fa-pen"></i></button>
            </td>

            <td class="status">
              <span v-if="!slotProps.row.edite_status" class="status-show" :data-status="slotProps.row.status">{{ order_status[slotProps.row.status] }}</span>

              <div class="inp-form" v-if="slotProps.row.edite_status == true">
                <select name="saller" :class="['form-select from-select-sm', errors.status? 'is-invalid':'']" v-model="slotProps.row.status">
                  <option v-for="(elem, index) in order_status" :key="index" :value="index">{{ elem }}</option>
                </select>
                <button class="btn btn-outline-success ms-2" @click="sendAction(slotProps.row)"><i class="far fa-save m-1"></i></button>
              </div>
              <button class="btn btn-primary edite-order" v-if="!slotProps.row.edite_status" @click="change_status(slotProps.index)"><i class="far fa-pen"></i></button>
            </td>

            <td class="num-product">{{ slotProps.row.num_product }}</td>
            <td class="weight">{{ slotProps.row.weight }} Kg</td>
            <td class="amount"><span>{{ setNumber(slotProps.row.amount) }} DA</span></td>
          </template>

          <template v-slot:btns_opt="slotProps">
            <a class="dropdown-item"  @click="editeData(slotProps.row)"><i class="far fa-pen c"></i> Edit</a>
            <a class="dropdown-item"  @click="makeCopy(slotProps.row)"><i class="far fa-copy"></i> Make Copy</a>
            <a class="dropdown-item"  @click="calcOrder(slotProps.row, slotProps.index)"><i class="far fa-calculator"></i> Calc</a>
            <a class="dropdown-item" @click="print_order(slotProps.row)"><i class="fas fa-print"></i> Print</a>
            <a class="dropdown-item" @click="deleteOrder(slotProps.row.id, slotProps.index)"><i class="far fa-trash"></i> Delete</a>
          </template>

        </panel-template>

        <order-details class="pan" :backToOrder="hid_details" :order_id="order_id_edite" v-if="show_details"/>

    </div>

    <!-- Print Ordet -->
    <print-order id="print_order" class="d-none">

    </print-order>


      <!-- Model for Order-->
    <div class="modal fade " id="modal_order" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
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
                  <span class="name">Order ID</span>
                  <div class="inp-form">
                    <input :class="['form-control',errors.id?'is-invalid':'']" type="text" name="id" disabled v-model="order.id" />
                  </div>
                </div>

                  <!-- User -->
                  <div class="user" v-if="!inp_disable">
                    <span>User</span>
                    <div class="inp-form">
                      <select name="User" :class="['form-select from-select-sm', errors.user_id? 'is-invalid':'']" v-model="order.user_id">
                        <option v-for="elem in response.users" :key="elem" :value="elem.id">{{elem.name+ ' -  0'+elem.mobile }}</option>
                      </select>
                      <span class="invalid-feedback" v-text="errors.user_id?errors.user_id[0]:''"></span>
                    </div>
                  </div>

                  <!-- Store -->
                  <div class="store">
                    <span>Store</span>
                    <div class="inp-form">
                      <select name="User" :class="['form-select from-select-sm', errors.store_id? 'is-invalid':'']" v-model="order.store_id">
                        <option v-for="elem in store_user" :key="elem" :value="elem.id">{{elem.name+ ' -  '+elem.address }}</option>
                      </select>
                      <span class="invalid-feedback" v-text="errors.store_id?errors.store_id[0]:''"></span>
                    </div>
                  </div>

                  <!-- Saller -->
                  <div class="saller">
                    <span>Saller</span>
                    <div class="inp-form">
                      <select name="User" :class="['form-select from-select-sm', errors.saller? 'is-invalid':'']" v-model="order.saller_id">
                        <option v-for="elem in response.sallers" :key="elem" :value="elem.id">{{elem.name+ ' -  '+elem.address }}</option>
                      </select>
                      <span class="invalid-feedback" v-text="errors.saller_id?errors.saller_id[0]:''"></span>
                    </div>
                  </div>

                  <!-- Status -->
                  <div class="status">
                  <span class="name">Status</span>
                  <div class="inp-form select-form">
                    <select name="status" :class="['form-select from-select-sm', errors.status? 'is-invalid':'']" v-model="order.status" >
                      <option v-for="(elem, index) in order_status" :key="index" :value="index">{{ elem }}</option>
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
import OrderDetails from "./orderDetails.vue";

export default {
  name: "OrderDash",
  components: {
    PanelTemplate,
    OrderDetails,
  },
  data: function () {
    return {
      title: "Orders",
      thead: ["ID", "date", "User", "to Saller", "Status", "Num Product", "Poide", "Amount"],
      tbody:{
        data:{},
      },
      inp_disable: false,
      modal: {},
      errors: {0:{}},
      response: {},
      show_details: false,

      order: {},
      order_status:{0: 'Draft', 1: 'admin processing', 2: 'saller processing',
                    3: 'finish saller updated', 4: 'Attemp user approve', 5: 'Prepare to delevery',
                    6:'delevered and not payment', 7: 'delevered and payment',
                    9: 'Cancceled'},
      order_id_edite: '',

      time_get: '',
    };
  },
  methods: {

    getHelpInfo(){
      axios.post("/api/admin/order", {action: "getHelpInfo"}).then(response => {
        this.response.users = response.data.users;
        this.response.sallers = response.data.sallers;
      });
    },

    getData(page=1){
      let action = 'getData';
      let status = this.$route.query.status;
      let query = status ? "&status="+status : null;
      console.log(query)
      axios.post("/api/admin/order?page="+page+query, {action: action}).then(response =>{

        console.log(response);
        let resp = response.data;

        // if don't have permition
        if(resp.status == "permition"){
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "Don't have Permition!",
            // footer: '<a href="">Why do I have this issue?</a>'
          })

        // if not
        }else{
          this.tbody = resp.data;
          let date = new Date();
          this.time_get = date.toLocaleString("sv-SE");
          this.response.order_draft = resp.info.draft;
          this.response.order_canccel = resp.info.canccel;
        }
      });
    },

    sendAction(order_data={}){
      let data = this.order;
      order_data.id ? data = order_data : '';
      let action = this.action_func;
      data.action = action;
      console.log(data);
      axios.post('/api/admin/order', data).then(response => {

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
          console.log(response);
          this.responseHandel(response, action);
        }
      })
    },
    responseHandel(response, action){
      let status_resp = response.data.status;

      // if have errore
      if(status_resp == "error" && action != 'delete'){
        console.log('error in form')
        this.errors = response.data.errors;

      // if saccess
      } else if(status_resp == "done" && action != 'delete'){
        // this.getData(this.tbody.current_page);
        if(action == 'update'){
          console.log('in update')
          let id = response.data.data[0]['id'];
          let elem = this.search_id(id, this.tbody.data);
          this.tbody.data[elem.index] = response.data.data[0];

        }else{
          this.tbody.data.unshift(response.data.data[0]);
        }
        this.model_order.hide();

        this.empty_data();
        Toast.fire({
          icon: 'success',
          title: 'Success '+ action +' Order :)'
        })

       // on success delete
      }else if( action == 'delete' && status_resp == "done"){
        this.getData(this.tbody.current_page);
        Swal.fire({
          icon: 'success',
          title: 'Product has been deleted.',
          showConfirmButton: false,
          timer: 1000
        });

      // on error delete
      }else if( action == 'delete' && status_resp == "error"){
        Swal.fire({
          icon: 'error',
          title: "Can't delete this Product :(",
          showConfirmButton: false,
          timer: 1000
        });

      }
    },

    getNew(){
      axios.post("/api/admin/order", {action: "getNew",last: this.time_get}).then(resp=>{
        if(resp.data.status == 'done'){
          resp.data.data.forEach(elem=>{
            let date = new Date(elem.updated_at);
            this.time_get = date.toLocaleString("sv-SE");
            this.tbody.data.unshift(elem);
          })
          var audio = new Audio('/img/notify.mp3'); // path to file
          audio.play();
        }
      })
    },

    addData(){
      this.modal.title = "Add Order";
      this.modal.btn = "Add";

      this.model_order.show();
      this.action_func = "add";

    },
    deleteData(){

    },
    change_saller(elem){
      let data = {action: "updateSaller", id: elem.id, saller_id: elem.saller_id, user_id: elem.user_id};
      axios.post("/api/admin/order", data).then(resp=>{
        console.log(resp);
        if(resp.data.status == 'done'){
          let id = resp.data.data[0]['id'];
          let elem = this.search_id(id, this.tbody.data);
          this.tbody.data[elem.index] = resp.data.data[0];

          Toast.fire({
            icon: 'success',
            title: 'Success Update Order Saller :)'
          })
        }
      })
    },

    editeData(elem){
      this.inp_disable = true;
      this.modal.title = "Edite Order";
      this.modal.btn = "update";

      this.model_order.show();
      this.action_func = "update";
      this.order = elem;
      console.log(elem)
    },

    showOrderDetail(elem){
      console.log(elem);
      this.show_details = true;
      this.order_id_edite = elem.id;
      window.scrollTo(0, 0);

    },

    // for Order Details
    hid_details(){
      this.order_id_edite = '';
      this.getData();
      this.show_details= false;
      window.scrollTo(0, 0);
    },

    // change order saller
    edite_saller(index){
      this.tbody.data[index].saller = false;
      this.action_func = 'update';
    },

    getStatus($data){
      console.log('status');
      this.$router.push({path: '/dashboard/order?'+$data});
    },

    // change order status
    change_status(index){
      this.tbody.data[index].edite_status = true;
      this.action_func = 'update';
    },
    select_store(){
      let user_select = this.search_id(this.order.user_id, this.response.users)
      this.store_user = user_select.data.store_info
    },
    search_id(id_search, from_search){
      for(let elem in from_search){           // loop in response and get data of element with id
        if(id_search == from_search[elem]['id']){return {index: elem, data: from_search[elem]}; };
      };
    },
    empty_data(){
      this.order = {};
    },
    convert_date(date){
      const d = new Date(date);
      return d.toLocaleString("es-CL");
    },
    click_row(id, event){
      this.selected = id;
    },
    dblclick_row(elem){
      this.showOrderDetail(elem);
    },

    calcOrder(elem, index){
      console.log(index)
      console.log(elem)
      axios.post("/api/admin/order", {action: "calc", order_id: elem.id}).then(resp =>{
        console.log(resp);

        if(resp.data.status == 'done'){
          this.tbody.data[index] = resp.data.data[0];
          Toast.fire({
            icon: 'success',
            title: 'Success Calc Order :)'
          })

        }else{
          Swal.fire({
            title: 'Have Error',
            icon: 'error',
            text: resp.data.message,
          });
        }
      })
    },

    deleteOrder(id, index){
      Swal.fire({
        title: 'Are you sure to Delete Order!',
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,

      }).then((result) => {
        if (result.isConfirmed) {
          axios.post("/api/admin/order", {action: "delete", id: id}).then(resp=>{
            console.log(resp);
            if(resp.data.status == 'done'){
              this.tbody.data.splice(index,1);
              Toast.fire({
                icon: 'success',
                title: 'Success Delete Order :)'
              })

            }else{
              Swal.fire({
                icon: 'error',
                title: 'Have Error',
                showConfirmButton: false,
                timer: 1000
              });
            }
          })

        }
      })
    },

    print_order(elem){
      this.$root.printOrder(elem.id);

    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },
  },
  mounted: function(){
    this.getData();
    this.getHelpInfo();
    this.model_order = new bootstrap.Modal(document.getElementById('modal_order'), {});

    setInterval(this.getNew, 5000);

  },
  watch: {
    'order.user_id': function (){
      this.order.user_id ? this.select_store() : '';
    },
    change_sell(sall){

    }
  }
};
</script>
