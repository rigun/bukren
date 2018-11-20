
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Buefy from 'buefy';
import router from './routes.js';
import VueCarousel from 'vue-carousel';
import Editor from '@tinymce/tinymce-vue';


window.Slug = require('slug');
Slug.defaults.mode = 'rfc3986';
window.VueRouter = require('vue-router').default;
window.axios = require('axios').default;
Vue.use(Buefy,{ defaultIconPack: 'fa' }, VueRouter, axios,VueCarousel );
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const AppLayout = Vue.component('app-layout', require('./components/appLayout.vue'))
const slugWidget = Vue.component('slug-widget', require('./components/slugWidget.vue'));
const editor = Vue.component('editor', Editor)

new Vue(
    Vue.util.extend(
        {router},
        AppLayout,
        editor,
        slugWidget
    )
).$mount('#mainLayout');