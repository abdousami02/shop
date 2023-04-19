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
import PrintOrder from "./components/printOrder.vue";
import { toHandlers } from 'vue';

export default {
  name: 'Admin',
  data: function(){
    return {
      show_print: false,
      data: {
        mobile: '0556581171',
        email: 'contact@badnishop.com',
        date: '',
        th: ['No', 'Nome Produit', 'Goute', 'Qte', 'Prix_U', 'Prix_Total'],
        tb: {},
        order: null,
      },
      user: {},
      login: false,
    }
  },
  components: {
    navbar,
    footers,
    PrintOrder,
  },
  methods: {
    printOrder(id){
      let date = new Date();
      this.data.date = date.toLocaleString("es-CL");

      let action = 'getDataPrint';
      axios.post("/api/admin/order_detail?page=1", {action: action, order_id: id}).then(response =>{

        console.log(response);
        this.data.order = response.data.order;
        this.data.tb = response.data.order_detail;
        this.show_print = true;
        console.log(this.data)
        if(this.data.order){
          setTimeout(e=>{window.print();this.show_print = false;}, 1000);
        }
      });

      // axios.post("/api/admin/order", {action: 'getData', id: id}).then(response =>{
      //   console.log(response);
      //   this.data.order = response.data.data[0];
      // })

    }
  }
};
</script>
