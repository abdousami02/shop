<template>
  <tr class="item">
    <td>
      <div class="select"><input type="checkbox" name="select" /></div>
    </td>
    <td>
      <p class="num spb">Number: <span class="value">323</span></p>
      <div class="stat spb">Status: <span class="value">Pending</span></div>
      <p class="date">date: <span class="value">02/01/2023-12:44</span></p>
    </td>
    <td>
      <div class="prix">
        <div class="num-prod spb">Products :<br /><span class="value">45</span></div>
        <div class="poid spb">Poid: <span class="value">1453Kg</span></div>
        <div class="prix-t">Montant: <span class="value">14563,00</span></div>
      </div>
    </td>
    <td>
      <div class="opt dropdown">
        <i class="fas fa-ellipsis-v dot-opt show" data-bs-toggle="dropdown"></i>
        <div class="dropdown-menu dropdown-menu-end">
          <router-link to="/orders/orderDetails" href="#" class="dropdown-item">edit</router-link>
          <a href="#" class="dropdown-item">deleat</a>
          <a href="#" class="dropdown-item">checkout</a>
        </div>
      </div>
    </td>
  </tr>
</template>

<script>
export default {
  name: "OrderItem",
};
</script>

<style lang="scss">
.prix .prix-t {
  background: rgb(13 202 240 / 38%) !important;
}
</style>
