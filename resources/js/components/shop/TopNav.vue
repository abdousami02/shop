<template>
  <div class="top-nav navbar-expand">
    <div class="container">
      <!-- box in left -->
      <ul class="box navbar-nav">
        <li class="lang dropdown me-4">
          <a href="#" class="d-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
            <i class="far fa-globe-africa"></i>
            {{lang.lang_sel}}
          </a>
          <ul class="dropdown-menu" @click="change_lang">
            <li><a class="dropdown-item" href="#" data-lang="ar">عربي</a></li>
            <li><a class="dropdown-item" href="#" data-lang="fr">Franch</a></li>
            <li><a class="dropdown-item" href="#" data-lang="en">English</a></li>
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
            <i :class="['fal fa-phone-volume me-2', lang.lg == 'ar' ? 'fa-flip-horizontal' :'' ]"></i>
            {{lang.contact}}
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
  data: function(){
    return {
      lang: {},
      lang_db: {
        ar: {lang_sel: "عربي", contact: "إتصل بنا"},
        fr: {lang_sel: "Français", contact: "contacte nous"},
        en: {lang_sel: "English", contact: "contact us"},
      },

    };
  },
  methods: {
    change_lang(e){
      let lang = $(e.target).attr('data-lang');
      console.log(lang)
      if(lang == "ar"){
        this.$root.lang = "ar";
        this.lang = this.lang_db.ar;
        this.lang.lg = lg;

      }else if(lang == "fr"){
        this.$root.lang = "fr";
        this.lang = this.lang_db.fr;

      }else if(lang == "en"){
        this.$root.lang = "en";
        this.lang = this.lang_db.en
      }
    },
  },
  mounted: function(){
    let lg = this.$root.lang;
    if(lg == "ar"){
      this.lang = this.lang_db.ar;
      this.lang.lg = lg;

    }else if(lg == "fr"){
      this.lang = this.lang_db.fr;

    }else{
      this.lang = this.lang_db.en
    }
  }
};
</script>

