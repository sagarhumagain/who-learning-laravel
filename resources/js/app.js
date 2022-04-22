/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import { createApp } from 'vue'
import router from '@/router';
import store from '@/store';
import VueSidebarMenu from 'vue-sidebar-menu';
import Toast, { POSITION } from "vue-toastification";
import 'bootstrap';
import {apiRepositories} from '@/services/api';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css';

const app = createApp({});

app.use(router);
app.use(store);
app.use(VueSidebarMenu);
const toastOptions = {
  position: POSITION.TOP_CENTER,
  timeout: 2500,
  shareAppContext: true
};

app.use(Toast, toastOptions);
app.config.globalProperties.$api = apiRepositories;

app.mount('#app');