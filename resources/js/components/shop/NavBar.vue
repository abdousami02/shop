<template>
  <div class="navbar navbar-expand-lg">
    <div class="container">
      <router-link to="/" class="navbar-brand logo" href="#">
        <img src="/logo.png" alt="logo" style="width: 40px" />
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
              <li><router-link to="/setting" class="dropdown-item" href="#">Setting</router-link></li>
              <li class="dropdown-divider"></li>
              <li><router-link to="/login" class="dropdown-item" href="#">Log in</router-link></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<style lang="scss">

$br: 5px;
$srch-back: #ccc;
$main-back: #ccc;

.navbar {
  background: #fff;

  .container {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    margin: auto;
    text-align: center;
    align-items: unset !important;

    .search-links {
      display: flex;
      flex-direction: column-reverse;
      justify-content: space-between;
      flex-basis: 70%;
      // align-items: center;

      .search-bar {
        min-height: 40px;
        // width: 450px;
        display: flex;
        // border: 1px solid #000;
        border-radius: $br;
        background: $srch-back;
        margin-right: 20px;
        flex-basis: 60%;

        input {
          // width: calc(100% - 16px);
          flex-grow: 1;
          width: 100%;
          outline: none;
          border: none;
          margin-left: $br;
          background: inherit;
        }
        .drop {
          .form-select {
            width: 110px;
            height: 100%;
            padding: 0 25px 0 7px;
            border: none;
            border-left: 1px solid #ccc;
            border-radius: 0;
            background-color: inherit;
            &:focus {
              box-shadow: none;
            }
          }
          .drop-cat {
            display: flex;
            align-items: center;
            width: 130px;
            height: 100%;
            text-decoration: none;
            color: #444;
            padding: 0 10px;
            border-left: 1px solid #ddd;
            span {
              width: 100%;
            }
          }
          ul {
            padding: 0;
            margin: 0;
            li a {
              text-decoration: none;
            }
          }
        }
        button {
          background: $main-back;
          color: #fff;
          padding: 0 10px;
          border: none;
          border-radius: 0 $br $br 0;
          cursor: pointer;
        }
      }

      .dropdown-divider {
        width: 80%;
        margin: auto;
      }
    }

    .navbar-nav {
      flex-direction: row;
      margin: 15px 0;

      .nav-item {
        flex: 1 0 0%;
        min-width: 100px;

        .nav-link {
          color: #103262;
          border-radius: 17px;
          white-space: nowrap;
          &.router-link-exact-active {
            color: #fff;
            padding: 8px 10px;
            background: #103262;
          }
        }
      }
      // dorpdonw in nav of account an setting
      .dropdown-menu {
        position: absolute !important;
      }
    }
  }
}

@media (min-width: 992px) {
  .navbar {
    .container {
      flex-direction: row;
      align-items: center !important;

      .search-links {
        flex-direction: row-reverse;
        align-items: center;
      }
    }
  }
}
</style>

<script>
var categorie = ["Alimantaion", "boisson", "cosmitique", "detergent"];
export default {
  data: function () {
    return {
      categ: categorie,
    };
  },
  name: "nav-bar",
  props: categorie,
};
</script>
