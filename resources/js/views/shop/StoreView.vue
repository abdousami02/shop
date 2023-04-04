<template>
  <div class="store">
    <div class="container">
      <!-- <nav class="nav-links">
        <a href="#" class="linkd">Home</a> /
        <a href="#" class="linkd">Store</a>
      </nav> -->
      <!-- star select order & info -->
      <div class="order-set" v-if="$root.login">

        <div class="sel-order mt-3">
          <h4 class="d-inline-block">{{lang.order_id}}<span v-text="order_select.id"></span></h4>
          <br />
          <select class="form-select order-select form-select-sm mb-2 d-block" v-model="order_select" aria-label="Default select example">
            <option v-for="elem in order_db" :key="elem" :value="elem">{{elem.id+'_ ('+elem.amount+' DA)'}}</option>
          </select>
          <button type="button" class="btn btn-success btn-sm ms-2" @click="addOrder"><i class="fal fa-plus"></i> {{lang.add_order}}</button>
        </div>

        <div class="order-info">
          <p>{{lang.creat}}: <br /><span class="date">{{setDate(order_select.created_at)}}</span></p>
          <p>{{lang.num_prod}}: <span>{{order_select.num_product}}</span></p>
        </div>
      </div>
      <!-- start select family & categorie & search -->
      <div class="opt-search">

        <!-- select option -->
        <div class="select-prod">
          <select class="form-select form-select-sm cat-select mx-2" v-if="response.categories" v-model="search_prod.categorie_id">
            <option v-for="elem in response.categories" :key="elem" :value="elem.id">{{elem.name}}</option>
          </select>

          <select class="form-select from-select-sm fami-select" v-model="search_prod.famille_id">
            <option v-for="elem in famille_cat" :key="elem" :value="elem.id">{{elem.name}}</option>
            <option value=""></option>
          </select>
        </div>

        <!-- search -->
        <input class="form-control mb-2" type="search" :placeholder="lang.search" v-model="search_prod.str"/>
        <!-- <search /> -->

      </div>
      <!-- start totale prix -->
      <div class="amount">
        <h5>{{lang.amount}} :</h5>
        <div class="value">{{ setNumber(order_select.amount)}} {{lang.amount_cur}}</div>
      </div>
      <!-- start tabel mobile -->
      <table class="table table-bordered tab-mobile">
        <thead>
          <tr>
            <th class="image">image</th>
            <th class="name">name</th>
            <th class="q-u">Prix</th>
            <!-- <th class="opt"></th> -->
          </tr>
        </thead>
        <tbody>
          <tr :class="['item',elem.order_set]" v-for="(elem, index) in product.data" :key="index" >

            <td class="image"><img :src="'/'+elem.image" alt="." /></td>
            <td class="product">
              <p class="name">{{lang.lg == "ar" ? elem.name_ar : elem.name}}</p>
              <p><span v-html="lang.pr_qte_uc"></span><span class="value">{{elem.qte_uc}}</span></p>

              <div v-if="elem.product_goute.length > 0" dir="ltr">
                <span class="m-0">Goute:</span>
                <div class="goute" v-if="!elem.order_set">
                  <select class="form-select form-select-sm" v-model="elem.order_goute">
                    <option v-for="goute in elem.product_goute" :key="goute" :value="goute">{{goute.goute}}</option>
                  </select>
                  <div class="select-qte-angle">
                    <input type="number" class="form-control" v-model="elem.order_goute_qte">
                    <span class="up" @click="qte_goute('up', elem)"><i class="fas fa-angle-up"></i></span>
                    <span class="down" @click="qte_goute('down', elem)"><i class="fas fa-angle-down"></i></span>
                  </div>
                  <button class="btn btn-outline-success" @click="add_goute(elem)"><i class="fas fa-plus"></i></button>

                </div>
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
                  <div class="select-qte-angle" v-if="!elem.order_set">
                    <input type="number" class="form-control" v-model="elem.order_qte" />
                    <span class="plus" @click="qte_goute('plus', elem)"><i class="far fa-plus"></i></span>
                    <span class="minus" @click="qte_goute('minus', elem)"><i class="far fa-minus"></i></span>
                  </div>
                  <span v-if="elem.order_set" class="value">{{elem.order_qte}}</span>
                </div>
                <div class="prix-t"><span>{{lang.pr_price_t}}: </span><span class="value">{{ calc_price(elem, 'total')}}</span></div>
                <button type="button" :class="['btn','set-btn', elem.order_set?'btn-outline-secondary':'btn-primary']" @click="setInOrder(elem)">{{ elem.order_set ? lang.btn_edite : lang.btn_ok }}</button>
              </div>
            </td>

          </tr>

        </tbody>
      </table>
      <!-- start table pc -->
      <!-- <table class="table table-bordered tab-pc table-hover">
        <thead>
          <tr>
            <th class="image">image</th>
            <th class="name">name</th>
            <th class="q-u">Prix Unit</th>
            <th class="qte-u">Q<sub>U/C: </sub></th>
            <th class="qte">Qte</th>
            <th class="prix-t">Prix Tot</th>
            <th class="opt">de</th>
          </tr>
        </thead>
        <tbody>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p class="name">Margarin Sol 500g</p>
            </td>
            <td class="prix-u"><span class="num">198</span></td>
            <td class="q-u"><span class="num">24</span></td>
            <td class="qte"><input type="number" name="" /></td>
            <td class="prix-t"><span class="num">4752</span></td>
            <td class="opt dropdown">
              <button type="button" class="btn btn-primary">ok</button>
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                  <a href="#" class="dropdown-item">info</a>
                </div>
              </i>
            </td>
          </tr>
          <tr class="item">
            <td>
              <div class="image"><img src="" alt="." class="" /></div>
            </td>
            <td>
              <p>Fanta 1L</p>
              <div class="gout">
                <p class="m-0">Goute:</p>
                <select class="form-select form-select-sm" style="width: 100px" aria-label="Default select example">
                  <option value="Categorie" selected>Frais</option>
                  <option value="2">Pomme</option>
                  <option value="3">Orange</option>
                  <option value="3">Ananas</option>
                </select>
              </div>
            </td>
            <td class="prix-u"><span class="num">88</span> DA</td>
            <td class="q-u"><span class="num">6</span></td>
            <td class="qte">
              <input type="number" name="" />
              <div class="qte-gout">
                <p class="gout"><span class="gout">Frais</span>: <span class="num">3</span></p>
                <p class="gout"><span class="gout">Pomme</span>: <span class="num">2</span></p>
              </div>
            </td>
            <td class="prix-t"><span class="num">528</span> DA</td>
            <td>
              <div class="opt dropdown">
                <button type="button" class="btn btn-primary">ok</button>
                <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                  <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                    <a href="#" class="dropdown-item">info</a>
                  </div>
                </i>
              </div>
            </td>
          </tr>
        </tbody>
      </table> -->
      <!-- start next and previes page -->
      <div class="submit">
        <router-link :to="'/orders/orderDetails?order_id='+order_select.id" class="btn btn-success">{{lang.btn_check}}</router-link>
      </div>

       <pagination :data="product" @pagination-change-page="getData" />

    </div>
  </div>
