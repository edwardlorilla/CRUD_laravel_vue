
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */


require('./bootstrap');
var Vue = require('vue');
var VueRouter = require('vue-router');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
import Users from './components/Users.vue';
import Example from './components/Example.vue';
import CreateUser from './components/CreateUser.vue';
import EditUser from  './components/EditUser.vue';
import ViewUser from  './components/ViewUser.vue';
import Login from './components/Auth/Login.vue';
import PostIndex from './components/Posts/Index.vue';
import NotFound from './components/NotFound.vue';
import Student from './components/StudentTest/Student.vue';
import ViewPost from './components/Posts/ViewPost.vue';
import CreatePost from './components/Posts/CreatePost.vue';
import EditPost from './components/Posts/EditPost.vue';

import VeeValidate from 'vee-validate';
import Auth from './components/packages/auth/Auth.js'
Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(Auth);
Vue.http.options.root = 'http://localhost:8000'
Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrfToken;
Vue.http.headers.common['Authorization'] = 'Bearer ' + Vue.auth.getToken()




const router = new VueRouter({
    mode:'history',
    base: __dirname,
    routes:[
        {path:'/', component: Users , name:'users', meta:{forAuth:true}},
        {path:'/create', component: CreateUser, name:'create'},
        {path:'/students', component: Student, name:'students'},
        {path: '/user/:id/edit', component: EditUser  },
        {path: '/user/:id', component: ViewUser  },
        {path: '/login', component: Login, name:'login', meta:{forVisitors:true}},
        {path:'/post/create', component: CreatePost, name:'createPost'},
        {path:'/posts', component: PostIndex },
        { path: '/post/:id/edit', component: EditPost},

        { path: '/post/:id', component: ViewPost,},


    ]
});

router.beforeEach(
    (to,from,next) => {
        if (to.matched.some(record => record.meta.forVisitors)) {
            if (Vue.auth.isAuthenticated()) {
                next({
                    name: 'users'
                })
            } else next()
        }
        else if (to.matched.some(record => record.meta.forAuth)) {
            if (!Vue.auth.isAuthenticated()) {
                next({
                    name: 'login'
                })
            } else next()
        }
        else  next()
    }
)

new Vue(Vue.util.extend({router}, Example)).$mount('#app')
