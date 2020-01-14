/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');
window.Vue = require('jquery');

import Echo from "laravel-echo"

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('app', require('./App.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';
import {routes} from "./routes";
import axios from 'axios';
import jQuery from 'jquery';
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ToggleButton from 'vue-js-toggle-button'
import VueSlideBar from 'vue-slide-bar'
import pagination from 'laravel-vue-pagination'
import VueSessionStorage from 'vue-sessionstorage'

Vue.use(VueSessionStorage);
Vue.use(require('vue-moment'));
Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(ToggleButton);
Vue.use(VueSlideBar);
Vue.use(pagination);

Vue.use({
    // this is the required "install" method for Vue plugins
    install (Vue) {
        Vue.jQuery = jQuery;
        Vue.prototype.$jQuery = jQuery
    }
});

const router = new VueRouter({
    routes,
    // mode:'history',
});

  // axios.defaults.baseURL = "http://localhost:8000/api/";

 axios.defaults.baseURL = "https://pure-headland-78653.herokuapp.com/api/resources/"
// axios.defaults.headers.common = {
//     'Authorization': token
// };
// Vue.prototype.$http = axios;
// const token = localStorage.getItem('token');
// if (token) {
//     Vue.prototype.$http.defaults.headers.common['Authorization'] = token
// }
// axios.create({
//     baseURL: "https://pure-headland-78653.herokuapp.com/api/resources/",
//     headers: {
//         Authorization: token
//     }
// })
// create: function() {
//     axios.interceptors.request.use((config) => {
//         config.headers.client = window.localStorage.getItem('client')
//         config.headers['access-token'] = window.localStorage.getItem('access-token')
//         config.headers.uid = window.localStorage.getItem('uid')
//         config.headers['token-type'] = window.localStorage.getItem('token-type')
//
//         return config
//     })
//
//     axios.interceptors.response.use((response) => {
//         // Set user headers only if they are not blank.
//         // If DTA gets a lot of request quickly, it won't return headers for some requests
//         // so you need a way to keep headers in localStorage to getting set to undefined
//         if (response.headers['access-token']) {
//             localStorage.setItem('access-token', response.headers['access-token'])
//             localStorage.setItem('client', response.headers.client)
//             localStorage.setItem('uid', response.headers.uid)
//             localStorage.setItem('token-type', response.headers['token-type'])
//         }
//         // You have to return the response here or you won't have access to it
//         // later
//         return response
//     })
// }

jQuery.extend(true, jQuery.fn.datetimepicker.defaults, {
    icons: {
        time: 'far fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar-check',
        clear: 'far fa-trash-alt',
        close: 'far fa-times-circle'
    }
});

new Vue({
    el:'#app',
    router,

});




