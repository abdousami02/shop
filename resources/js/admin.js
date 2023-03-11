/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// import $ from 'jquery';
require('./bootstrap');

import { createApp } from "vue";
import router from "./router/admin";
import store from "./store";

import {Bootstrap5Pagination}  from 'laravel-vue-pagination';

// includes
import Admin from "./Admin.vue";

const app = createApp(Admin);

app.component('pagination', Bootstrap5Pagination);

app.use(store);
app.use(router);
app.mount("#admin");
