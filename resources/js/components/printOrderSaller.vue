<template>
  <div class="print">
    <div class="container-lg">
      <div class="header">

        <div class="logo">
          <div class="image"><img src="/favicon.ico" alt=""></div>
          <h4>Badni Shop</h4>
        </div>

        <div class="info">
          <p class="email"><span>Nome: </span>{{data.saller.name}}</p>
          <p class="mobile"><span>No Tel: </span>{{data.saller.mobile}}</p>
          <p class="address"><span>Address: </span>{{data.saller.address}}</p>
        </div>
      </div>
      <hr>
      <div class="content" v-if="data.order">
        <div class="info">
          <div class="row-info">
            <p class="date"><span>Date: </span>{{data.date}}</p>
            <p class="num-order"><span>No Bone: </span>{{data.order.id}}</p>
            <p class="num-product"><span>Produit: </span>{{data.order.num_product}}</p>
            <p class="weight"><span>Poids: </span>{{data.order.weight}} <span>Kg</span></p>
          </div>
        </div>

        <table class="table table-bordered">

          <!-- table body -->
          <tbody>
            <tr class="head-row">
              <th v-for="(col) in data.thead" :key="col">{{ col }}</th>
            </tr>
            <tr class="elem-row" v-for="(row, index) in data.tbody" :key="index">
              <td class="index">{{index+1}}</td>
              <td class="name">{{row.product.name}}</td>
              <td class="goute">
                <p v-for="elem in row.order_detail_goute" :key="elem">
                  <span class="goute">{{elem.product_goute.goute}}: </span>{{elem.qte}}
                </p>
              </td>
              <td class="qte">{{row.qte}}</td>
              <td class="price-u">{{setNumber(row.price_buy)}}</td>
              <td class="price-total">{{setNumber(row.price_total)}}</td>
            </tr>
          </tbody>
        </table>
        <div class="amount"><span>Total: </span>{{setNumber(data.order.amount_buy)}} DA</div>

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
