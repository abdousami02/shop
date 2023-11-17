<template>
  <div class="dash">
    <h3 class="head-sett">Dashboard</h3>
    <div class="order-card dash-card">
      <div class="head-card">
        <i class="far fa-shopping-cart fa-lg head-icon"></i>
        <h5 class="head-txt">Orders</h5>
      </div>
      <div class="body-card">
        <ul class="info">
          <li class="spb">Totale <span class="value">20</span></li>
          <li class="spb">Complet: <span class="value">18</span></li>
          <li class="spb">Processing: <span class="value">1</span></li>
          <li class="spb">Cancelled: <span class="value">1</span></li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "DashboardSetting",
};
</script>

<style lang="scss">
.head-sett {
  margin-top: 10px;
  margin-bottom: 35px;
}
.dash {
  .dash-card {
    margin: 5px;
    border: 1px solid #bbb;
    border-radius: 5px;
    background: #fff;
    max-width: 400px;
    .head-card {
      padding: 5px 10px;
      border-bottom: 1px solid #bbb;
      .head-icon {
        color: #bbb;
        margin-right: 13px;
      }
      .head-txt {
        display: inline-block;
        margin-bottom: 0;
        font-size: 18px;
        font-weight: 500;
      }
    }
    .body-card {
      padding: 20px;
      .spb {
        width: 150px;
        margin-top: 10px;
      }
    }
  }
}
</style>
