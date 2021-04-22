require('./bootstrap');

import Vue from 'vue'
import App from './vue/app.vue'
import router from './router'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
import common from './common'
import store from './store'

Vue.mixin(common);
Vue.use(ViewUI);


const app = new Vue({
    el : '#app',
    components: {App},
    router,
    store

})