<template>
  <div class="order-detail content">
    <div class="container">

      <!-- search add edit -->
      <div class="opt-prod">
        <div class="btn-opt mb-2 mt-3">
          <button class="btn btn-outline-primary" @click="addData"><i class="far fa-plus"></i> {{lang.btn_add}}</button>
          <button class="btn btn-outline-success mx-2" @click="getData(1, order_id)"><i class="fas fa-sync-alt"></i> {{lang.btn_sync}}</button>
        </div>
        <input class="form-control me-2" type="search" :placeholder="lang.input_search" aria-label="Search" v-model="search_detail"/>
      </div>
      <!-- start totale prix -->
      <div class="amount mt-3">
        <h5>{{lang.amount}} :</h5>
        <div class="value">{{setNumber(order_info.amount)}} DA</div>
      </div>

      <!-- table -->
      <table class="table table-bordered tab-mobile">
        <thead>
          <tr>
            <!-- <th><span class="select-all"></span></th> -->
            <th class="name">{{lang.tb_product}}</th>
            <th class="q-u">{{lang.tb_price}}</th>
            <th class="opt"></th>
          </tr>
        </thead>
        <tbody>
          <tr class="item" v-for="(elem, index) in order.data" :key="index" >

            <!-- <td class="image"><img :src="'/'+elem.image" alt="." /></td> -->

            <td class="info">
              <p class="name-prod">{{lang.lg == "ar" ? elem.product.name_ar : elem.product.name}}</p>
              <p><span v-html="lang.qte_uc"></span><span class="value">{{elem.product.qte_uc}}</span></p>

              <div v-if="elem.order_detail_goute.length > 0" dir="ltr">
                <span class="m-0">Goute:</span>

                <ul class="list-goute info-order">
                  <li v-for="el in elem.order_detail_goute" :key="el" :class="[el.edite]">
                    <span class="name"><i>{{el.product_goute.goute}}</i></span>
                    <span>Qte: <i>{{el.qte}}</i></span>
                  </li>
                </ul>

              </div>
            </td>

            <td class="price">
                <div class="prix-u"><span>{{lang.price_u}}:</span><span class="value text-end">{{ calcPrice(elem, 'unite') }}</span></div>
                <div class="prix-u"><span>{{lang.price_c}}:</span><span class="value text-end">{{ calcPrice(elem, 'cartone')}}</span></div>
                <div class="qte">
                  <span>{{lang.qte}}: </span>
                  <span class="value">{{elem.qte}}</span>
                </div>
                <div class="prix-t"><span>{{lang.price_total}}: </span><span class="value">{{ calcPrice(elem, 'total')}}</span></div>
            </td>

            <td class="opt dropdown">
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown"></i>
              <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                <a href="#" class="dropdown-item" @click="editeData(elem)"><i class="far fa-pen"></i> {{lang.opt_edite}}</a>
                <a href="#" class="dropdown-item" @click="deleteData(elem, index)"><i class="far fa-trash"></i> {{lang.opt_delete}}</a>
              </div>
            </td>

          </tr>
        </tbody>
      </table>
      <!-- start next and previes page -->
      <router-link :to="'/orders/checkout?order_id='+order_id" class="submit btn btn-primary ms-2">{{lang.btn_checkout}}</router-link>


      <!-- Model for Order Details -->
      <div class="modal fade " id="modal_order_details" data-bs-backdrop="static" tabindex="-1" aria-hidden="true" style="direction: ltr">
        <div class="modal-dialog">
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
                    <input type="search" class="form-control" placeholder="Search..." aria-label="Search" ref="search" v-model="search_prod.str" >
                    <ul class="resulte" ref="resulte">
                      <li v-for="elem in search_resulte" :key="elem" @click="set_prod(elem)">
                        <div class="image"><img :src="'/'+elem.image" alt=""></div>
                        <div class="name">{{elem.name}}</div>
                        <div class="price">{{elem.price_sell1}}</div>
                      </li>
                    </ul>
                  </div>
                </div>

                <div class="row">
                  <div class="col-10">
                    <span>Name</span>
                    <input type="text" class="form-control" disabled :value="show_product.name">
                  </div>
                </div>

                <div class="row mt-3">

                  <div class="col-3 mt-2">
                     <p><span class="name">Qte U/c: <i>{{show_product.qte_uc}}</i></span></p>
                  </div>

                  <div class="col-6 info-order mt-2">
                    <p><span class="name">Price 1: <i v-text="show_product.price_sell1"></i></span></p>
                    <p v-if="show_product.price_sell2"><span class="name">Price 2: <i v-text="show_product.price_sell2"></i></span> Qte: <i v-text="show_product.qte_sell2"></i></p>
                    <p v-if="show_product.price_sell3"><span class="name">Price 3: <i v-text="show_product.price_sell3"></i></span> Qte: <i v-text="show_product.qte_sell3"></i></p>
                  </div>

                  <div class="col-2 qte-order">
                    <span>Qte:</span>
                    <div class="select-qte-angle">
                      <input type="number" :class="['form-control', errors.qte ? 'invalid':'']" v-model="order_product.qte">
                      <span class="up" @click="qte_goute('up')"><i class="fas fa-angle-up"></i></span>
                      <span class="down" @click="qte_goute('down')"><i class="fas fa-angle-down"></i></span>
                    </div>
                  </div>

                </div>

                <div class="row" v-if="show_product.product_goute">

                  <div class="col-4" v-if="show_product.product_goute.length > 0">
                    <span>Goute: </span>
                    <select class="form-select" v-model="prod_goute.id">
                      <option v-for="elem in show_product.product_goute" :value="elem.id" :key="elem" >{{elem.goute}}</option>
                    </select>
                  </div>

                  <div class="col-4" v-if="show_product.product_goute.length > 0">
                    <span>Qte: </span>
                    <div class="select-btn">
                      <input type="number" class="form-control" v-model="prod_goute.qte" v-on:keyup.enter="add_goute">
                      <button class="btn btn-outline-primary ms-3" @click="add_goute">add</button>
                    </div>
                  </div>

                  <div class="col-10" v-if="order_product.order_detail_goute.length > 0">
                    <ul class="list-goute info-order">
                      <li v-for="elem in order_product.order_detail_goute" :key="elem" :class="[elem.edite]">
                        <span class="name"><i>{{elem.product_goute.goute}}</i></span>
                        <div class="opt">
                          <span>Qte: <i>{{elem.qte}}</i></span>
                          <i class="far fa-trash-alt delete-icon" @click="delete_goute(elem)"></i>
                        </div>
                      </li>
                    </ul>
                  </div>

                  <div class="col-6"></div>

                  <div class="col-6 mt-3">
                    <div class="price-product">
                      {{calc_order_total(show_product, 'total')}} DA
                    </div>
                  </div>

                </div>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="empty_data()" data-bs-dismiss="modal">{{lang.btn_canccel}}</button>
              <button type="button" class="btn btn-primary" @click="sendAction()">{{ modal.btn }}</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: "OrdersDetails",
  data: function(){
    return {
      modal: {},

      order: {},
      order_all: [],
      order_info: {},
      order_id: '',
      search_detail: '',

      errors: {},
      search_prod: {categorie_id: '', famille_id: '', },
      search_resulte: {},
      show_product: {},
      order_product: {order_detail_goute:[]},
      prod_goute: {},
      response: {},
      famille_cat: [],

      action_func: '',
      action_wait: 0,
      errors: {},
      ar: {order_id: "الطلب رقم: #", creat: "تم إنشاءه في", num_prod: "عدد المنتجات", add_order: "إضافة",
            search: "بحث", amount: "الثمن الإجمالي", amount_cur: "دج", pr_qte_t: "كمية إجمالية",
            pr_qte_uc: "كمية<sub>و/ك: </sub>", pr_price_u: "ثمن الوحدة", pr_price_c: "ثمن الكرتونة", pr_price_t: "الإجمالي",
            btn_ok: "تم", btn_edite: "تعديل", btn_check: "تحقق من الطلب", error_select: "حدد رقم الطلب",
            error_qte: "حدد الكمية",
          },

      lang: {},
      lang_db: {
        ar: {btn_add: "إضافة", btn_sync: "مزامنة", btn_checkout: "إرسال الطلب", input_search: "بحث", amount: "اﻹجمالي", tb_product: "المنتج",
            tb_price: "الثمن", qte_uc: "كمية<sub>و/ك: </sub>", price_u: "ثمن الوحدة", price_c: "ثمن الكرتونة", qte: "كمية إجمالية",
            price_total: "الإجمالي", opt_edite: "تعديل", opt_delete: "مسح",
            modal_head_add: "إضافة منتج",modal_head_update: "تعديل المنتج", btn_update: "تحديث", btn_canccel: "إلغاء", },

        fr: {btn_add: "Ajouter", btn_sync: "Sync", btn_checkout: "envoyer commande", input_search: "Recherche", amount: "Total", tb_product: "Produit",
            tb_price: "Prix", qte_uc: "Q<sub>U/C: </sub>", price_u: "Prix u", price_c: "Prix c", qte: "Qte T",
            price_total: "Mount", opt_edite: "édité", opt_delete: "supprimer",
            modal_head_add: "Ajouter Produit", modal_head_update: "Produit édité", btn_update: "update", btn_canccel: "Annuler", },

        en: {btn_add: "Add", btn_sync: "Sync", btn_checkout: "Checkout", input_search: "Search", amount: "Total", tb_product: "Product",
            tb_price: "Price", qte_uc: "Q<sub>U/C: </sub>", price_u: "Price u", price_c: "Price c", qte: "Qte T",
            price_total: "Mount", opt_edite: "edite", opt_delete: "delete",
            modal_head_add: "Add Product", modal_head_update:"Edite Product", btn_update: "update", btn_canccel: "Canccel", },
      }
    };
  },
  methods: {
    getHelpInfo(){
      axios.post("/api/order_detail", {action: "getHelpInfo"}).then(response => {
        // // console.log(response);
        this.response.familles = this.order_element(response.data.familles);
        this.response.categories = this.order_element(response.data.categories);
        this.response.finish = true;
      });
    },

    getData(page=1, id){
      let action = 'getData';
      axios.post("/api/order_detail?page="+page, {action: action, order_id: id}).then(response =>{

        // console.log(response);
        if(response.data.status == "done"){
          this.order = response.data.data;

        }else{
          this.back_to_order();
        }
      });
    },

    getOrderInfo(){
      let data = {action: 'getData', order_id: this.order_id}
      axios.post("/api/order", data).then(response =>{
        // console.log(response)
        if(response.data.status == 'error'){
          this.back_to_order();

        }else{
          this.order_info = response.data[0];
        }
      })
    },
    addData(){
      this.modal.title = this.lang.modal_head_add;
      this.modal.btn = this.lang.btn_add;

      this.model_details.show();
      this.action_func = "add";
      setTimeout(e=>{$('.search-prod input')[0].focus();},500)

    },
    deleteData(elem, index){
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
          this.order.data.splice(index, 1)
        }
      })

    },
    editeData(elem){
      // console.log(elem);
      this.show_product = Object.assign({}, elem.product);
      this.order_product = Object.assign({}, elem)

      this.modal.title = this.lang.modal_head_update;
      this.modal.btn = this.lang.btn_update;

      this.model_details.show();
      this.action_func = "update";

    },


    sendAction(elem=''){
      if(this.action_wait == 0){      // wait for finish first response
        this.action_wait = 1

        let action = this.action_func;
        let data = this.order_product;
        data.action = action;
        // console.log(data)

        if(action != 'delete' && data.qte < data.qte_goute){
          this.errors.qte = true;
          this.action_wait = 0;
          return false;

        }else if(action == "delete"){data = elem ; elem.action='delete';};

        axios.post("/api/order_detail", data).then(response => {

          // console.log(response);
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
        this.errors = response.data.errors;
        // console.log(this.errors);

      // if saccess
      } else if(status_resp == "done" && action != 'delete'){
        let id = response.data.data[0]['id'];
        let elem = this.search_id(id, this.order.data);

        if(action == 'update'){
          this.order.data[elem.index] = response.data.data[0];

        }else{
          this.order.data.unshift(response.data.data[0]);

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

    add_goute(){
      let id_goute = this.prod_goute.id,
        qte_goute = this.prod_goute.qte;

      if(id_goute != null && qte_goute > 0){

        let goute = this.search_id(id_goute, this.show_product.product_goute, 'id');
        let data = {product_goute_id: id_goute, qte: qte_goute, product_goute: goute}
        let if_exists = this.search_id(id_goute, this.order_product.order_detail_goute, 'product_goute_id')

        if(if_exists){
          let gout = this.order_product.order_detail_goute[if_exists.index];
          gout.qte = data.qte;
          gout.edite = 'edite';

        }else{
          this.order_product.order_detail_goute.push(data);
        }
      }
      this.prod_goute = {};
      this.count_goute();
    },

    delete_goute(elem){

      if(elem.edite == 'delete'){
        elem.edite = 'edite';

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
    qte_goute(opt){
      this.order_product.qte ? '' : this.order_product.qte = 0;

      if(opt == 'up'){
        this.order_product.qte += 1;

      }else if(opt == 'down'){
        this.order_product.qte > 0 ? this.order_product.qte -= 1 : '';
      }
    },

    // search of product to add to order
    search_prod_order(str){
      let data = {str: str, order_id: this.order_id};
      data.action = "search_detail";
      if(this.order_all.length > 0){

        let result = [];
        this.order_all.forEach(elem=>{
          // // console.log(elem)
          let re = new RegExp(str, "i");
          if(elem.product.name.search(re) > -1 || elem.product.name_ar.search(re) > -1){

            result.push(elem);
          }
        })
        this.order.data = result;

      }else{
        axios.post("/api/order_detail", {action: "getData", order_id: this.order_id, all: true}).then(response =>{
          // console.log(response.data.data)
          this.order_all = response.data.data;
        })
      }
    },

    // on click to product set is in modal
    set_prod(elem){
      if(this.action_wait == 1){ return false }
      this.action_wait = 1

      let data = {action: "search", id: elem.id}
      axios.post("/api/order_detail", data).then(response=> {
        this.action_wait = 0;

        // console.log(response);
        this.show_product = response.data[0];

        this.order_product.product_id = this.show_product.id;
        this.order_product.product = response.data[0];
        this.order_product.price_sell = this.show_product.price_sell1;
        this.order_product.weight = this.show_product.weight
        this.order_product.order_id = this.order_id;

        this.search_resulte = '';
      })
    },
    order_element(data){
      let index = {};
      data.forEach(elem => {
        index[elem.id] = elem;
      });
      return index;
    },

    search(){
      let data = this.search_prod;
      data.action= "search";
      axios.post("/api/order_detail", data).then(resp =>{
        // console.log(resp);
        this.search_resulte = resp.data;
      })
    },

    calcPrice(order, method){
      if(method == "unite"){
        return this.setNumber(order.price_sell / (order.product.qte_uc / order.product.method_qte));

      }else if(method == "cartone"){
        return this.setNumber(order.price_sell * order.product.method_qte);

      }else if(method == "total"){
        return this.setNumber(order.price_total);
      }
    },

    calc_order_total(prod){

        let total = 0;
        if(prod.qte_sell3 && this.order_product.qte >= prod.qte_sell3){
          total = prod.price_sell3 * prod.method_qte * this.order_product.qte || 0;

        }else if(prod.qte_sell2 && this.order_product.qte >= prod.qte_sell2){
          total = prod.price_sell2 * prod.method_qte * this.order_product.qte || 0;

        }else{
          total = prod.price_sell1 * prod.method_qte * this.order_product.qte || 0;
        }
        this.order_product.price_total = total;
        return this.setNumber(total);

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

    select_famille(){
      // console.log('show famille')
      this.famille_cat = [];
      let famille = this.response.familles;

      for(let elem in famille){
        if(famille[elem].categorie_id == this.search_prod.categorie_id){ this.famille_cat.push(famille[elem]); }
      }
    },

    empty_data(){
      this.order_product = {order_detail_goute: []};
      this.show_product = {};
      this.errors = {};
      this.search_prod= {};
    },

    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },

    setDate(date_iso){
      let date = new Date(date_iso);
       return date.toLocaleString("es-CL");
    },

    // focus(){ $('.search-prod input')[0].focus() },

    change_lang(){
      // fot setting lang
      let lg = this.$root.lang;
      if(lg == "ar"){
        this.lang = this.lang_db.ar;
        this.lang.lg = lg;

      }else if(lg == "fr"){
        this.lang = this.lang_db.fr;

      }else{
        this.lang = this.lang_db.en
      }
    },

    after(){

      let order_id = this.$route.query.order_id;

      if(this.$root.login == false){

        Swal.fire({
          title: "يجب تسجيل الدخول",
          text: "يجب تسجيل الدخول لعرض تفاصيل طلبك",
          icon: 'warning',
          reverseButtons: true,
          showCancelButton: true,

        }).then((result) => {
          if (result.isConfirmed) {
            this.$router.push({name: "Login"});
          }else{
            this.$router.push({name: "store"});
          }
        });

      }else if(order_id == 'undefined' || order_id == undefined){
        this.back_to_order();

      }else{
        this.order_id = order_id;
        this.getHelpInfo();
        this.getData(1, order_id);
        this.getOrderInfo();
        this.user = this.$root.user;
        this.user.login = this.$root.login;

      }
      this.change_lang();
    },

    back_to_order(){
      this.$router.push({ path: "/orders" });
    }

  },
  mounted: function(){
    this.model_details = new bootstrap.Modal(document.getElementById('modal_order_details'), {});

    // if user login action
    if(this.$root.render == true){
      // console.log('not true')
      this.after();
    }

    // show top navbar
    this.$root.top_nav = true;

    // this.change_lang();
    // console.log(this.$route.query)


  },
  watch: {
    '$root.render': function(){this.after(); },    // on response for login,

    '$root.lang'  : function(){ this.change_lang()},
    'search_prod.categorie_id': function(){this.select_famille();},

    'search_prod.str': function(){
      // console.log('serch')
      if(this.search_prod.str){
        this.search();
      }
    },
    search_detail(str){
      this.search_prod_order(str);
    }
  }
};
</script>

