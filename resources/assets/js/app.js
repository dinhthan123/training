require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
window.Vue.use(VueRouter);

import Paginate from 'vuejs-paginate';
Vue.component('Paginate', Paginate);

import Datepicker from 'vuejs-datepicker';
Vue.component('Datepicker', Datepicker);

// vue-loading-overlay
import VueLoading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(VueLoading, {
    // Pass props by their camelCased names
    color: '#38bb28',
    loader: 'dots',
    width: 64,
    height: 64,
    backgroundColor: '#ffff',
    opacity: 0.5,
    zIndex: 999
});
Vue.component('Loading', VueLoading);
// end vue-loading-overlay

import UserIndex from './components/users/UserIndex.vue';
import UserCreate from './components/users/UserCreate.vue';
import UserEdit from './components/users/UserEdit.vue';

const routes = [
	{
        path: '/',
        component: UserIndex,
        name: 'Home'
    },
    {
        path: '/users',
        component: UserIndex,
        name: 'ListUser'
    },
    {
        path: '/users/create', 
        component: UserCreate, 
        name: 'CreateUser'
    },
    {
        path: '/users/edit/:id', 
        component: UserEdit, 
        name: 'EditUser'
    }
]

const router = new VueRouter({ 
    mode: 'hash',
    linkActiveClass: 'open active',
    scrollBehavior: () => ({ y: 0 }),
    routes: routes,
    mode: 'history' 
})
const app = new Vue({ router }).$mount('#app');
