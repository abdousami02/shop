<template>
  <div class="order">

        <panel-template v-if="!show_details"
                    :title="title" :th="thead" :tb="tbody"
                    :getData_forPag="getData"
                    :addData_func="addData"
                    :editData_func="editeData"
                    :deleteData_func="deleteData"
                    :deleteMultiData_func="nothing" >

          <template v-slot="slotProps">
            <td class="id">{{ slotProps.row.id }}</td>
            <td class="date">{{ convert_date(slotProps.row.created_at)}}<span :class="['new-show',slotProps.row.show_saller > 0?'':'active' ]"></span></td>

            <td class="status">
              <span v-if="!slotProps.row.edite_status" class="status-show" :data-status="slotProps.row.status">{{ order_status[slotProps.row.status] }}</span>
            </td>

            <td class="weight">{{ slotProps.row.weight }} Kg</td>
            <td class="num-product">{{ slotProps.row.num_product }}</td>
            <td class="amount"><span>{{ setNumber(slotProps.row.amount_buy) }} DA</span></td>
          </template>

          <template  v-slot:btns_opt="slotProps">
            <a class="dropdown-item" @click="printOrder(slotProps.row)"><i class="fas fa-print"></i> Print</a>
            <!-- <a class="dropdown-item" @click="editeData(slotProps.row)"><i class="far fa-pen c"></i> Edit</a>
            <a class="dropdown-item" @click="calcOrder(slotProps.row, slotProps.index)"><i class="far fa-calculator"></i> Calc</a> -->
            <!-- <a class="dropdown-item" @click="deleteOrder(slotProps.row.id, slotProps.index)"><i class="far fa-trash"></i> Delete</a> -->
          </template>

        </panel-template>

        <order-details v-if="show_details" :backToOrder="hidDetails" :order_id="order_id_edite"/>


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

    <audio id='new_notify' muted src="/img/notify.mp3" preload="auto"></audio>

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
      thead: ["ID", "date", "Status", "Poide", "Num Product", "Amount"],
      tbody:{
        data:{},
      },
      temp_send: true,

      inp_disable: false,
      modal: {},
      errors: {0:{}},
      response: {},
      show_details: false,

      order: {},
      order_status:{0: 'Draft', 1: 'admin processing', 2: 'saller processing',
                    3: 'finish saller updated', 4: 'finish', 5: 'finish',
                    6: 'finish', 7: 'finish',
                    9: 'Cancceled'},
      order_id_edite: '',
      time_get: '',
    };
  },
  methods: {

    getData(page=1){
      let action = 'getData';
      axios.post("/api/saller/order?page="+page, {action: action}).then(response =>{

        console.log(response.data);

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
          let date = new Date();
          this.time_get = date.toLocaleString("sv-SE");
          this.tbody = response.data;
        }
      });
    },

    getNew(){
      axios.post("/api/saller/order", {action: "getNew",last: this.time_get}).then(resp=>{
        if(resp.data.status == 'done'){
          resp.data.data.forEach(elem=>{
            this.tbody.data.unshift(elem);
            let date = new Date(elem.updated_at);
            this.time_get = date.toLocaleString("sv-SE");
          })
          var audio = new Audio('/img/notify.mp3'); // path to file
          audio.play();
        }
      })
    },

    sendAction(order_data={}){
      if(!this.temp_send){ return false }
      this.temp_send = false;

      let data = this.order;
      order_data.id ? data = order_data : '';
      let action = this.action_func;
      data.action = action;
      console.log(data);

      axios.post('/api/saller/order', data).then(response => {
        this.temp_send = true;

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
          console.log(response.data);
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
          title: 'Success '+ action +' Product :)'
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
    addData(){
      this.modal.title = "Add Order";
      this.modal.btn = "Add";

      this.model_order.show();
      this.action_func = "add";

    },
    deleteData(){
    },
    editeData(elem){
      this.inp_disable = true;
      this.modal.title = "Edite Order";
      this.modal.btn = "update";

      this.model_order.show();
      this.action_func = "update";
      this.order = elem;
      // console.log(elem)
    },

    showOrderDetail(elem){
      this.order_id_edite = elem.id;
      this.show_details = true;
      window.scrollTo(0, 0);

    },

    // for Order Details
    hidDetails(){
      this.order_id_edite = '';
      this.getData();
      this.show_details= false;
      window.scrollTo(0, 0);
    },

    // change order saller
    change_saller(index){
      this.tbody.data[index].saller = false;
      this.action_func = 'update';
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
      axios.post("/api/saller/order", {action: "calc", order_id: elem.id}).then(resp =>{
        console.log(resp.data);

        if(resp.data.status == 'done'){
          this.tbody.data[index] = resp.data.data[0];
        }
      })
    },

    deleteOrder(id, index){
      Swal.fire({
        title: 'Are you sure to Delete Order!',
        icon: 'error',
        reverseButtons: true,
        showCancelButton: true,

      }).then((result) => {
        if (result.isConfirmed) {
          if(!this.temp_send){ return false }
          this.temp_send = false;

          axios.post("/api/saller/order", {action: "delete", id: id}).then(resp=>{
            this.temp_send = true;

            console.log(resp.data);
            if(resp.data.status == 'done'){
              this.response.order.splice(index,1)

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

    printOrder(elem){
      this.$root.printOrder(elem);

    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },

    after(){
      if(this.$root.login){
        this.getData();

      }else{
        this.$router.push({name: "Login"});
      }
      // this.getHelpInfo();
    }
  },
  mounted: function(){
    if(this.$root.render == true) {this.after(); }

    this.model_order = new bootstrap.Modal(document.getElementById('modal_order'), {});

    setInterval(this.getNew, 5000);

  },
  watch: {
    'order.user_id': function (){
      this.order.user_id ? this.select_store() : '';
    },
    '$root.render': function(){this.after(); },    // on response for login,
  }
};
</script>
