<template>
  <div class="top-nav navbar-expand">
    <div class="container">
      <!-- box in left -->
      <ul class="box navbar-nav">
        <li class="lang dropdown me-4">
          <a href="#" class="d-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
            <i class="far fa-globe-africa"></i>
            English
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Arabic</a></li>
            <li><a class="dropdown-item" href="#">English</a></li>
            <li><a class="dropdown-item" href="#">Franch</a></li>
          </ul>
        </li>
        <li class="local dropdown">
          <a href="" class="d-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
            <i class="fal fa-map-marker-alt"></i>
            Chlef
          </a>
          <ul class="dropdown-menu">
            <li><a href="#" class="dropdown-item">Chlef</a></li>
            <li><a href="#" class="dropdown-item">Rilizan</a></li>
            <li><a href="#" class="dropdown-item">Ain Defla</a></li>
            <li><a href="#" class="dropdown-item">Mostaganem</a></li>
            <li><a href="#" class="dropdown-item">Oran</a></li>
          </ul>
        </li>
      </ul>
      <!-- end box in left -->
      <!-- box in right -->
      <ul class="box navbar-nav">
        <li class="about">
          <router-link to="/contact" href="#" class="d-link">
            <i class="fal fa-phone-volume me-2"></i>
            Contact
          </router-link>
        </li>
      </ul>
      <!-- end box in right -->
    </div>
  </div>
</template>

<script>
export default {
  name: "top-header",
};
</script>

<style lang="scss">
//vairable file
@import "../scss/global/variable";

.top-nav {
  background: $main-back;
  padding: 7px;
  .container {
    display: flex;
    justify-content: space-between;
    color: #fff;
  }
}
</style>
