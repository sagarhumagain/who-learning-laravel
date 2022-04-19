/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import { createApp } from 'vue'
 
import router from './router';
import store from './store';
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'

const app = createApp({});
// app.component('hello-world', HelloWorld)

app.use(router);
app.use(store);
app.use(VueSidebarMenu);

app.mount('#app')