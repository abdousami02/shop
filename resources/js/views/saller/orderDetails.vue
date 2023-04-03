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
        <button class="btn btn-success" @click="printOrder"><i class="fal fa-print"></i> Print</button>
      </template>

      <template #header>
        <ul class="info-order header-order-detail">
          <li class="id"><b>ID: </b>{{order_info.id}}</li>
          <li class="status">
            <b>Status: </b><br>
            {{order_status[order_info.status]}}
          </li>
          <li class="num-product"><b>Product: </b>{{order_info.num_product}}</li>
          <li class="weight"><b>Weight: </b>{{order_info.weight}} Kg</li>
          <li class="amount">
            <b>Total: </b>{{ setNumber(order_info.amount_buy)}} DA
          </li>
        </ul>
        <div class="btns-update">
          <button class="btn btn-success me-2" @click="updatePrice"><i class="far fa-save"></i> Update Order</button>
          <button class="btn btn-primary" @click="changeAllPrice"><i class="far fa-money-check-edit-alt"></i> Edite All Price</button>
        </div>
      </template>

      <template v-slot="slotProps" >

        <td class="image"><img :src="'/'+slotProps.row.product.image" alt=""  v-if="setting.image"></td>

        <td class="product-name info-order">
          <p><span class="name"  v-if="setting.id"><i>{{ slotProps.row.product.id}}</i></span><span class="name-lg">Name: <i>{{slotProps.row.product.name}}</i></span></p>
          <div v-if="setting.categorie">
            <!-- <span class="name">{{ response.categories[slotProps.row.product.categorie_id].name }}</span> <span class="name">{{ response.familles[slotProps.row.product.famille_id].name }}</span> -->
          </div>
        </td>

        <td class="price info-order">
          <div v-if="setting.all_price">
            <p><span class="name">Price 1: <i>{{ setNumber(slotProps.row.product.price_sell1) }}</i></span> <span></span></p>
          </div>
        </td>

        <td class="price-sell">
          <b>Price: </b>
              <input type="number" @blur="setNumber(slotProps.row, 'set', 'price_buy')"
                :class="['form-control inp-price', slotProps.row.edite_price ? 'active' : '']"
                :disabled="slotProps.row.edite_price? false : true"
                v-model="slotProps.row.price_buy" >

           <a v-if="!slotProps.row.edite_price" class="btn btn-primary edite-price" @click="changeSinglePrice(slotProps.row, slotProps.index)"><i class="far fa-pen"></i></a>
           <a v-if="slotProps.row.edite_price" class="btn btn-outline-success edite-price " @click="changeSinglePrice(slotProps.row, slotProps.index)"><i class="far fa-save"></i></a>
        </td>

        <td class="goute info-order">
          <span v-if="slotProps.row.order_detail_goute.length == 0">None</span>
          <ul>
            <li v-for="elem in slotProps.row.order_detail_goute" :key="elem">
              <span class="name"> <i>{{ elem.product_goute.goute }}</i> {{elem.qte}}</span>
            </li>
          </ul>
        </td>

        <td class="qte">
          <span>{{slotProps.row.qte}}</span>
          <!-- <input type="number" class="form-control inp-qte active" :value="slotProps.row.qte"> -->
        </td>

        <td class="instock">
          <span @click="edite_stock(slotProps.row, slotProps.index)" :class="['status-btn', slotProps.row.in_stock == 1 ? 'active':'']" ></span>
        </td>

        <td class="price-total">{{ setNumber(slotProps.row.price_total) }} DA</td>
        <!-- <td class="status"><span class="status" :data-status="slotProps.row.status">{{ slotProps.row.status == 1 ? "active" : "inactiv" }}</span></td> -->
      </template>

      <template v-slot:btns_opt="slotProps">
         <a class="dropdown-item edit-elem editData" data-action="edit" @click="editeData(slotProps.row)"><i class="far fa-pen c"></i> Edit</a>
      </template>

      <template #footer>
        <div class="amount-detail" v-if="order_info.amount">
          <span class="value">{{ setNumber(order_info.amount_buy) }} DA</span>
        </div>
        <button class="btn btn-success me-2" @click="updatePrice"><i class="far fa-save"></i> Update Order</button>
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
                  <input type="text" class="form-control" placeholder="Search..." ref="search" v-model="search_prod.str">
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
                  <input type="number" :class="['form-control', errors.price_sell? 'is-invalid':'']" v-model="order_product.price_buy" >
                </div>
                <div class="col-2">
                  <span>Qte:</span>
                  <input type="number" :class="['form-control', errors.qte? 'is-invalid':'']" v-model="order_product.qte">
                </div>
                <div class="col-6 info-order">
                  <p><span class="name">Qte U/c: <i>{{show_product.qte_uc}}</i></span></p>
                  <p><span class="name">Price 1: <i v-text="show_product.price_sell1"></i></span></p>
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
                  <div class="price-product" v-if="order_product.qte">
                    {{calcPrice(order_product, 'total')}} DA
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
      thead: ["Image", "Product", "Price Sell", "Price", "Goutes", "Qte", "Stock", "Price Totale" ],
      tbody:{data:{},},
      temp_send: true,

      modal: {},
      errors: {0:{}},
      response: {},
      categories: {},
      setting: {image: true, id: true, categorie: false, all_price: true},

      order_status: this.$parent.order_status,
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
      axios.post("/api/saller/order_detail", {action: "getHelpInfo"}).then(response => {
        // // console.log(response);
        this.response.familles = this.order_element(response.data.familles);
        this.response.categories = this.order_element(response.data.categories);
        this.response.finish = true;
      });
    },

    getData(page=1){
      let action = 'getData';
      if(!this.order_id){
        return false;
      }
      axios.post("/api/saller/order_detail?page="+page, {action: action, order_id: this.order_id}).then(response =>{

        // console.log(response);
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
          this.tbody = {data: resp.data};
        }
      });
    },

    getOrderInfo(){
      let data = {action: 'getData', id: this.order_id}
      axios.post("/api/saller/order", data).then(response =>{
        // console.log(response.data)
        this.order_info = response.data;
      })
    },

    sendAction(){
      if(this.action_func == 'update'){
          this.updateProduct();
          return false;
        }

      if(!this.temp_send){ return false }
      this.temp_send = false;

      let action = this.action_func;
      let data = this.order_product;
      data.action = action;
      // console.log(data)

      if(action != 'delete' && data.qte < data.qte_goute){
        this.errors.qte = true;  return false;

      }else if(action != 'delete' && data.price_buy <= 0){
        this.errors.price_buy = true;  return false;
      }


      axios.post("/api/saller/order_detail", data).then(response => {
        this.temp_send = true;        // can send new response

        // console.log(response);

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

    responseHandel(response, action){
      let status_resp = response.data.status;

      // if have errore
      if(status_resp == "error"){
        // console.log('error in form')
        this.errors = response.data.errors;

      // if saccess
      }else if(status_resp == "done"){

        this.tbody.data.unshift(response.data.data[0]);

        this.getOrderInfo();
        this.model_details.hide();
        this.empty_data();
        Toast.fire({
          icon: 'success',
          title: 'Success '+ action +' Product :)'
        })
      }
    },

    updateProduct(){
      let elem = this.search_id(this.order_product.id, this.tbody.data);
      // console.log(elem);
      let product = this.tbody.data[elem.index];
      product.qte = this.order_product.qte;
      product.price_buy = this.order_product.price_buy;
      product.order_detail_goute = this.order_product.order_detail_goute;
      this.model_details.hide();
      this.empty_data();

    },

    updatePrice(){
      if(!this.temp_send){ return false }
      this.temp_send = false;

      let data = this.tbody.data;
      axios.post("/api/saller/order_detail", {action: "update", data: data}).then(resp=>{
        this.temp_send = true;

        // console.log(resp.data);
        $('.elem-row').removeClass('error-info');
        if(resp.data.status == 'error_info'){
          resp.data.id.forEach(elem=>{
            $('.elem-row[data-id='+elem+']').addClass('error-info');
          })

        }else if(resp.data.status == 'done'){
          Swal.fire({
            title: 'Success update prices',
            text: "تم إرسال التعديلات بنجاح",
            icon: 'success',
            // confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'

          }).then((result) => {
            if (result.isConfirmed) {
              this.backToOrder();
            }
          })
        }
      })
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
      // console.log(elem);
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
        elem.edite != 'delete' ? count += elem.qte : '';

      });
      this.order_product.qte_goute = count;
      this.order_product.qte = count;
    },

    // search of product to add to order
    search_prod_order(str){
      let data = this.search_prod;
      data.action = "search";
      axios.post("/api/saller/order_detail", data).then(response=>{
        this.search_prod.resulte = response.data;
      })
    },

    // on click to product set is in modal
    set_prod(elem){
      if(!this.temp_send){ return false }
      this.temp_send = false;

      let data = {action: "search", id: elem.id}
      axios.post("/api/saller/order_detail", data).then(response=> {
        this.temp_send = true;

        // console.log(response);
        this.show_product = response.data[0];

        this.order_product.order_id   = this.order_id;
        this.order_product.product_id = this.show_product.id;
        this.order_product.price_buy  = this.show_product.price_buy;
        this.order_product.weight     = this.show_product.weight;
        this.order_product.method_qte = this.show_product.method_qte;
        // this.order_product.product    = this.show_product;

        this.search_prod.resulte = '';
      })
    },
    edite_stock(elem, index){
      // console.log(elem);
      elem.in_stock == 1 ? elem.in_stock = 0 : elem.in_stock = 1;

    },
    order_element(data){
      let index = {};
      data.forEach(elem => {
        index[elem.id] = elem;
      });
      return index;
    },
    select_famille(){
      // console.log('show famille')
      this.show_product.categorie_id;
      this.famille_cat = [];
      let famille = this.response.familles;

      for(let elem in famille){
        if(famille[elem].categorie_id == this.search_prod.categorie_id){ this.famille_cat.push(famille[elem]); }
      }
    },

    changeSinglePrice(data, index){
      if(!data.edite_price){
        data.edite_price = true;

      }else{
        data.edite_price = false;
      }
    },

    changeAllPrice(){
      this.tbody.data.forEach(elem=>{
        elem.edite_price = true;
      })
    },

    calc_Price(){
      // console.log(this.order_product.product)
      let method = this.order_product.product.method_price == 'unite' ? this.order_product.product.qte_uc : 1;
      this.order_product.price_total = (this.order_product.price_sell * this.order_product.qte * method) + ',00' ;
    },

    calcPrice(order, method){
      if(method == "unite"){
        return this.setNumber(order.price_sell / (order.product.qte_uc / order.product.method_qte));

      }else if(method == "cartone"){
        return this.setNumber(order.price_sell * order.product.method_qte);

      }else if(method == "total"){
        return this.setNumber(order.price_buy * order.qte * order.method_qte);
      }
    },

    printOrder(){
      this.$root.printOrder(this.order_info);

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
    setNumber(num, func='',elem=''){
      if(func == 'number'){
        return Number(num).toFixed(2) ;

      }else if(func == "set"){
        num[elem] = Number(num[elem]).toFixed(2);

      }else{
        return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
      }
      // console.log(num)
    },

    focus(){ $('.search-prod input')[0].focus() }
  },
  mounted: function(){
    if(this.order_id){
      this.getData();
      this.getOrderInfo();
      this.getHelpInfo();

    }else{
      // console.log('error order_id')
    }
    //

    // this.order_status = this.$parent.order_status;
    this.model_details = new bootstrap.Modal(document.getElementById('modal_order_details'), {});
  },
  watch: {
    "search_prod.categorie_id" : function (){
      this.select_famille();
    },
    "search_prod.str": function(str){
      str ? this.search_prod_order(str): '';
    },
  }
}
</script>
