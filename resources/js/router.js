import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './pages/Dashboard'
import User from './pages/User'
import Post from './pages/Post'
import PostCategory from './pages/PostCategory'

Vue.use(VueRouter)

let routes = [
    {
        path: '/home',
        name: 'home',
        component: Dashboard
    },
    {
        path: '/user',
        name: 'user',
        component: User
    },
    {
        path: '/post',
        name: 'post',
        component: Post
    },
    {
        path: '/postCategory',
        name: 'postCategory',
        component: PostCategory
    },
]

export default new VueRouter({
    base: '/admin',
    mode: 'history',
    routes: routes
})