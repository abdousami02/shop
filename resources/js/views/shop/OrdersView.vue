<template>
  <div class="orders">
    <div class="container">
      <!-- <nav class="nav-links my-2">
        <a href="#" class="linkd">Home</a> /<a href="#" class="linkd">Orders</a> /
        <a href="#" class="linkd">No: 434</a>
      </nav> -->
      <!-- search add edit -->
      <h4 class="mt-4">{{lang.title_order}}:</h4>
      <div class="opt-order">
        <div class="btn-opt mb-2">
          <button class="btn btn-success btn-sm" @click="addOrder()"><i class="far fa-plus"></i> {{lang.btn_add}}</button>
        </div>
      </div>
      <!-- orders Lists -->

      <div class="orders-list">
        <!-- <div class="item">
          <p class="date">Created at:<br /><span class="value">02/01/2023-12:44</span></p>
          <p class="num">No: <span class="value">356</span></p>
          <p class="status">Status: <span class="value">Pending</span></p>
          <p class="montant">Montant: <span class="value">1853,00</span></p>
        </div> -->
        <!-- table for PC -->
        <!-- <table class="table table-bordered table-hover tab-pc" v-if="false">
          <thead>
            <tr>
              <th class="select-all"></th>
              <th class="num">Number</th>
              <th class="date">date</th>
              <th class="stat">Status</th>
              <td class="num-prod">Produites</td>
              <td class="poid">Poid</td>
              <th class="total">Montant</th>
              <th class="opt"></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="select"><input type="checkbox" name="select" /></div>
              </td>
              <td class="num">356</td>
              <td class="date">02/01/2023-12:44</td>
              <td class="status">Pending</td>
              <td class="num-prod">35</td>
              <td class="poid"><span>1345</span> Kg</td>
              <td class="total">1853,00</td>
              <td class="opt dropdown">
                <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown">
                  <div class="dropdown-menu dropdown-menu-end" data-bs-popper="static">
                    <router-link to="/orders/orderDetails" class="dropdown-item">Modifier</router-link>
                    <a href="/" class="dropdown-item">Deleat</a>
                    <a href="https://google.com" class="dropdown-item">Send checkout</a>
                    <a href="/" class="dropdown-item">canccel Order</a>
                  </div>
                </i>
              </td>
            </tr>
          </tbody>
        </table> -->

        <!-- table for mobile -->
        <table class="table table-bordered tab-mobile">
          <thead>
            <tr>
              <th class="select-all"></th>
              <th class="">{{lang.tb_info}}</th>
              <th class="">{{lang.tb_total}}</th>
              <th class="opt"></th>
            </tr>
          </thead>
          <tbody>
            <tr :class="['item', order.id == 'local' ? 'local' : '']" v-for="(order, index) in response.order" :key="order">

              <td class="select">
                <input type="checkbox" name="select" />
              </td>
              <td class="info">
                <div class="num ">{{lang.info_id}}: <span class="value">{{order.id}}</span></div>
                <div class="status">{{lang.info_status}}: <span class="value">{{lang.status[order.status]}}</span></div>
                <div class="date">{{lang.info_date}}: <span class="value">{{setDate(order.created_at)}}</span></div>
                <p class="local-order" v-if="order.id == 'local' ">
                  {{lang.not_reg}}<button @click="addLocalOrder" class="btn btn-success">{{lang.btn_add}}</button>
                </p>
              </td>
              <td class="price">
                <div class="num-prod ">{{lang.total_prd}} :<span class="value">{{order.num_product}}</span></div>
                <div class="poid">{{lang.total_weight}}: <span class="value">{{order.weight || 0}} Kg</span></div>
                <div class="prix-t">{{lang.amount}}: <span class="value">{{setNumber(order.amount)}} DA</span></div>
              </td>
              <td class="opt dropdown">
                <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown"></i>
                <div class="dropdown-menu dropdown-menu-end">
                  <router-link :to="'/orders/orderDetails?order_id='+order.id" href="/orders/orderDetails?order_id=" class="dropdown-item"><i class="far fa-pen"></i> {{lang.opt_edite}}</router-link>
                  <a class="dropdown-item" @click="deleteOrder(order,index)"><i class="far fa-trash"></i> {{lang.opt_delete}}</a>
                  <a class="dropdown-item"><i class="far fa-money-check-edit-alt"></i> {{lang.opt_checkout}}</a>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
