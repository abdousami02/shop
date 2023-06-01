<template>
  <div class="anal">
    <div class="panel-anal">
      <h4 class="title">Total product Montant</h4>
      <div class="icon">

      </div>
      <div class="info">
        <table class="table">
          <thead>
            <tr>
              <th>name</th>
              <th>price buy</th>
              <th>qte stock</th>
              <th>total</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="elem in product" :key="elem">
              <th>{{elem.name}}</th>
              <td>{{elem.price_buy}}</td>
              <td>{{elem.qte_stock}}</td>
              <td>{{elem.total}}</td>
            </tr>
          </tbody>
        </table>
        <div class="total">Total: <span class="value">{{setNumber(mount)}}</span></div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AnalyticsDash",
  data: function (){
    return {
      mount: 0,
      product: [],
    }
  },
  methods: {
    getData (){
      axios.post("/api/admin/anal", {action: "getMontProduct"}).then(resp=>{
        console.log(resp);
        this.product = resp.data.product;
        this.mount = resp.data.mount;
      })
    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },
  },
  mounted: function(){
    this.getData();
  }
};
</script>
