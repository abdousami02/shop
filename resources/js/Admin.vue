<template>
  <navbar v-show="!show_print"  />
  <router-view v-show="!show_print"  />
  <footers v-show="!show_print"  />

  <div :class="['print', method_print]"  v-if="show_print">
    <div class="container-lg">
      <div class="header">

        <div class="logo">
          <div class="image"><img src="/favicon.ico" alt=""></div>
          <h4>Badni Shop</h4>
        </div>

        <div class="info">
          <p class="mobile"><span>No Tel: </span>{{data.mobile}}</p>
          <p class="email"><span>Email: </span>{{data.email}}</p>
          <p class="link"><span>Web site: </span> badnishop.com </p>
        </div>
      </div>
      <hr>
      <div class="content" v-if="data.order.store_info">
        <div class="info">
          <div class="row-info">
            <p class="date"><span>Date: </span>{{data.date}}</p>
            <p class="num-order"><span>No Bone: </span>{{data.order.id}}</p>
            <p class="num-product"><span>Produit: </span>{{data.order.num_product}}</p>
            <p class="weight"><span>Poids: </span>{{data.order.weight}} <span>Kg</span></p>
          </div>
          <div class="row-info">
            <p class="user-id"><span>Client No: </span>{{data.order.store_id}}</p>
            <p class="user-name"><span>Nome: </span>{{data.order.store_info.name}}</p>
            <p class="user-addr"><span>Address: </span>{{data.order.store_info.address}}</p>
          </div>
        </div>

        <table class="table table-bordered">

          <!-- table body -->
          <tbody>
            <tr class="head-row">
              <th>No</th>
              <th>Nome Product</th>
              <th v-if="!method_print == 'mobile'">Goute</th>
              <th>Qte</th>
              <th>Prix_U</th>
              <th>Prix_Total</th>
            </tr>
            <tr class="elem-row" v-for="(row, index) in data.tb" :key="index">
              <td class="index">{{index+1}}</td>
              <td class="name">{{row.product.name}}</td>
              <td class="goute" v-if="!method_print == 'mobile'">
                <p v-for="elem in row.order_detail_goute" :key="elem">
                  <span class="goute">{{elem.product_goute.goute}}: </span>{{elem.qte}}
                </p>
              </td>
              <td class="qte">{{row.qte}}</td>
              <td class="price-u">{{setNumber(row.price_sell)}}</td>
              <td class="price-total">{{setNumber(row.price_total)}}</td>
            </tr>
          </tbody>
        </table>
        <div class="amount"><span>Total: </span>{{setNumber(data.order.amount)}} DA</div>

        <button class="btn btn-danger" v-if="method_print == 'mobile' & show_btn" @click="showOrigin">Canccel</button>
        <button class="btn btn-success ms-3" v-if="method_print == 'mobile' & show_btn" @click="printMobile"><i class="fal fa-print"></i> Print</button>
      </div>
    </div>
  </div>


</template>

<script>
import navbar from "./components/NavBar.vue";
import footers from "./components/footer.vue";
import { toHandlers } from 'vue';

export default {
  name: 'Admin',
  data: function(){
    return {
      show_print: false,
      method_print: '',
      show_btn: true,
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
  },
  methods: {
    printOrder(id, method){
      let date = new Date();
      this.data.date = date.toLocaleString("es-CL");

      let action = 'getDataPrint';
      axios.post("/api/admin/order_detail?page=1", {action: action, order_id: id}).then(response =>{

        console.log(response);
        this.method_print = method;
        this.data.order = response.data.order;
        this.data.tb = response.data.order_detail;
        this.show_print = true;
        console.log(this.data)
        if(this.data.order && this.method_print != 'mobile'){
          setTimeout(e=>{
            window.print();
            setTimeout(e=>{this.show_print = false;}, 800)
          }, 100);
        }
      });

      // axios.post("/api/admin/order", {action: 'getData', id: id}).then(response =>{
      //   console.log(response);
      //   this.data.order = response.data.data[0];
      // })

    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },
    setDate(date_iso){
      let date = new Date(date_iso);
       return date.toLocaleString("es-CL");
    },
    showOrigin(){
      this.show_print = false;
    },
    printMobile(){
      this.show_btn = false;
      setTimeout(e=>{
        window.print();
        setTimeout(e=>{this.show_btn = true;}, 800)
      }, 100);
    }
  }
};
</script>
