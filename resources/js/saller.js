
import { createApp } from "vue";
import router from "./router/saller";
import store from "./store";

import {Bootstrap5Pagination}  from 'laravel-vue-pagination';

require('./bootstrap');

// includes
import Saller from "./Saller.vue";

const app = createApp(Saller);

app.component('pagination', Bootstrap5Pagination);

app.use(store);
app.use(router);
app.mount("#saller");
