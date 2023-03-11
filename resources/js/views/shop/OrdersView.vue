<template>
  <div class="orders">
    <div class="container">
      <nav class="nav-links">
        <a href="#" class="linkd">Home</a> /<a href="#" class="linkd">Orders</a> /
        <a href="#" class="linkd">No: 434</a>
      </nav>
      <!-- search add edit -->
      <div class="opt-order">
        <div class="btn-opt mb-2">
          <button class="btn btn-success btn-sm" @click="setInfo()"><i class="far fa-plus"></i> Add</button>
          <button class="btn btn-danger btn-sm ms-3" @click="getData()"><i class="far fa-times"></i> Delet</button>
        </div>
      </div>
      <!-- orders Lists -->
      <h4>Orders:</h4>
      <div class="orders-list">
        <!-- <div class="item">
          <p class="date">Created at:<br /><span class="value">02/01/2023-12:44</span></p>
          <p class="num">No: <span class="value">356</span></p>
          <p class="status">Status: <span class="value">Pending</span></p>
          <p class="montant">Montant: <span class="value">1853,00</span></p>
        </div> -->
        <!-- table for PC -->
        <table class="table table-bordered table-hover tab-pc">
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
              <td class="stat">Pending</td>
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
            <order />
            <order />
            <order />
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import $ from "jquery";
import order from "../../components/shop/item/OrderItem.vue";
export default {
  name: "OrdersView",
  components: {
    order,
  },
  methods: {
    getData(){
      let data = {
        name: "alimantaion",
        name_ar: "مواد غذائية",
      };
      console.log(data);
      axios.post('api/cat', data).then(response=>{
        console.log(response);
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
    setInfo(){
      let data = {
        categorie_id: 1,
        name: 'pate',
        name_ar: "عجائن",
      }
      console.log('send info')
      axios.post('api/info', data).then(response=>{
        console.log(response);
      })
    }
  },
  mounted: function() {
    // this.getData();
  }
};
</script>

<style lang="scss" scoped>
.orders-list {
  padding: 5px;
  p {
    margin-bottom: 5px;
  }
}
tbody > tr {
  cursor: pointer;
}
</style>
