<template>
  <div class="anal">
    <div class="panel-anal">

      <div class="icon">
        <div class="stock cart btn" @click="selBtn('stock')">Stock</div>
        <div class="binifice cart btn ms-2" @click="selBtn('binifice')">Binifice</div>
      </div>
      <div class="binifice" v-if="show_binifice">
        <table class="table">
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Order Date</th>
              <th>Number Cartone</th>
              <th>user</th>
              <th>Note</th>
              <th>amount</th>
              <th>binifice</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="elem in orders" :key="elem">
              <th>{{elem.id}}</th>
              <th>{{convert_date(elem.created_at)}}</th>
              <th>{{elem.num_cartone}}</th>
              <th><span class="text-bold me-2">{{}}</span><span></span>{{elem.user.mobile}}</th>
              <th>{{elem.note}}</th>
              <th>{{elem.amount}}</th>
              <th>{{elem.amount - elem.amount_buy}}</th>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="stock" v-if="show_stock">
        <h4 class="title">Total product Montant</h4>
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
            <tr v-for="elem in stock" :key="elem">
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
      stock: [],
      orders: [],
      show_binifice: false,
      show_stock: false,
    }
  },
  methods: {
    getStock(){
      axios.post("/api/admin/anal", {action: "getStock"}).then(resp=>{
        console.log(resp);
        this.stock = resp.data.stock;
        this.mount = resp.data.mount;
      })
    },
    getBinifice(){
      axios.post("/api/admin/anal", {action: "getOrderBinifice"}).then(resp=> {
        console.log(resp);
        if(resp.data.status == 'done'){
          this.orders = resp.data.data;
        }
      })
    },
    selBtn(elem){
      if(elem == 'stock'){
        this.show_stock = true;
        this.show_binifice = false;
        this.getStock();

      } else if(elem == 'binifice'){
        this.show_binifice = true;
        this.show_stock = false;
        this.getBinifice();
      }
    },
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },
    convert_date(date){
      const d = new Date(date);
      return d.toLocaleString("es-CL");
    },
  },
  mounted: function(){
    // this.getData();
  }
};
</script>
