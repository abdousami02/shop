<template>
  <navbar v-show="!show_print"  />
  <router-view v-show="!show_print"  />
  <footers v-show="!show_print"  />

  <print-order v-if="show_print" :data="data">

  </print-order>

</template>

<script>
import navbar from "./components/NavBar.vue";
import footers from "./components/footer.vue";
import PrintOrder from "./components/printOrderSaller.vue";

export default {
  name: 'Saller',
  data: function(){
    return {
      show_print: false,
      data: {
        saller: {},
        date: '',
        thead: ['No', 'Nome Produit', 'Goute', 'Qte', 'Prix_U', 'Prix_Total'],
        tbody: {},
        order: null,
      },
      lang: '',
      user: {},
      login: '',
      render: false,
    }
  },
  components: {
    navbar,
    footers,
    PrintOrder,
  },
  methods: {
    printOrder(order){
      if(order.status < 3){
          Swal.fire({
            title: 'Must be update price',
            text: "يجب رفع التعديلات للمسؤول",
            icon: 'warning',
            confirmButtonText: 'OK'
          })

      }else{
        let date = new Date();
        this.data.date = date.toLocaleString("es-CL");

        let action = 'getDataPrint';
        axios.post("/api/saller/order_detail?page=1", {action: action, order_id: order.id}).then(response =>{

          console.log(response);
          this.data.order = response.data.order;
          this.data.saller = response.data.saller;
          this.data.tbody = response.data.order_detail;
          this.show_print = true;
          // console.log(this.data)
          if(this.data.order){
            setTimeout(e=>{window.print();this.show_print = false;}, 100);
          }
        });
      }

    },
    // check login
    check_login(){
      axios.post('/api/auth/refresh?permition=saller').then(response=>{
        console.log('login');
        this.login = true;
        this.user = response.data.user_info;
        document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/"
        document.cookie= "token=" + response.data.access_token + "; expires=Thu, 18 Dec 2023 12:00:00 UTC; path=/"
        this.render = true;

      }).catch(error => {
        if(error.response.data.message == "Unauthenticated."){
          console.log('not login');
          this.$root.user = {};
          this.login = false;
          document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/";
          this.render = true;
        }
      });
    },
    change_lang(){
      if(this.lang == "ar"){
        $("body").attr("dir", "rtl");
        localStorage.setItem("lang", this.lang)

      }else{
        localStorage.setItem("lang", this.lang)
        $("body").attr("dir", "")
      }
    },
  },
  mounted: function(){
    let lang = localStorage.getItem("lang");
    if(lang){
      this.lang = lang;
    }
    this.check_login();
    // this.change_lang();

  },
  watch: {
    // lang(){
    //   this.change_lang();
    // }
  }
};
</script>
