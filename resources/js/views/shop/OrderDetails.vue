<template>
  <div class="orders-details">
    <div class="container">

      <!-- search add edit -->
      <div class="opt-prod">
        <div class="btn-opt mb-2">
          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add-prod"><i class="far fa-plus"></i> Add</button>
        </div>
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
      </div>
      <!-- start totale prix -->
      <div class="shop-prix">
        <h5>Totale :</h5>
        <div class="mon"><span class="value">1834,00</span><span class="cur"> DA</span></div>
      </div>
      <!-- add product -->
      <add-product />
      <!-- Porduct info -->
      <product />
      <!-- table -->
      <table class="table table-bordered tab-mobile">
        <thead>
          <tr>
            <th><span class="select-all"></span></th>
            <th class="name">name</th>
            <th class="q-u">Prix</th>
            <th class="opt"></th>
          </tr>
        </thead>
        <tbody>
          <tr class="item" v-for="(elem, index) in order.data" :key="index" >

            <!-- <td class="image"><img :src="'/'+elem.image" alt="." /></td> -->
            <td class="product">
              <p class="name">{{lang.lg == "ar" ? elem.name_ar : elem.name}}</p>
              <p><span v-html="lang.pr_qte_uc"></span><span class="value">{{elem.qte_uc}}</span></p>

              <div v-if="elem.product_goute.length > 0" dir="ltr">
                <span class="m-0">Goute:</span>

                <ul class="list-goute info-order" v-if="elem.order_detail_goute && elem.order_detail_goute.length > 0">
                    <li v-for="el in elem.order_detail_goute" :key="el" :class="[el.edite]">
                      <span class="name"><i>{{el.product_goute.goute}}</i></span>
                      <div class="opt">
                        <span>Qte: <i>{{el.qte}}</i></span>
                        <i class="far fa-trash-alt delete-icon" @click="delete_goute(el, elem)" v-if="!elem.order_set"></i>
                      </div>
                    </li>
                  </ul>

              </div>
            </td>

            <td class="">
              <div class="cont prix">
                <div class="prix-u"><span>{{lang.pr_price_u}}:</span><span class="value text-end">{{ calc_price(elem, 'unite') }}</span></div>
                <div class="prix-u"><span>{{lang.pr_price_c}}:</span><span class="value text-end">{{ calc_price(elem, 'cartone')}}</span></div>
                <div class="qte">
                  <span>{{lang.pr_qte_t}}: </span>
                  <span class="value">{{elem.order_qte}}</span>
                </div>
                <div class="prix-t"><span>{{lang.pr_price_t}}: </span><span class="value">{{ calc_price(elem, 'total')}}</span></div>
              </div>
            </td>

          </tr>
        </tbody>
      </table>
      <!-- start next and previes page -->
      <router-link to="/orders" href="/orders" class="submit btn btn-success">Save</router-link>
      <router-link to="/orders/checkout" href="/orders/checkout" class="submit btn btn-primary ms-2">Checkout</router-link>


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
                    <input type="number" :class="['form-control', errors.price_sell? 'is-invalid':'']" v-model="order_product.price_sell" >
                  </div>
                  <div class="col-2">
                    <span>Qte:</span>
                    <input type="number" :class="['form-control', errors.qte? 'is-invalid':'']" v-model="order_product.qte">
                  </div>
                  <div class="col-6 info-order">
                    <p><span class="name">Qte U/c: <i>{{show_product.qte_uc}}</i></span></p>
                    <p><span class="name">Price 1: <i v-text="show_product.price_sell1"></i></span></p>
                    <p v-if="show_product.price_sell2"><span class="name">Price 2: <i v-text="show_product.price_sell2"></i></span> Qte: <i v-text="show_product.qte_sell2"></i></p>
                    <p v-if="show_product.price_sell3"><span class="name">Price 3: <i v-text="show_product.price_sell3"></i></span> Qte: <i v-text="show_product.qte_sell2"></i></p>
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
  </div>
</template>

<script>
export default {
  name: "OrdersDetails",
  data: function(){
    return {
      order: {},
      lang: {order_id: "Order Id: #", creat: "Creat at", num_prod: "Product", add_order: "add",
            search: "Search", amount: "Total Price", amount_cur: "DA", pr_qte_t: "Qte T",
            pr_qte_uc: "Q<sub>U/C: </sub>", pr_price_u: "Price u", pr_price_c: "Price c", pr_price_t: "Mount",
            btn_ok: "ok", btn_edite: "edite"
          },
      errors: {},
      search_prod: {categorie_id: '', famille_id: '', }
    };
  },
  methods: {
    getHelpInfo(){
      axios.post("/api/admin/order_detail", {action: "getHelpInfo"}).then(response => {
        // console.log(response);
        this.response.familles = this.order_element(response.data.familles);
        this.response.categories = this.order_element(response.data.categories);
        this.response.finish = true;
      });
    },

    getData(page=1){
      let action = 'getData';
      axios.post("/api/admin/order_detail?page="+page, {action: action, order_id: this.order_id}).then(response =>{

        console.log(response);
        if(response.data.status == "done"){
          this.tbody = resp.data;
        }
      });
    },

    getOrderInfo(){
      let data = {action: 'getData', id: this.order_id}
      axios.post("/api/admin/order", data).then(response =>{
        this.order_info = response.data.data[0];
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
        elem.edite != 'delete' ? count += elem.qte : '';

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

    calcPrice(){
      console.log(this.order_product.product)
      let method = this.order_product.product.method_price == 'unite' ? this.order_product.product.qte_uc : 1;
      this.order_product.price_total = (this.order_product.price_sell * this.order_product.qte * method) + ',00' ;
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

    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },

    setDate(date_iso){
      let date = new Date(date_iso);
       return date.toLocaleString("es-CL");
    },

    focus(){ $('.search-prod input')[0].focus() },

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
      this.getHelpInfo();
      this.getData();
      this.user = this.$root.user;
      this.user.login = this.$root.login;

      if(this.user.login){
        this.getOrder();
      }

    },




  },
  mounted: function(){
    this.model_details = new bootstrap.Modal(document.getElementById('modal_order_details'), {});

    // if user login action
    if(this.$root.render == true){
      this.after();
    }

    // show top navbar
    this.$root.top_nav = true;

    this.change_lang();

  },
  warch: {
    '$root.render': function(){ this.after() },    // on response for login,
    '$root.lang'  : function(){ this.change_lang()},
    'search_prod.categorie_id': function(){
      this.select_famille();
      this.search();
    },
    'search_prod.famille_id': function(){this.search();},
    'search_prod.str': function(){
      console.log('serch')
      if(this.search_prod.str){
        this.search();
      }
    },
  }
};
</script>

<style lang="scss" scoped>
// producnt info
</style>
