<template>
  <div class="checkout content">
    <div class="panel container">
      <h3 class="head">{{lang.head_send}}</h3>
      <h4 class="ms-2">{{lang.info_order}} :</h4>
      <div class="head-order pan-info">
        <p class="num-order">{{lang.order_id}}: <span class="value">{{order.id}}</span></p>
        <p class="date-order">{{lang.order_date}}: <span class="value">{{setDate(order.created_at)}}</span></p>
        <p class="num-prod">{{lang.order_product}}: <span class="value">{{order.num_product}}</span></p>
        <p class="poid mb-0">{{lang.order_weight}}: <span class="value">{{order.weight}} Kg</span></p>
        <p class="mon-order">{{lang.order_amount}}: <span class="value">{{setNumber(order.amount)}} DA</span></p>
      </div>
      <h4 class="ms-2">{{lang.address}} :</h4>
      <div class="addr-order pan-info">
        <button class="btn btn-primary edt-addr">{{lang.btn_edite}}</button>
        <p class="name"><span>{{lang.name}}: </span><span class="value">{{store_sel.name}}</span></p>
        <p class="addr"><span>{{lang.address}}: </span><span class="value">{{store_sel.address}}</span></p>
        <p class="tel"><span>{{lang.mobile}}: </span><span class="value">{{'0'+store_sel.mobile}}</span></p>
      </div>
      <div class="btns-check">
        <router-link to="/orders" class="btn btn-danger">{{lang.btn_canccel}}</router-link>
        <button class="btn btn-success" @click="sendOrder">{{lang.btn_send}}</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "checkOut",
  data: function(){
    return {
      order_id: '',
      user: '',
      order: {},
      store: [],
      store_sel: {},

      lang: {},
      lang_db: {
        ar: {head_send: "إرسال الطلب", info_order: "معلومات", order_id: "طلب رقم", order_date: "تاريخ", order_product: "المنتجات",
            order_weight: "الوزن", order_amount: "الإجمالي", address: "العنوان", name: "الإسم", mobile: "الهاتف",
            btn_send: "إرسال", btn_canccel: "إلغاء", btn_edite: "تعديل", msg_success: "تم الإرسال بنجاح"},

        fr: {head_send: "Envoyer Commande", info_order: "Informations", order_id: "commande ID", order_date: "Date", order_product: "Produit",
            order_weight: "Poids", order_amount: "Montant", address: "Adresse", name: "Nom", mobile: "Téléphone",
            btn_send: "Envoyer", btn_canccel: "Annuler", btn_edite: "modifier", msg_success: "Succès d'envoi la commande"},

        en: {head_send: "Send Order", info_order: "Order Info", order_id: "Order ID", order_date: "Date", order_product: "Product",
            order_weight: "Weight", order_amount: "Amount", address: "Address", name: "Name", mobile: "Mobile",
            btn_send: "Send", btn_canccel: "Canccel", btn_edite: "edit", msg_success: "Success send order"},
      }
    };
  },
  methods: {

    getData(){
      let data = {action: 'getData', order_id: this.order_id}
      axios.post("/api/order", data).then(response =>{
        // console.log(response)
        if(response.data.status == 'error'){
          this.back_to_order();

        }else{
          this.order = response.data[0];
        }
      })
    },
    getStoreInfo(){
      axios.post("/api/checkout", {action: "getStoreInfo"}).then(resp=>{
        // console.log(resp);
        if(resp.data.status == 'empty'){
          this.store = {name: 'not set'}

        }else if(resp.data.status == 'done'){
          this.store = resp.data.data;
          this.store_sel = resp.data.data[0];
        }
      })
    },
    sendOrder(){
      let data = {
        order_id: this.order_id,
        store_id: this.store_sel.id,
        action: "sendOrder",
      }
      axios.post("/api/checkout", data).then(resp=>{
        // console.log(resp);
        if(resp.data.status == 'error'){
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: "Have Error, '"+resp.data.message+"'!",
            })

        }else if(resp.data.status == 'done'){
          Swal.fire({
            title: this.lang.msg_success,
            // html: "Success send "+resp.data.data+" Order",
            icon: 'success',
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',

          }).then((result) => {
            if (result.isConfirmed) {
              this.back_to_order();
            }
          })
        }
      })
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
        $(".pan-info .edt-addr").attr("style", "float:left;");

      }else if(lg == "fr"){
        this.lang = this.lang_db.fr;
        $(".pan-info .edt-addr").attr("style", "");

      }else{
        this.lang = this.lang_db.en;
        $(".pan-info .edt-addr").attr("style", "");
      }
    },

    after(){

      let order_id = this.$route.query.order_id;

      if(this.$root.login == false){
        this.$router.push({name: "store"})

      }else if(order_id == 'undefined' || order_id == undefined){
        this.back_to_order();

      }else{
        this.order_id = order_id;
        this.getData(order_id);
        this.getStoreInfo();
        this.user = this.$root.user;
      }
      this.change_lang();
    },

    back_to_order(){
      this.$router.push({ path: "/orders" });
    },


  },
  mounted: function(){
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
  }
};
</script>

