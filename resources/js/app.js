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
import moment from 'moment';

import { library } from "@fortawesome/fontawesome-svg-core";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import { fas } from '@fortawesome/free-solid-svg-icons'
library.add(fas);
import { fab } from '@fortawesome/free-brands-svg-icons';
library.add(fab);
import { far } from '@fortawesome/free-regular-svg-icons';
library.add(far);
import { dom } from "@fortawesome/fontawesome-svg-core";
import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css';

dom.watch();

import Functions from "./functions";

// /*Sweet alert start*/

const app = createApp({});

app.config.globalProperties.$function = new Functions(app);
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

app.component(Button.name, Button);
app.component(HasError.name, HasError);
app.component(AlertError.name, AlertError);
app.component(AlertErrors.name, AlertErrors);
app.component(AlertSuccess.name, AlertSuccess);

app.use(Toast, toastOptions);

//vcalendar
app.use(VCalendar, {})

//Vue toastification
app.use(Toast, toastOptions);
//fontawsome
app.component("font-awesome-icon", FontAwesomeIcon);
app.config.globalProperties.$api = apiRepositories;
//mitt
// const emitter = mitt();
// app.config.globalProperties.emitter = emitter;

app.config.globalProperties.$filters = {
  duration(created) {
      return moment(created).toNow('UTC'); // April 7th 2019,(h:mm:ss a) 3:34:44 pm
  },
}
import VueProgressBar from "@aacassandra/vue3-progressbar";
const option = {
    color: '#008dc9',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
      speed: '0.2s',
      opacity: '0.6s',
      termination: 300
    },
    autoRevert: true,
    location: 'top',
    inverse: false
  }
app.use(VueProgressBar, option)

import mitt from 'mitt';
const emitter = mitt();
app.config.globalProperties.emitter = emitter;


// /*Sweet alert start*/
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
  };
  
app.use(VueSweetalert2, options);
app.mount('#app');