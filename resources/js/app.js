/* Node Modules/Plugins */
import "./bootstrap";
import "animate.css";
import {createApp} from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core' /* import the fontawesome core | npm i @fortawesome/fontawesome-svg-core*/
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome' /* import font awesome icon component | npm i @fortawesome/vue-fontawesome*/
import { fas } from '@fortawesome/free-solid-svg-icons' /* import entire style | npm i @fortawesome/free-solid-svg-icons*/
library.add(fas) /* add icons to the library */
// VueSelect
import MultiselectElement from '@vueform/multiselect'
// Layout
import AppTemplate from '../js/layouts/App.vue';
// Local JS extensions
import '../js/bootstrap.js';
import router from "./routes";
import { pinia } from './stores';
// DataTable
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs4';

DataTable.use(DataTablesCore)
createApp(AppTemplate)
.use(pinia)
.use(router)
.component('DataTable',DataTable)
.component('font-awesome-icon',FontAwesomeIcon)
.component('MultiselectElement',MultiselectElement)
.mount('#app');
