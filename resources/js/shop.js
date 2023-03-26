
import { createApp } from "vue";
import router from "./router/shop";
import store from "./store";

import {Bootstrap5Pagination}  from 'laravel-vue-pagination';

require('./bootstrap');


import Shop from "./Shop.vue";

const app = createApp(Shop);

app.component('pagination', Bootstrap5Pagination);

app.use(store);
app.use(router);
app.mount("#shop");


// createApp(Shop).use(store).use(router).mount("#shop");
