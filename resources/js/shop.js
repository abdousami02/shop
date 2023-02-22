require('./bootstrap');

import { createApp } from "vue";
import router from "./router/shop";
import store from "./store";

// includes
import Shop from "./Shop.vue";

createApp(Shop).use(store).use(router).mount("#shop");
