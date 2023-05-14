<template>
  <div class="print">
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
            <p class="user-name"><span>Nome: </span>{{data.order.store_info.name}}</p>
            <p class="user-addr"><span>Address: </span>{{data.order.store_info.address}}</p>
          </div>
        </div>

        <table class="table table-bordered">

          <!-- table body -->
          <tbody>
            <tr class="head-row">
              <th v-for="(col) in data.th" :key="col">{{ col }}</th>
            </tr>
            <tr class="elem-row" v-for="(row, index) in data.tb" :key="index">
              <td class="index">{{index+1}}</td>
              <td class="name">{{row.product.name}}</td>
              <td class="goute">
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

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "PrintOrder",
  props: [
    'data',
  ],
  data: function(){
    return {

    }
  },
  methods: {
    setNumber(num){
      return Number(num).toLocaleString("fi-FI", { minimumFractionDigits: 2 }) ;
    },
    setDate(date_iso){
      let date = new Date(date_iso);
       return date.toLocaleString("es-CL");
    },
  }
}
</script>
