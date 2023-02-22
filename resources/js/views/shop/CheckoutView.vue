<template>
  <div class="checkout">
    <div class="panel">
      <h3 class="head">Send Order</h3>
      <h4 class="ms-2">Info :</h4>
      <div class="head-order pan-info">
        <div class="info">
          <p class="num-order">Order No: <span class="value">3453</span></p>
          <p class="date-order">Date: <span class="value">22/01/2023</span></p>
          <p class="mon-order">Montant: <span class="value">143'565,32 DA</span></p>
          <p class="num-prod">Number of Products: <span class="value">62</span></p>
          <p class="poid mb-0">Poid: <span class="value">6'224 Kg</span></p>
        </div>
        <div class="btns">
          <button class="btn btn-primary">edit</button>
          <button class="btn btn-outline-info">Print</button>
        </div>
      </div>
      <h4 class="ms-2">Address :</h4>
      <div class="addr-order pan-info">
        <button class="btn btn-primary edt-addr">edit</button>
        <p class="name"><span>Name: </span><span class="value">Adam Shop</span></p>
        <p class="addr"><span>Address: </span><span class="value">Chlef, Laboid Medjaja, yarmoul</span></p>
        <p class="tel"><span>Telephon: </span><span class="value">0699423533</span></p>
      </div>
      <div class="btns-check">
        <router-link to="/orders" tag="button" class="btn btn-danger">Canccel</router-link>
        <button class="btn btn-success">Send Demmend</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "checkOut",
};
</script>

<style lang="scss">
.checkout .panel {
  .pan-info {
    padding: 15px;
    color: #333;
    font-size: 15px;
    border-radius: 10px;
    margin-bottom: 15px;
  }
  .head-order {
    background: rgba(255, 208, 68, 0.6);
    display: flex;
    justify-content: space-between;
    .info {
      flex-basis: 100%;
      max-width: 250px;
      margin-right: 23px;
      & > * {
        display: flex;
        justify-content: space-between;
      }
    }
  }
  .value {
    font-weight: 600;
    color: #000;
  }
  .btns {
    display: flex;
    flex-direction: column;
    .btn {
      width: 70px;
      margin-bottom: 7px;
    }
  }
  .addr-order {
    border: 1px solid #ccc;
    position: relative;
    overflow: hidden;
  }
  .edt-addr {
    float: right;
    width: 70px;
  }
  .btns-check {
    display: flex;
    justify-content: space-between;
    margin-top: 35px;
  }
}
</style>
