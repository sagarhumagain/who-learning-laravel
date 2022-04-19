/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import { createApp } from 'vue'
import router from './router';
import store from './store';
import VueSidebarMenu from 'vue-sidebar-menu';
import Toast, { POSITION } from "vue-toastification";
import 'bootstrap';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
import "vue-toastification/dist/index.css";

const app = createApp({});
// app.component('hello-world', HelloWorld)

app.use(router);
app.use(store);
app.use(VueSidebarMenu);
const toastOptions = {
  position: POSITION.TOP_CENTER,
  timeout: 2000,
  shareAppContext: true
};
app.use(Toast, toastOptions);

app.mount('#app')