</template>

<script>

// import item from "../components/item/StoreItem.vue";
export default {
  name: "StorePage",
  data: function () {
    return {
      order_num: "None",
      response: {},
      famille_cat: [],
      product: {},
      search_prod: {},
      goute_prod: {qte: 0,},

      order_local: '',
      order_db: [],
      order_select: {amount: 0},
      detail_sel: [],
      user: {},
      action_temp: true,

      lang: {order_id: ''},
      lang_db: {
        ar: {order_id: "الطلب رقم: #", creat: "تم إنشاءه في", num_prod: "عدد المنتجات", add_order: "إضافة",
            search: "بحث", amount: "الثمن الإجمالي", amount_cur: "دج", pr_qte_t: "كمية إجمالية",
            pr_qte_uc: "كمية<sub>و/ك: </sub>", pr_price_u: "ثمن الوحدة", pr_price_c: "ثمن الكرتونة", pr_price_t: "الإجمالي",
            btn_ok: "تم", btn_edite: "تعديل", btn_check: "تحقق من الطلب", error_select: "حدد رقم الطلب",
            error_qte: "حدد الكمية",
          },

        fr: {order_id: "Commande Id: #", creat: "Create at", num_prod: "Produits", add_order: "ajoute",
            search: "Recherche", amount: "Total Prix", amount_cur: "DA", pr_qte_t: "Qte T",
            pr_qte_uc: "Q<sub>U/C: </sub>", pr_price_u: "Prix u", pr_price_c: "Prix c", pr_price_t: "Mount",
            btn_ok: "ok", btn_edite: "modifie", btn_check: 'vérifier la commande',
            error_select: "sélectionner la commande", error_qte: "qte n'est pas définie",
          },

        en: {order_id: "Order Id: #", creat: "Creat at", num_prod: "Product", add_order: "add",
            search: "Search", amount: "Total Price", amount_cur: "DA", pr_qte_t: "Qte T",
            pr_qte_uc: "Q<sub>U/C: </sub>", pr_price_u: "Price u", pr_price_c: "Price c", pr_price_t: "Mount",
            btn_ok: "ok", btn_edite: "edite", btn_check: 'check order',
            error_select: "select order", error_qte: "qte not set",
          },
      }

    };
  },
  components: {

  },

  methods: {
    getHelpInfo(){
      axios.post("/api/guest", {action: "getHelpInfo"}).then(response => {
        // // console.log(response.data);
        this.response.categories = response.data.categories;
        this.response.familles = response.data.familles;
      });
    },

    getData(page=1, select=''){
      axios.post("/api/guest?page="+page, {action: "getProduct"}).then(response => {
        // // console.log(response.data);
        this.product = response.data.data;

        if(select && this.$root.login){

          if(this.order_select.id == 'local'){
            this.detail_sel = this.order_local.detail;
            this.setLocalOrder();

          }else{
            this.getOrderDetail();
          }

        }else{
          this.checkStoragOrder();
        }
      })
    },

    getOrder(){
      axios.post("/api/store", {action: "getOrder"}).then(response =>{
        // // console.log(response.data);
        this.order_db = this.order_local ? [this.order_local.info] : [];
        this.order_db = this.order_db.concat(response.data);
      });
    },

    addOrder(){
      Swal.fire({
        title: 'Are you sure to Add Order!',
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,

      }).then((result) => {
        if (result.isConfirmed) {
          if(!this.action_temp){ return false }
          this.action_temp = false;

          axios.post("/api/store", {action: "addOrder"}).then(resp =>{
            this.action_temp = true;

            // // console.log(resp.data);
            if(resp.data.status == 'done'){
              this.order_db.push(resp.data.data);
              this.order_select = resp.data.data;
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

    getOrderDetail(){
      let data = {order_id: this.order_select.id, action: "getData", all: true};
      axios.post("/api/order_detail", data).then(response =>{
        // // console.log(response.data);

        if(response.data.status == 'done'){
          this.detail_sel = response.data.data
          this.setLocalOrder()
        }else{
          Swal.fire({
            icon: 'error',
            title: 'Have Error',
            showConfirmButton: false,
            timer: 1000
          });
        }
      })
    },

    addOrderItem( order_id, prod){

      if(!this.action_temp){ return false }
      this.action_temp = false;

      let data = prod;
      data.order_id = order_id;
      data.action = "add";

      axios.post("/api/order_detail", data).then(resp =>{
        this.action_temp = true;
        // // console.log(resp.data)
        if(resp.data.status == 'done'){
          this.detail_sel.push(resp.data.data[0])
          this.setLocalOrder();

        }else{
          Swal.fire({
            icon: 'error',
            title: 'Have Error',
            showConfirmButton: false,
            timer: 1000
          });
        }
      })
    },
    deleteOrderItem(elem){
      if(!this.action_temp){ return false }
      this.action_temp = false;

      let data = {action: 'delete', id: elem.id, "order_id": elem.order_id};
      axios.post("/api/order_detail", data).then(resp => {
        this.action_temp = true;
        // // console.log(resp.data);
        if(resp.status == "error"){
          Swal.fire({
            icon: 'error',
            title: 'Have Error',
            showConfirmButton: false,
            timer: 1000
          });
        }
      })
    },

    setInOrder(prod){

      let data = {
        product_id: prod.id,
        qte:        prod.order_qte,
        price_total:prod.order_total,
        product:    prod,
        order_detail_goute: prod.order_detail_goute,
      }

      if(this.$root.login && this.order_select.id != 'local'){
        if(this.order_select.id){

          if(!prod.order_qte){
            Swal.fire({
              icon: 'info',
              title: this.lang.error_qte,
              showConfirmButton: false,
              timer: 1000
            });

          }else{
            let if_exists = this.search_id(data.product_id, this.detail_sel, 'product_id');
            if(if_exists){
              this.deleteOrderItem(if_exists);

              this.detail_sel.splice(if_exists.index ,1)
              this.setLocalOrder()
              prod.order_set = "";

            }else{
              this.addOrderItem(this.order_select.id, data);
              // this.setLocalOrder()
            }
          }

        }else{
          Swal.fire({
            icon: 'info',
            title: this.lang.error_select,
            showConfirmButton: false,
            timer: 1500
          });
        }

      }else{
        let order_info, order_detail;

        if(this.order_local){

          order_info = this.order_local.info,
          order_detail = this.order_local.detail;
          order_info.amount = Number(order_info.amount);

          let if_exists = this.search_id(data.product_id, order_detail, "product_id");

          if(if_exists){
            // console.log('yes exitst');
            let old = order_detail[if_exists.index];
            order_info.amount -= old.price_total;
            order_info.num_product -= 1;

            prod.order_set = "";
            order_detail.splice(if_exists.index, 1);

          }else if(prod.order_qte > 0){
            prod.order_set = "set";
            order_detail.push(data);
            order_info.amount += data.price_total
            order_info.num_product += 1;

          }else{
            prod.order_set = "";
            return false;
          }
          // // console.log(order_detail)
        }else if(prod.order_qte > 0){
          prod.order_set = "set";
          order_detail = [data];
          let date = new Date();
          date = date.toISOString();
          order_info = {amount: data.price_total, id: 'local', created_at: date, num_product: 1};

          this.order_select = Object.assign({watch:false},order_info);
          this.order_local = {info: order_info, detail: order_detail};

        }else{
          prod.order_set = "";
          return false;
          // // console.log(order_detail)
        }

        this.order_select.amount = order_info.amount;

        order_detail = JSON.stringify(order_detail);
        localStorage.setItem("order_detail", order_detail);

        order_info = JSON.stringify(order_info);
        localStorage.setItem("order_info", order_info);

      }

    },

    checkStoragOrder(){

      if(this.$root.login){

        if(this.order_local && this.order_select.id == "local"){
          this.detail_sel = this.order_local.detail;
          this.setLocalOrder();

        }else{
          this.setLocalOrder();
          // this.getOrderDetail()
        }

      }else if(this.order_local){
        // console.log('set order not login')
        // this.order_db.push(this.order_local.info);
        this.detail_sel = this.order_local.detail;
        this.setLocalOrder();
      }

    },

    setLocalOrder(){

      let num_prod = 0, total_price = 0;

      this.detail_sel.forEach(elem =>{
          num_prod++;
          total_price += Number(elem.price_total);

        let prod = this.search_id(elem.product_id, this.product.data, 'id' );
        if(prod){

          let data = {
            order_qte: elem.qte,
            order_total: elem.price_total,
            order_detail_goute: elem.order_detail_goute,
            order_set: 'set',
          }
          Object.assign(this.product.data[prod.index], data);
        }
      })
      this.order_select.amount = total_price;
      this.order_select.num_product = num_prod;
    },

    calc_price(prod, method){
      if(method == "unite"){
        return this.setNumber(prod.price_sell1 / (prod.qte_uc / prod.method_qte));

      }else if(method == "cartone"){
        return this.setNumber(prod.price_sell1 * prod.method_qte);

      }else if(method == "total"){
        let total = prod.price_sell1 * prod.method_qte * prod.order_qte || 0;
        prod.order_total = total;
        return this.setNumber(total);
      }
    },

    search(){
      let data = this.search_prod;
      data.action= "search";
      axios.post("/api/guest", data).then(resp =>{
        // console.log(resp);
        this.product = resp.data;
        this.checkStoragOrder();
      })
    },
    select_famille(){
      let cat_id = this.search_prod.categorie_id;
      this.famille_cat = [];
      this.response.familles.forEach(elem => {
        if(elem.categorie_id == cat_id){ this.famille_cat.push(elem); }
      });
    },
    qte_goute(opt, elem){
      // elem.order_goute_qte = 4;
      elem.order_goute_qte ? '' : elem.order_goute_qte = 0;
      elem.order_qte ? '' : elem.order_qte = 0;
      if(opt == 'up'){
        elem.order_goute_qte += 1;

      }else if(opt == 'down'){
        elem.order_goute_qte > 0 ? elem.order_goute_qte -= 1 : '';

      }else if(opt == 'plus'){
        elem.order_qte += 1;

      }else if(opt == 'minus'){
        elem.order_qte > 0 ? elem.order_qte -= 1 : '';
      }
    },

    add_goute(elem){

      let id_goute  = elem.order_goute.id,
          name_goute= elem.order_goute,
          qte_goute = elem.order_goute_qte;
          // console.log(name_goute)

      if(id_goute != null && qte_goute > 0){

        // let goute = this.search_id(id_goute, this.show_product.product_goute, 'id');
        let data = {product_goute_id: id_goute, qte: qte_goute, product_goute: name_goute}
        let if_exists = this.search_id(id_goute, elem.order_detail_goute, 'product_goute_id')

        Array.isArray(elem.order_detail_goute) ? '' : elem.order_detail_goute = [] ;

        if(if_exists){
          let gout = elem.order_detail_goute[if_exists.index];
          gout.qte = data.qte;
          gout.edite = 'edite';

        }else{
          elem.order_detail_goute.push(data);
        }
      }
      elem.order_goute = '';
      elem.order_goute_qte = '';
      this.count_goute(elem);
    },

    delete_goute(elem, prod){

      if(elem.edite == 'delete'){
        elem.edite = 'edite';

      }else{
        elem.edite = 'delete';
      }
      this.count_goute(prod);
    },

    count_goute(elem){
      let count = 0;
      elem.order_detail_goute.forEach(el =>{
        el.edite != 'delete' ? count += el.qte : '';

      });
      elem.order_qte_goute = count;
      elem.order_qte = count ;
    },

    search_id(id_search, from_search, id='id'){
      for(let ind in from_search){           // loop in response and get data of element with id

        if(id_search == from_search[ind][id]){
          from_search[ind].index = ind;
          return from_search[ind];
        }
      };
      return null;
    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },
    setDate(date_iso){
      let date = new Date(date_iso);
       return date.toLocaleString("es-CL");
    },
    after(){
      this.getHelpInfo();
      this.getData();
      this.user = this.$root.user;
      // console.log(this.$root.login)

      if(this.$root.login){
        this.getOrder();
      }

    },

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
    }

  },
  mounted: function(){

    // for local order Item
    let order_info = localStorage.getItem("order_info"),
        order_detail = localStorage.getItem("order_detail");

    if(order_info && order_detail){
      this.order_local = {
        info: JSON.parse(order_info),
        detail: JSON.parse(order_detail)
      };
    }


    // if user login action
    if(this.$root.render == true){
      this.after();
    }

    // show top navbar
    this.$root.top_nav = true;

    this.change_lang();

  },
  watch: {
    '$root.render': function(){ this.after() },    // on response for login,
    '$root.lang'  : function(){ this.change_lang()},
    'search_prod.categorie_id': function(){
      this.select_famille();
      this.search();
    },
    'search_prod.famille_id': function(){this.search();},
    'search_prod.str': function(){
      // console.log('serch')
      if(this.search_prod.str){
        this.search();
      }
    },

    'order_select': function(){
      let elem = this.order_select;
      if(elem.watch != false){
        // console.log("selected change")
        this.getData(1, true)
      }
    }

  }
};
</script>
