<template>
  <div class="order-details">
    <panel-template
                    :title="title" :th="thead" :tb="tbody"
                    :getData_forPag="getData"
                    :addData_func="addData"
                    :editData_func="editeData"
                    :deleteData_func="deleteData"
                    :deleteMultiData_func="''" >

      <template #btns>
        <button class="btn btn-primary me-5 ms-2 mb-3 w-50" @click="backToOrder(); empty_tbody()"><i class="fas fa-long-arrow-left"></i></button>
        <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="fal fa-print"></i> Print
        </button>
        <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="#" @click="$root.printOrder(order_id, 'a5')">A5</a></li>
          <li><a class="dropdown-item" href="#" @click="$root.printOrder(order_id, 'a4')">A4</a></li>
          <li><a class="dropdown-item" href="#" @click="$root.printOrder(order_id, 'mobile')">Mobile</a></li>
        </ul>
      </template>

      <template #header>
        <ul class="info-order header-order-detail">
          <li class="shop">
            <b>Store: </b><br>
            <div v-if="order_info.store_info">
              <span class="name">Name: <i>{{order_info.store_info.name}}</i></span><br>
              <span class="name">Address: <i>{{order_info.store_info.address}}</i></span>
            </div>
          </li>
          <li class="saller">
            <b>Saller: </b><br>
            <div v-if="order_info.saller">
              <span class="name">Name: <i>{{order_info.saller.name}}</i></span><br>
              <span class="name">Address: <i>{{order_info.saller.address}}</i></span>
              <span class="name">Mobile: <i>{{'0'+order_info.saller.user.mobile}}</i></span>
            </div>
          </li>
          <li class="status">
            <b>Status: </b><br>
            {{order_status[order_info.status]}}
          </li>
          <li class="amount">
            <b>Total: </b>{{ setNumber(order_info.amount)}} DA
          </li>
        </ul>
      </template>

      <template v-slot="slotProps" v-if="response.finish">

        <td class="image"><img :src="'/'+slotProps.row.product.image" alt=""  v-if="setting.image"></td>

        <td class="product-name info-order">
          <p><span class="name"  v-if="setting.id"><i>{{ slotProps.row.product.id}}</i></span><span class="name-lg">Name: <i>{{slotProps.row.product.name}}</i></span></p>
          <div v-if="setting.categorie">
            <span class="name">{{ response.categories[slotProps.row.product.categorie_id].name }}</span> <span class="name">{{ response.familles[slotProps.row.product.famille_id].name }}</span>
          </div>
        </td>

        <td class="price info-order">
          <b>Price: </b><input type="number" class="inp-price" :value="slotProps.row.price_sell">
          <div v-if="setting.all_price">
            <p><span class="name">Price 1: <i>{{ setNumber(slotProps.row.product.price_sell1) }}</i></span> <span></span></p>
            <p v-if="slotProps.row.product.price_sell2"><span class="name">Price 2:<i>{{ setNumber(slotProps.row.product.price_sell2) }}</i></span> <span>qte : <i>{{ slotProps.row.product.qte_sell2 }}</i></span></p>
            <p v-if="slotProps.row.product.price_sell3"><span class="name">Price 3:<i>{{ setNumber(slotProps.row.product.price_sell3) }}</i></span> <span>qte : <i>{{ slotProps.row.product.qte_sell3 }}</i></span></p>
          </div>
        </td>

        <td class="qte">
          <input type="number" class="inp-qte" :value="slotProps.row.qte">
          <span v-if="slotProps.row.order_detail_saller && slotProps.row.qte != slotProps.row.order_detail_saller.qte" class="qte-saller">{{slotProps.row.order_detail_saller.qte}}</span>
        </td>

        <td class="goute info-order">
          <span v-if="slotProps.row.order_detail_goute.length == 0">None</span>
          <ul>
            <li v-for="elem in slotProps.row.order_detail_goute" :key="elem">
              <span class="name"> <i>{{ elem.product_goute.goute }}</i></span> <span>{{elem.qte}}</span>,
            </li>
          </ul>
        </td>

        <td class="instock">
          <span @click="edite_stock(slotProps.row, slotProps.index)"
                :class="['status-btn', slotProps.row.in_stock == 1 ? 'active':'',
                          slotProps.row.order_detail_saller && slotProps.row.in_stock != slotProps.row.order_detail_saller.in_stock && slotProps.row.in_stock == 1 ? 'not' :'' ]" ></span><br>
          <span v-if="slotProps.row.order_detail_saller && slotProps.row.in_stock != slotProps.row.order_detail_saller.in_stock && slotProps.row.in_stock == 1 " class="text-danger">Not in Stock</span>

        </td>

        <td class="discount">
          <span v-if="!slotProps.row.discount">None</span>
        </td>

        <td class="price-total">{{ setNumber(slotProps.row.price_total) }} DA</td>
        <!-- <td class="status"><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td> -->
      </template>

      <template #footer>
        <div class="amount-detail" v-if="order_info.amount">
          <button class="btn btn-primary" @click="closeOrder"><i class="fas fa-lock"></i> Valide & Close</button>
          <span class="value">{{ setNumber(order_info.amount) }} DA</span>
        </div>
      </template>

    </panel-template>


      <!-- Model for Order Details -->
    <div class="modal fade " id="modal_order_details" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">{{ modal.title }}</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="">

              <div class="row mt-3" v-if="action_func == 'add'">
                <div class="col-6">
                  <!-- categorie Product -->
                  <div class="inp-form">
                    <span>categorie</span>
                    <select name="categorie" class="form-select from-select-sm" v-model="search_prod.categorie_id">
                      <option value="">Select Categorie</option>
                      <option v-for="elem in response.categories" :key="elem" :value="elem.id">{{elem.name}}</option>
                    </select>
                  </div>
                </div>
                <!-- <div class="col-2"></div> -->
                <div class="col-6">
                  <!-- famille product -->
                  <div class="inp-form">
                    <span>Famille</span>
                    <select name="famille" class="form-select from-select-sm" v-model="search_prod.famille_id">
                      <option value="">Select Famille</option>
                      <option v-for="elem in famille_cat" :key="elem" :value="elem.id">{{elem.name}}</option>
                    </select>
                  </div>
                </div>
              </div>

               <!-- search -->
              <div class="row mt-3 mb-4" v-if="action_func == 'add'">
                <div class="col-12 search-prod">
                  <input type="search" class="form-control" placeholder="Search..." ref="search" v-model="search_prod.str">
                  <ul class="resulte">
                    <li v-for="elem in search_prod.resulte" :key="elem" @click="set_prod(elem)">
                      <div class="image"><img :src="'/'+elem.image" alt=""></div>
                      <div class="id">{{elem.id}}</div>
                      <div class="name">{{elem.name}}</div>
                      <div class="price">{{elem.price_sell1}}</div>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="row">
                <div class="col-3">
                  <span>id:</span>
                  <input type="number" class="form-control" disabled :value="show_product.id">
                </div>
                <div class="col-9">
                  <span>Name</span>
                  <input type="text" class="form-control" disabled :value="show_product.name">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-4">
                  <span>Price: </span>
                  <input type="number" :class="['form-control', errors.price_sell? 'is-invalid':'']" v-model="order_product.price_sell" >
                </div>
                <div class="col-2 qte">
                  <span>Qte:</span>
                  <input type="number" :class="['form-control', errors.qte? 'invalid':'']" v-model="order_product.qte">
                </div>
                <div class="col-6 info-order">
                  <p><span class="name">Qte U/c: <i>{{show_product.qte_uc}}</i></span></p>
                  <p><span class="name">Price 1: <i v-text="show_product.price_sell1"></i></span></p>
                  <p v-if="show_product.price_sell2"><span class="name">Price 2: <i v-text="show_product.price_sell2"></i></span> Qte: <i v-text="show_product.qte_sell2"></i></p>
                  <p v-if="show_product.price_sell3"><span class="name">Price 3: <i v-text="show_product.price_sell3"></i></span> Qte: <i v-text="show_product.qte_sell3"></i></p>
                </div>
              </div>

              <div class="row mt-3" v-if="show_product">

                <div class="col-4">
                  <span>Goute: </span>
                  <select class="form-select" v-model="prod_goute.id_goute">
                    <option v-for="elem in show_product.product_goute" :value="elem.id" :key="elem" >{{elem.goute}}</option>
                  </select>
                </div>

                <div class="col-4">
                  <span>Qte: </span>
                  <div class="select-btn">
                    <input type="number" class="form-control" v-model="prod_goute.qte_goute" v-on:keyup.enter="add_goute">
                    <button class="btn btn-outline-primary ms-3" @click="add_goute">add</button>
                  </div>
                </div>

                <div class="col-4"></div>
                <div class="col-6">
                  <ul class="list-goute info-order" v-if="order_product.order_detail_goute.length > 0">
                    <li v-for="elem in order_product.order_detail_goute" :key="elem" :class="[elem.edite]">
                      <span class="name"><i>{{elem.product_goute.goute}}</i></span>
                      <div class="opt">
                        <span>Qte: <i>{{elem.qte}}</i></span>
                        <i class="far fa-trash-alt delete-icon" @click="delete_goute(elem)"></i>
                      </div>
                    </li>
                  </ul>
                </div>

                <div class="col-6">
                  <div class="price-product">
                    {{order_product.price_total}} DA
                  </div>
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
  name: "orderDetails",
  components: {
    PanelTemplate,
  },
  props: [
    'backToOrder',
    'order_id',
  ],
  data: function () {
    return {
      title: "Order Details",
      thead: ["Image", "Product", "Price", "Qte", "Goutes", "Stock Saller", "Discount", "Price Totale" ],
      tbody:{data:{},},

      modal: {},
      errors: {0:{}},
      response: {},
      categories: {},
      setting: {image: true, id: true, categorie: false, all_price: true},

      order_status: {0: 'Draft', 1: 'In Progress', 2: 'Prepare Commande', 3: 'finish delevery', 4: '', 5: 'Cancceled'},
      order_product: {order_detail_goute: []},
      order_info: {},
      show_product: {},
      dd: {},
      prod_goute: {},
      famille_cat: [],
      search_prod: {categorie_id: '', famille_id: ''},
      qte_goute: '',

      action_wait: 0,     // action for wait response

    };
  },
  methods: {

    getHelpInfo(){
      axios.post("/api/admin/order_detail", {action: "getHelpInfo"}).then(response => {
        console.log(response);
        this.response.familles = this.order_element(response.data.familles);
        this.response.categories = this.order_element(response.data.categories);
        this.response.finish = true;
      });
    },
    getSetting(){
      axios.post("/api/admin/setting", {action: "getSetting", page: 'order_detail'}).then(response =>{
        console.log(response)
        this.setting= Object.assign(this.setting, response.data);
      })
    },

    getData(page=1){
      let action = 'getData';
      axios.post("/api/admin/order_detail?page="+page, {action: action, order_id: this.order_id}).then(response =>{

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
        }
      });
    },

    getOrderInfo(){

      let data = {action: 'getData', id: this.order_id}
      axios.post("/api/admin/order", data).then(resp =>{
        this.order_info = resp.data.data[0];
      })
    },

    sendAction(elem=''){
      if(this.action_wait == 0){      // wait for finish first response
        this.action_wait = 1

        let action = this.action_func;
        let data = this.order_product;
        data.action = action;
        console.log(data)

        if(action != 'delete' && data.qte < data.qte_goute){
          this.errors.qte = true;this.action_wait = 0;  return false;

        }else if(action != 'delete' && data.price_sell <= data.product.price_buy){
          this.errors.price_sell = true; this.action_wait = 0;  return false;
        }

        if(action == "delete"){data = elem ; elem.action='delete';};

        axios.post("/api/admin/order_detail", data).then(response => {

          console.log(response);
          this.action_wait = 0        // can send new response

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
      }
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
          let id = response.data.data[0]['id'];
          let elem = this.search_id(id, this.tbody.data);
          this.tbody.data[elem.index] = response.data.data[0];

        }else{
          this.tbody.data.unshift(response.data.data[0]);
        }

        this.getOrderInfo();
        this.model_details.hide();
        this.empty_data();
        Toast.fire({
          icon: 'success',
          title: 'Success '+ action +' Product :)'
        })

       // on success delete
      }else if( action == 'delete' && status_resp == "done"){
        this.getData(this.tbody.current_page);
        this.getOrderInfo();
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
      this.modal.title = "Add Product";
      this.modal.btn = "Add";

      this.model_details.show();
      this.action_func = "add";
      setTimeout(e=>{$('.search-prod input')[0].focus();},500)

    },
    deleteData(elem){
      Swal.fire({
        title: 'Are you sure to delete?',
        html: "Delete Product : <span class='fs-3 text-primary'> " + elem.product.name + "</span>",
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

      }).then((result) => {
        if (result.isConfirmed) {
          this.action_func = "delete";
          elem.product = '';
          elem.order_detail_goute = '';
          this.sendAction(elem);
        }
      })

    },
    editeData(elem){
      console.log(elem);
      this.show_product = Object.assign({}, elem.product);
      // elem.product = '';
      this.order_product = Object.assign({}, elem)
      this.show_details = true;

      this.modal.title = "Edite Product";
      this.modal.btn = "update";

      this.model_details.show();
      this.action_func = "update";

    },

    add_goute(){
      let id_goute = this.prod_goute.id_goute,
        qte_goute = this.prod_goute.qte_goute;

      if(id_goute != null && qte_goute > 0){

        let goute = this.search_id(id_goute, this.show_product.product_goute, 'id');
        let data = {product_goute_id: id_goute, qte: qte_goute, product_goute: goute}
        let if_exists = this.search_id(id_goute, this.order_product.order_detail_goute, 'product_goute_id')

        if(if_exists){
          let gout = this.order_product.order_detail_goute[if_exists.index];
          gout.qte = data.qte;
          gout.edite = 'update';

        }else{
          this.order_product.order_detail_goute.push(data);
        }
      }
      this.prod_goute = {};
      this.count_goute();
    },

    delete_goute(elem){

      if(elem.edite == 'delete'){
        elem.edite = 'update';

      }else{
        elem.edite = 'delete';
      }
      this.count_goute();
    },

    count_goute(){
      let count = 0;
      this.order_product.order_detail_goute.forEach(elem =>{
        elem.edite != 'delete' ? count += Number(elem.qte) : '';
      });
      this.order_product.qte_goute = count;
      this.order_product.qte = count;
    },

    // search of product to add to order
    search_prod_order(str){
      let data = this.search_prod;
      data.action = "search";
      axios.post("/api/admin/order_detail", data).then(response=>{
        this.search_prod.resulte = response.data;
      })
    },

    closeOrder(){
      // location.reload(true);
      let data = {action: "close_order", order_id: this.order_id};
      axios.post("/api/admin/order", data).then(resp=> {
        console.log(resp);
        if(resp.data.status == 'done'){
          this.backToOrder();
        }
      })
    },

    // on click to product set is in modal
    set_prod(elem){
      let data = {action: "search", id: elem.id}
      axios.post("/api/admin/order_detail", data).then(response=> {
        console.log(response);
        this.show_product = response.data[0];

        this.order_product.product_id = this.show_product.id;
        this.order_product.product = this.show_product;
        this.order_product.price_sell = this.show_product.price_sell1;
        this.order_product.weight = this.show_product.weight
        this.order_product.order_id = this.order_id;

        this.search_prod.resulte = '';
      })
    },
    order_element(data){
      let index = {};
      data.forEach(elem => {
        index[elem.id] = elem;
      });
      return index;
    },
    select_famille(){
      console.log('show famille')
      this.show_product.categorie_id;
      this.famille_cat = [];
      let famille = this.response.familles;

      for(let elem in famille){
        if(famille[elem].categorie_id == this.search_prod.categorie_id){ this.famille_cat.push(famille[elem]); }
      }
    },

    edite_stock(elem, index){
      console.log(elem);
      let stock = elem.in_stock == 1 ? 0 : 1 ;
      let data = {id: elem.id, in_stock: stock, action: "updateStock"};
      axios.post("/api/admin/order_detail", data ).then(resp =>{
        console.log(resp);

        if(resp.data.status != 'error'){
          this.tbody.data[index].in_stock = resp.data.data;
          Toast.fire({
            icon: 'success',
            title: 'Success Update stock Product :)'
          })
        }
      })
    },

    calcPrice(){
      console.log(this.order_product.product)
      let method = this.order_product.product.method_price == 'unite' ? this.order_product.product.qte_uc : 1;
      this.order_product.price_total = (this.order_product.price_sell * this.order_product.qte * method) + ',00' ;
    },

    dblclick_row(row){
      this.editeData(row);
    },

    search_id(id_search, from_search, id='id'){
      for(let elem in from_search){           // loop in response and get data of element with id
        if(id_search == from_search[elem][id]){
          from_search[elem].index = elem;
          return from_search[elem];
        }
      };
      return null;
    },
    empty_data(){
      this.order_product = {order_detail_goute: []};
      this.show_product = {};
      this.errors = {};
      this.search_prod= {};
    },

    empty_tbody(){
      this.tbody = {data:{},};
      this.$parent.order_id = '';
      this.order_info = {};
    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },

    focus(){ $('.search-prod input')[0].focus() }
  },
  mounted: function(){
    // this.getData();
    this.getHelpInfo();

    if(this.order_id){
        this.getData();
        this.getOrderInfo();
        this.getSetting();
      }

    this.model_details = new bootstrap.Modal(document.getElementById('modal_order_details'), {});
  },
  watch: {
    "search_prod.categorie_id" : function (){
      this.select_famille();
    },
    "search_prod.str": function(str){

      str ? this.search_prod_order(str): '';
    },
    "order_product.price": function(num){ num ? this.calcPrice() : '';},
    "order_product.qte": function(num){ num ? this.calcPrice() : '';}
  }
}
</script>
