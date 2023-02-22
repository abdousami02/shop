<template>
  <div class="all-categ">
    <div class="container">
      <div class="title">
        <h3>Categories</h3>
      </div>
      <ul class="content">
        <li class="item">
          <a href="#">
            <div class="icon">
              <img src="img/shop.png" alt="." />
            </div>
            <span class="name">Alimantation</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <div class="icon">
              <img src="img/perfume.png" alt="." />
            </div>
            <span class="name">Cosmitique</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <div class="icon">
              <img src="img/basket.png" alt="." />
            </div>
            <span class="name">Detergent</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <div class="icon">
              <img src="img/drink.png" alt="." />
            </div>
            <span class="name">Boisson</span>
          </a>
        </li>
        <li class="item">
          <a href="#">
            <div class="icon">
              <img src="img/snow.png" alt="." />
            </div>
            <span class="name">Frois</span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "AllCateg",
};
</script>

<style lang="scss">
.all-categ {
  margin-top: 60px;

  .title {
    margin: 0 20px;
  }

  .content {
    background: #fff;
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    border-radius: 13px;

    .item a {
      display: flex;
      flex-direction: column;
      align-items: center;
      color: #103262;
      text-decoration: none;
      padding: 20px 10px;

      .icon {
        width: 100px;
        border: 3px solid #103262;
        padding: 14px;
        border-radius: 50%;
      }
      .name {
        font-size: 18px;
        margin-top: 10px;
      }
    }
  }
}
@media (max-width: 992px) {
  .all-categ .item {
    flex-basis: 33%;
  }
}
</style>
