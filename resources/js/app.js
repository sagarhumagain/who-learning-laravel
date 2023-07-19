/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

import router from '@/router';
import { apiRepositories } from '@/services/api';
import store from '@/store';
import 'bootstrap';
import moment from 'moment';
import { createApp } from 'vue';
import VueSidebarMenu from 'vue-sidebar-menu';
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css';


import { dom, library } from "@fortawesome/fontawesome-svg-core";
import { fab } from '@fortawesome/free-brands-svg-icons';
import { far } from '@fortawesome/free-regular-svg-icons';
import { fas } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import VCalendar from 'v-calendar';
import 'v-calendar/dist/style.css';
import VueGates from 'vue-gates';
library.add(fas);
library.add(fab);
library.add(far);

dom.watch();

import Functions from "./functions";




// /*Sweet alert start*/

const app = createApp({});
app.use(router);
app.use(store);
app.use(VueSidebarMenu);

//vform
import VueProgressBar from "@aacassandra/vue3-progressbar";
import {
    AlertError,
    AlertErrors,
    AlertSuccess,
    Button,
    HasError
} from 'vform/src/components/bootstrap5';

app.component(Button.name, Button);
app.component(HasError.name, HasError);
app.component(AlertError.name, AlertError);
app.component(AlertErrors.name, AlertErrors);
app.component(AlertSuccess.name, AlertSuccess);


//vcalendar
app.use(VCalendar, {})

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
import 'sweetalert2/dist/sweetalert2.min.css';
import VueSweetalert2 from 'vue-sweetalert2';

const options = {
    confirmButtonColor: '#41b882',
    cancelButtonColor: '#ff7674',
  };
app.config.globalProperties.$function = new Functions(app);

app.use(VueGates,{persistent:true});

app.use(VueSweetalert2, options);
app.mount('#app');
