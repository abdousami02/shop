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
              Store
            </router-link>
          </li>
          <li class="nav-item" style="flex-basis: 4%">
            <router-link to="/promotion" class="nav-link" href="#">
              <i class="fal fa-badge-percent fa-lg"></i>
              Promotion
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/orders" class="nav-link" href="#">
              <i class="far fa-shopping-cart fa-lg"></i>
            </router-link>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="far fa-user fa-lg"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><router-link to="/dashboard" class="dropdown-item" href="#">Setting</router-link></li>
              <li class="dropdown-divider"></li>
              <li><a @click.prevent="logout" class="dropdown-item" href="#">Log out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function () {
    return {

    };
  },
  name: "nav-bar",
  methods: {
    logout(){
      axios.post("/api/auth/logout").then(resp =>{
        this.$root.user = {};
        this.$root.login = false;
        document.cookie= "token=" + '' + "; expires=Thu, 18 Dec 2021 12:00:00 UTC; path=/";
        this.$router.push({ path: "/" });
      });
    }
  }
};
</script>


