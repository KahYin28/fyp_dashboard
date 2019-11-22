/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');

window.Vue = require('vue');
window.Vue = require('jquery');

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
import {store} from "./store/store";
import axios from 'axios';
import jQuery from 'jquery';
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import ToggleButton from 'vue-js-toggle-button'
import VueSlideBar from 'vue-slide-bar'
import pagination from 'laravel-vue-pagination'

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
});

axios.defaults.baseURL = "http://localhost:8000/api/";

// axios.defaults.baseURL = "https://pure-headland-78653.herokuapp.com/api/resources/"

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
    store
});




