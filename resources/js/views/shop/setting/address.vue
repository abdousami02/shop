<template>
  <div class="address">
    <h3 class="head-sett">Address</h3>
    <div class="content">

      <div class="card">
        <div class="card-header">
          <h4>Address 1</h4>
        </div>
        <div class="card-body">
          <div class="">
            <h5>Adem Shop</h5>
            <p>Yarmoul laboid medjaja, chlef, Algeria</p>
          </div>
          <div class="opt-btns dropdown">
              <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown"></i>
              <div class="dropdown-menu dropdown-menu-end">
                    <!-- <router-link :to="'/orders/orderDetails?order_id='+order.id" href="/orders/orderDetails?order_id=" class="dropdown-item"><i class="far fa-pen"></i> add</router-link> -->
                    <a class="dropdown-item"><i class="far fa-pen"></i> edit</a>
                    <a class="dropdown-item" @click="deleteOrder(order,index)"><i class="far fa-trash"></i> delete</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'address-setting',
  data: function() {
    return {

    }
  }
}
</script>

