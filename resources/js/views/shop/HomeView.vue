<template>
  <div class="home">
    <landing />
    <all-categ />
    <categ-show :nameCat="alim" :iconCat="alim_icon" />
    <categ-show :nameCat="bois" :iconCat="bois_icon" />
    <categ-show :nameCat="cos" :iconCat="cos_icon" />
  </div>
</template>

<script>
// @ is an alias to /src
import landing from "../../components/shop/landing.vue";
import AllCateg from "../../components/shop/categ.vue";
import CategShow from "../../components/shop/CategShow.vue";

export default {
  name: "HomeView",
  data: function () {
    return {
      alim: "Alimantation",
      alim_icon: '<i class="fal fa-shopping-basket"></i>',
      bois: "Boisson",
      bois_icon: '<i class="fal fa-wine-bottle"></i>',
      cos: "Cosmitique",
      cos_icon: '<i class="fal fa-gifts"></i>',
    };
  },
  components: {
    landing,
    CategShow,
    AllCateg,
  },
};
</script>
