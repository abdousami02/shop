<template>
  <div class="contact content">
    <div class="container">
      <div class="logo">
        <div class="image"><img src="/favicon.ico" alt="logo"></div>
        <h4>Badni Shop</h4>
      </div>
      <div class="info">
        <div class="en" v-if="false">
          <h5>About Us</h5>
          <p>Wholesale Products General foodstuffs for suppermaket and Shops, have service delevery</p>
        </div>

        <div class="fr" v-if="false">
          <h5>About Us</h5>
          <p>Wholesale Products General foodstuffs for suppermaket and Shops, have service delevery</p>
        </div>

        <div class="ar">
          <h5>من نحن</h5>
          <p>بيع المنتجات بالجملة لأصحاب المحلات التجارية ، ويتوفر على خدمة التوصيل </p>
        </div>
      </div>

      <div class="mobile">
        <i class="fas fa-mobile-android-alt icon"></i>
        <p class="value"><a href="#" @click="copy">0556581171</a></p>
      </div>

      <div class="email">
        <i class="fal fa-envelope icon"></i>
        <div class="value">
          <p><a href="#" @click="copy">contact@badnishop.com</a></p>
          <p><a href="#" @click="copy">badnishop02@gmail.com</a></p>
        </div>
      </div>
    </div>
    <p ref="test"></p>
  </div>
</template>

<script>
import forme from "../../components/shop/form.vue";
export default {
  name: "contact-page",
  data: function () {
    return {
      ssd: "34",
    };
  },
  components: {
    forme,
  },
  methods: {
    sendsms(){
      const options = {
        method: 'POST',
        url: 'https://auth.routee.net/oauth/token',
        params: {grant_type: 'client_credentials'},
        headers: {
          accept: 'application/json',
          Authorization: 'Basic {NjQyMDJiNTIxNWU5YTQwMDAxMzhiNDQ2OjhXNmZuSnZLUXE=}',
          'Content-Type': 'application/x-www-form-urlencoded'
        }
      };

      axios.request(options).then(function (response) {
        // console.log(response.data);
      })
      .catch(function (error) {
        console.error(error);
      });
    },

    copy(elem){
      // console.log(this.$refs.test);

      const storage = document.createElement('textarea');
      storage.value = elem.target.text;
      this.$refs.test.appendChild(storage);
      storage.select();
      storage.setSelectionRange(0, 99999);
      document.execCommand('copy');
      this.$refs.test.removeChild(storage);

      Toast.fire({
        icon: 'success',
        title: 'تم النسخ الى الحافظة'
      })
    }
  }
};
</script>
