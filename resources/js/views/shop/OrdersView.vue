<template>
  <div class="orders">
    <div class="container">
      <!-- <nav class="nav-links my-2">
        <a href="#" class="linkd">Home</a> /<a href="#" class="linkd">Orders</a> /
        <a href="#" class="linkd">No: 434</a>
      </nav> -->
      <!-- search add edit -->
      <h4 class="mt-4">Orders:</h4>
      <div class="opt-order">
        <div class="btn-opt mb-2">
          <button class="btn btn-success btn-sm" @click="addOrder()"><i class="far fa-plus"></i> Add</button>
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
        <table class="table table-bordered table-hover tab-pc" v-if="false">
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
        </table>

        <!-- table for mobile -->
        <table class="table table-bordered tab-mobile">
          <thead>
            <tr>
              <th class="select-all"></th>
              <th class="">Info</th>
              <th class="">Totale</th>
              <th class="opt"></th>
            </tr>
          </thead>
          <tbody>
            <tr :class="['item', order.id == 'local' ? 'local' : '']" v-for="(order, index) in response.order" :key="order">

              <td class="select">
                <input type="checkbox" name="select" />
              </td>
              <td class="info">
                <div class="num ">Number: <span class="value">{{order.id}}</span></div>
                <div class="status">Status: <span class="value">{{order.status}}</span></div>
                <div class="date">date: <span class="value">{{setDate(order.created_at)}}</span></div>
                <p class="local-order" v-if="order.id == 'local' ">
                  This Order not register<button @click="addLocalOrder" class="btn btn-success">Add</button>
                </p>
              </td>
              <td class="price">
                <div class="num-prod ">Products :<span class="value">{{order.num_product}}</span></div>
                <div class="poid">Poid: <span class="value">{{order.weight || 0}} Kg</span></div>
                <div class="prix-t">Montant: <span class="value">{{setNumber(order.amount)}} DA</span></div>
              </td>
              <td class="opt dropdown">
                <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown"></i>
                <div class="dropdown-menu dropdown-menu-end">
                  <router-link to="/orders/orderDetails" href="#" class="dropdown-item"><i class="far fa-pen"></i> edit</router-link>
                  <a class="dropdown-item" @click="deleteOrder(order.id,index)"><i class="far fa-trash"></i> deleat</a>
                  <a class="dropdown-item"><i class="far fa-money-check-edit-alt"></i> checkout</a>
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
      response: {},
      order_local: '',
    }
  },
  methods: {
    getData(page=1){
      let data = {action: "getData"}
      axios.post("/api/order?page"+page, data).then(response=>{
        console.log(response);
        this.response.order = response.data.data;

        if(this.order_local){
          this.response.order.unshift(this.order_local.info)
        }
      })
    },
    setFamille(){
      let data = {
        categorie_id: 1,
        name: 'pate',
        name_ar: "عجائن",
      }
      console.log(data);
      axios.post('api/famille', data).then(response=>{
        console.log(response);
      })
    },
    addOrder(){
       Swal.fire({
        title: 'Are you sure to Add Order!',
        icon: 'warning',
        reverseButtons: true,
        showCancelButton: true,

      }).then((result) => {
        if (result.isConfirmed) {

          axios.post("/api/order", {action: "add"}).then(resp=>{
            console.log(resp);
            if(resp.data.status == 'done'){
              this.response.order.unshift(resp.data.data)

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

    deleteOrder(id,index){
       Swal.fire({
        title: 'Are you sure to Delete Order!',
        icon: 'error',
        reverseButtons: true,
        showCancelButton: true,

      }).then((result) => {
        if (result.isConfirmed) {

          axios.post("/api/order", {action: "delete", id: id}).then(resp=>{
            console.log(resp);
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

        axios.post("/api/order", data).then(resp => {
          console.log(resp);
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
  },
  mounted: function() {
    if(this.$root.render == true && this.$root.login == true){ this.getData(); }

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
    '$root.render': function(){
      if(this.$root.login == true){
        this.getData();
      }
    }
  }
};
</script>

