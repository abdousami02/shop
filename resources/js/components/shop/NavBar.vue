<template>
  <div class="navbar navbar-expand-lg">
    <div class="container">
      <router-link to="/" class="navbar-brand logo" href="#">
        <img src="/favicon.ico" alt="logo" style="width: 40px" />
        Badni Shop
      </router-link>
      <div class="search-links">
        <!-- <div class="search-bar">
          <input type="text" class="serch-inp" name="serch" placeholder="Search" />
          <div class="drop">
            <select class="form-select form-select-sm" aria-label="Default select example">
              <option selected disabled style="display: none">Categorie</option>
              <option>All</option>
              <option v-for="(cat, index) in categ" :key="index">{{ cat }}</option>
            </select>
          </div>
          <button><i class="far fa-search"></i></button>
        </div> -->
        <ul class="navbar-nav">
          <div class="d"></div>
          <li class="nav-item">
            <router-link to="/store" class="nav-link active" href="#">
              <i class="fal fa-store fa-lg"></i>
              {{lang.store}}
            </router-link>
          </li>
          <li class="nav-item" style="flex-basis: 4%">
            <router-link to="/promotion" class="nav-link" href="#">
              <i class="fal fa-badge-percent fa-lg"></i>
              {{lang.promo}}
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/orders" class="nav-link" href="#">
              <i class="far fa-shopping-cart fa-lg"></i>
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a data-bs-toggle="dropdown" href="#" class="nav-link dropdown-toggle dropdown-toggle-split" aria-expanded="false">
              <i class="far fa-user fa-lg"></i>
            </a>
            <div :class="['dropdown-menu', lang.lg == 'ar' ? '': 'dropdown-menu-end']" ref="drop">
              <a v-if="$root.login" >
                <span>{{$root.user.name}}</span><br>
                <span>mobile: {{'0'+$root.user.mobile}}</span>
              </a>
              <a v-if="$root.login" class="dropdown-divider"></a>
              <a v-if="$root.login"><router-link to="/setting" class="dropdown-item" href="#">{{lang.setting}}</router-link></a>
              <a v-if="$root.login" @click.prevent="logout"><a class="dropdown-item" href="#">{{lang.logout}}</a></a>
              <a v-if="!$root.login"><router-link to="/login" class="dropdown-item" href="#">{{lang.login}}</router-link></a>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "nav-bar",
  data: function () {
    return {
      user:'',
      lang_db: {
        en: { store: "Store", promo: "Discount", setting: "Setting", logout: "Log Out", login: "Log In" },
        fr: { store: "Magasin",promo: "Promotion", setting: "Parametre", logout: "Déconnexion", login: "Connexion" },
        ar: { store: "متجر", promo: "تخفيضات", setting: "إعدادات", logout: "خروج", login: "دخول" },
      },
      lang: {},
    };
  },
  methods: {
    logout(){
      axios.post("/api/auth/logout").then(resp =>{
        this.$root.user = {};
        this.$root.login = false;
        document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/";
        this.$router.push({ path: "/" });
      });
    },
    change_lang(){
      let lg = this.$root.lang;
      if(lg == "ar"){
        this.lang = this.lang_db.ar;
        this.lang.lg = lg
        $(".dropdown-menu").css("text-align", "right");

      }else if(lg == "fr"){
        this.lang = this.lang_db.fr;
        $(".dropdown-menu").css("text-align", "");

      }else{
        this.lang = this.lang_db.en;
        $(".dropdown-menu").css("text-align", "");
      }
    }
  },
  mounted: function(){
    this.change_lang();
  },
  watch: {
    '$root.lang': function(){this.change_lang();},
  }

};
</script>
