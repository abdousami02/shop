<template>
  <div class="orders-details">
    <div class="container">
      <nav class="nav-links">
        <a href="#" class="linkd">Home</a> /<a href="#" class="linkd">Orders</a> /
        <a href="#" class="linkd">No: 434</a>
      </nav>
      <!-- search add edit -->
      <div class="opt-prod">
        <div class="btn-opt mb-2">
          <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#add-prod"><i class="far fa-plus"></i> Add</button>
          <button class="btn btn-danger btn-sm ms-3"><i class="far fa-times"></i> Delet</button>
        </div>
        <search />
      </div>
      <!-- start totale prix -->
      <div class="shop-prix">
        <h5>Totale :</h5>
        <div class="mon"><span class="value">1834,00</span><span class="cur"> DA</span></div>
      </div>
      <!-- add product -->
      <add-product />
      <!-- Porduct info -->
      <product />
      <!-- table -->
      <table class="table table-bordered tab-mobile">
        <thead>
          <tr>
            <th><span class="select-all"></span></th>
            <th class="name">name</th>
            <th class="q-u">Prix</th>
            <th class="opt"></th>
          </tr>
        </thead>
        <tbody>
          <item />
        </tbody>
      </table>
      <!-- start next and previes page -->
      <router-link to="/orders" href="/orders" class="submit btn btn-success">Save</router-link>
      <router-link to="/orders/checkout" href="/orders/checkout" class="submit btn btn-primary ms-2">Checkout</router-link>
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
import item from "../../components/shop/item/ProdOreder.vue";
import product from "../../components/shop/item/ProductInfo.vue";
import addProduct from "../../components/shop/item/AddProd.vue";
import search from "../../components/shop/item/SearchProd.vue";

export default {
  name: "OrdersDetails",
  components: {
    item,
    product,
    search,
    addProduct,
  },
  methods: {
    // dd
  },
};
</script>

<style lang="scss" scoped>
// producnt info
</style>
