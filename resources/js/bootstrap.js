import _ from 'lodash';
import { Modal } from 'bootstrap';
import { useToast } from 'vue-toast-notification';
import axios from 'axios';
import $ from "jquery";
import Swal from 'sweetalert2';
// import {Chart} from "chart.js"
import * as Chart from 'chart.js';


window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
*/
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Load the Env BaseUrl
 * MIX :
 * MIX_API_BASE_URL=http://rapidv/docu-app/api
 * window.baseUrl = process.env.MIX_API_BASE_URL;
 *
 * VITE :
 * window.baseUrl = process.env.MIX_API_BASE_URL;
 * VITE_API_BASE_URL=http://rapidv/docu-app/api
*/
window.baseUrl = process.env.MIX_API_BASE_URL;
window.axios.defaults.baseURL = baseUrl;

window.Modal = Modal;
window.Toast = useToast;
window.Swal = Swal;
window.Chart = Chart;
try {
    window.$ = $;
} catch (e) {
    console.log("JQUERY ERROR: " + e);
}
