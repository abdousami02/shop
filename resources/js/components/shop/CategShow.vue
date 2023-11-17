<template>
  <div class="categ">
    <div class="container">
      <div class="title">
        <span class="icon" v-html="iconCat"></span>
        <h3>{{ nameCat }}</h3>
      </div>
      <div class="content">
        <a href="#" class="item" v-for="(pr, index) in prod" :key="index">
          <div class="image"><img :src="pr.img" alt="." /></div>
          <div class="info">
            <p class="name mb-0" v-text="pr.name"></p>
            <div class="price">{{ pr.price }} DA</div>
            <div class="unit"><span v-text="pr.unit"></span> <sub>Unit/Cart</sub></div>
          </div>
        </a>
      </div>
    </div>
  </div>
</template>

<script>
var producte = {
  0: {
    name: "Sol margarin 500G",
    price: 198,
    unit: 24,
    img: "/img/sol2.jpg",
  },
  1: {
    name: "noor mayounais 450ml",
    price: 195,
    unit: 12,
    img: "/img/noor.jpg",
  },
  2: {
    name: "assila mordjan 1Kg",
    price: 160,
    unit: 12,
    img: "/img/mordjan.jpg",
  },
  3: {
    name: "cevital skor 1Kg",
    price: 87,
    unit: 10,
    img: "/img/skor2.png",
  },
  4: {
    name: "cafe famico 250G",
    price: 208,
    unit: 20,
    img: "/img/famico.jpg",
  },
  5: {
    name: "Loya lait 500G",
    price: 540,
    unit: 12,
    img: "/img/loya.jpg",
  },
  6: {
    name: "Sol margarin 500G",
    price: 198,
    unit: 24,
    img: "/img/sol2.jpg",
  },
  7: {
    name: "noor mayounais 450ml",
    price: 195,
    unit: 12,
    img: "/img/noor.jpg",
  },
  8: {
    name: "assila mordjan 1Kg",
    price: 160,
    unit: 12,
    img: "@/assets/image/mordjan.jpg",
  },
};

export default {
  name: "CategHome",
  props: {
    nameCat: String,
    iconCat: String,
  },
  data: function () {
    return {
      prod: producte,
    };
  },
};
</script>

<style lang="scss">
.categ {
  padding: 40px 0;
  .title {
    margin: 0 20px;
    .icon {
      font-size: 28px;
      margin-right: 15px;
    }
    h3 {
      display: inline-block;
    }
  }
  .content {
    background: #fff;
    padding: 10px;
    display: flex;
    justify-content: flex-start;
    overflow: hidden;
    border-radius: 13px;

    .item {
      min-width: 110px;
      padding: 10px;
      background: #eee;
      border-radius: 10px;
      margin: 0 7px;
      color: inherit;
      text-decoration: none;

      .image {
        height: 100px;
        overflow: hidden;
      }
    }

    .info {
      margin: 10px 0;
      .name {
        text-align: center;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* number of lines to show */
                line-clamp: 2;
        -webkit-box-orient: vertical;
      }
      .price {
        font-weight: 600;
        font-size: 20px;
        margin-top: 5px;
        text-align: center;
      }
      .unit {
        text-align: right;
      }
    }
    .shop {
      display: flex;
      justify-content: space-between;
      align-items: center;

      .qte {
        width: 40px;
        // -moz-appearance: textfield;
        &::-webkit-inner-spin-button {
          -webkit-appearance: none;
          margin: 0;
        }
      }
    }
  }
}
</style>
