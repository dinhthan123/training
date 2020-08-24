require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import Paginate from 'vuejs-paginate';
Vue.component('Paginate', Paginate);

import UserIndex from './components/users/UserIndex.vue';

const routes = [
	{
        path: '/',
        component: UserIndex,
        name: 'Home'
    },
]

const router = new VueRouter({ 
    mode: 'hash',
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes: routes,
    mode: 'history' 
})
const app = new Vue({ router }).$mount('#app');
