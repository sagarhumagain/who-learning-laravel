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
import { plugin as Formkit, defaultConfig as formKitConfig } from '@formkit/vue';

// import '@formkit/themes/genesis'
import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas);
import { fab } from '@fortawesome/free-brands-svg-icons';
library.add(fab);
import { far } from '@fortawesome/free-regular-svg-icons';
library.add(far);
import { dom } from "@fortawesome/fontawesome-svg-core";
dom.watch();

const app = createApp({});

app.use(router);
app.use(store);
app.use(VueSidebarMenu);
const toastOptions = {
  position: POSITION.TOP_CENTER,
  timeout: 2500,
  shareAppContext: true
};
//vform
import {
  Button,
  HasError,
  AlertError,
  AlertErrors,
  AlertSuccess
} from 
'vform/src/components/bootstrap5'

app.component(Button.name, Button)
app.component(HasError.name, HasError)
app.component(AlertError.name, AlertError)
app.component(AlertErrors.name, AlertErrors)
app.component(AlertSuccess.name, AlertSuccess)

//Vuee toastification
app.use(Toast, toastOptions);
//fontawsome
app.component("font-awesome-icon", FontAwesomeIcon);
app.config.globalProperties.$api = apiRepositories;

app.mount('#app');