export default {
  name: "OrdersView",
  components: {

  },
  data: function(){
    return {
      response: {order:[]},
      order_local: '',
      temp_send: true,

      lang: {},
      lang_db: {
        ar: {title_order: "الطلبات", btn_add: "إضافة", tb_info: "معلومات", tb_total: "المجموع", info_id: "رقم", info_status: "الحالة", info_date: "التاريخ",
            total_prd: "المنتجات", total_weight: "الوزن", amount: "الإجمالي", not_reg: "هذا الطلب غير محفوظ",
            warn_add: "هل أنت متأكد من إضافة طلب!", warn_del: "هل أنت متأكد من حذف الطلب!", error: "هناك خطأ",
            warn_login_title: "يحب تسجيل الدخول", warn_loign_text: "يجب تسجيل الدخول لإظهار طلباتك",
            btn_ok: "حسنا", btn_cancel: "إلغاء", opt_edite: "تعديل", opt_delete: "مسح", opt_checkout: "تأكيد الطلب",
            status:{0: 'مسودة', 1: 'جاري المعالجة', 2: 'جاري المعالجة',3: 'جاري المعالجة', 4: 'إنتظار رد المستخدم',
                    5: 'جار التوصيل', 6:'تم التوصيل', 7: 'تم التوصيل', 9: 'تم الإلغاء'},},

        fr: {title_order: "Orders", btn_add: "Ajouter", tb_info: "Info", tb_total: "Total", info_id: "ID", info_status: "Statut", info_date: "Date",
            total_prd: "Produits", total_weight: "Poids", amount: "montante", not_reg: "",
            warn_add: "Êtes-vous sûr d'ajouter une commande !", warn_del: "Êtes-vous sûr de supprimer la commande !", error: "Avoir une erreur",
            warn_login_title: "Doit être connecté", warn_loign_text: "devez vous connecter pour afficher votre commandes",
            btn_ok: "OK", btn_cancel: "Annuler", opt_edite: "édité", opt_delete: "supprimer", opt_checkout: "envoyer commande",
            status:{0: 'Brouillon', 1: 'processing', 2: 'processing',3: 'processing', 4: "l'utilisateur approuve",
                    5: 'Préparez à livraison' , 6:'finir', 7: 'finir', 9: 'Annulé'},},

        en: {title_order: "Orders", btn_add: "add", tb_info: "Info", tb_total: "Total", info_id: "ID", info_status: "Status", info_date: "Date",
            total_prd: "Products", total_weight: "Weight", amount: "amount", not_reg: "This Order not register",
            warn_add: "Are you sure to Add Order!", warn_del: "Are you sure to Delete Order!", error: "Have Error",
            warn_login_title: "Must be login", warn_loign_text: "must login to show your orders",
            btn_ok: "OK", btn_cancel: "Cancel", opt_edite: "edit", opt_delete: "delete", opt_checkout: "checkout",
            status:{0: 'Draft', 1: 'processing', 2: 'processing',3: 'processing', 4: 'Attemp user approve',
                    5: 'Prepare to delevery', 6:'finish', 7: 'finish', 9: 'Cancceled'},},
      }
    }
  },
  methods: {
    getData(page=1){
      let data = {action: "getData"}
      axios.post("/api/order?page"+page, data).then(response=>{
        // console.log(response);
        this.response.order = response.data.data;

        if(this.order_local){
          if(Array.isArray(this.response.order)){
            this.response.order.unshift(this.order_local.info)

          }else{
            this.response.order = [this.order_local.info]
          }
        }
      })
    },
    setFamille(){
      let data = {
        categorie_id: 1,
        name: 'pate',
        name_ar: "عجائن",
      }
      // console.log(data);
      axios.post('api/famille', data).then(response=>{
        // console.log(response);
      })
    },
    addOrder(){
       Swal.fire({
        title: this.lang.warn_add,
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,

      }).then((result) => {
        if (result.isConfirmed) {
          if(!this.temp_send){ return false }
          this.temp_send = false;

          axios.post("/api/order", {action: "add"}).then(resp=>{
            this.temp_send = true;

            // console.log(resp);
            if(resp.data.status == 'done'){
              this.response.order.unshift(resp.data.data)

            }else{
              Swal.fire({
                icon: 'error',
                title: this.lang.error,
                showConfirmButton: false,
                timer: 1000
              });
            }
          })

        }
      })
    },

    deleteOrder(order,index){
       Swal.fire({
        title: this.lang.warn_del,
        icon: 'error',
        reverseButtons: true,
        showCancelButton: true,

      }).then((result) => {
        if (result.isConfirmed) {
          let data = {action: "delete", id: order.id, status: order.status};

          if(!this.temp_send){ return false }
          this.temp_send = false;

          axios.post("/api/order", data).then(resp=>{
            this.temp_send = true;

            // console.log(resp);
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

    addLocalOrder(){
      if(this.order_local){
        let data = {data: this.order_local.detail, action: "setOrderLocal"};

        if(!this.temp_send){ return false }
        this.temp_send = false;

        axios.post("/api/order", data).then(resp => {
          this.temp_send = true;

          // console.log(resp);
          if(resp.data.status == 'done'){
            localStorage.removeItem("order_info")
            localStorage.removeItem("order_detail")

            this.response.order[0] = resp.data.data[0];
          }
        })
      }
    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },
    setDate(date_iso){
      let date = new Date(date_iso);
       return date.toLocaleString("es-CL");
    },

    change_lang(){
      // fot setting lang
      let lg = this.$root.lang;
      if(lg == "ar"){
        this.lang = this.lang_db.ar;
        this.lang.lg = lg;
        $(".orders").addClass("text-right");
        // console.log($(".dropdown-menu"))

      }else if(lg == "fr"){
        this.lang = this.lang_db.fr;
        $(".orders").removeClass("text-right");

      }else{
        this.lang = this.lang_db.en;
        $(".orders").removeClass("text-right");
      }
    },

    after(){
      this.change_lang();

      if(this.$root.login == false){

        Swal.fire({
          title: this.lang.warn_login_title,
          text: this.lang.warn_loign_text,
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

      }else{
        this.getData();
      }


    }
  },
  mounted: function() {
    if(this.$root.render == true) {this.after(); }

    // show top navbar
    this.$root.top_nav = true;


    // for local order Item
    let order_info = localStorage.getItem("order_info"),
        order_detail = localStorage.getItem("order_detail");

    if(order_info && order_detail){
      this.order_local = {
        info: JSON.parse(order_info),
        detail: JSON.parse(order_detail)
      };
    }


  },
  watch: {
    '$root.render': function(){ this.after(); },
    '$root.lang'  : function(){ this.change_lang()},
  }
};
</script>

