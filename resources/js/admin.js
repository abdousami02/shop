/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import { createApp } from "vue";
import router from "./router/admin";
import store from "./store";

// includes
import Admin from "./Admin.vue";

createApp(Admin).use(store).use(router).mount("#admin");
