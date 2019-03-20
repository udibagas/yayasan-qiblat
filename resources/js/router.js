import Vue from 'vue'
import VueRouter from 'vue-router'
import Dashboard from './pages/Dashboard'
import User from './pages/User'
import Donor from './pages/Donor'
import Post from './pages/Post'
import Setting from './pages/Setting'
import Backup from './pages/Backup'
import PostCategory from './pages/PostCategory'
import Carousel from './pages/Carousel'
import Donation from './pages/Donation'
import Program from './pages/Program'
import ProgramGallery from './pages/ProgramGallery'
import ProgramPackage from './pages/ProgramPackage'
import CurrencyRate from './pages/CurrencyRate'
import SocialMedia from './pages/SocialMedia'
import Achievement from './pages/Achievement'

Vue.use(VueRouter)

let routes = [
    {
        path: "/home",
        name: "home",
        component: Dashboard
    },
    {
        path: "/user",
        name: "user",
        component: User
    },
    {
        path: "/post",
        name: "post",
        component: Post
    },
    {
        path: "/setting",
        name: "setting",
        component: Setting
    },
    {
        path: "/backup",
        name: "backup",
        component: Backup
    },
    {
        path: "/postCategory",
        name: "postCategory",
        component: PostCategory
    },
    {
        path: "/carousel",
        name: "carousel",
        component: Carousel
    },
    {
        path: "/program",
        name: "program",
        component: Program
    },
    {
        path: "/programPackage",
        name: "programPackage",
        component: ProgramPackage
    },
    {
        path: "/programGallery",
        name: "programGallery",
        component: ProgramGallery
    },
    // {
    //     path: '/team',
    //     name: 'team',
    //     component: Team
    // },
    {
        path: "/currencyRate",
        name: "currencyRate",
        component: CurrencyRate
    },
    {
        path: "/donation",
        name: "donation",
        component: Donation
    },
    {
        path: "/donor",
        name: "donor",
        component: Donor
    },
    {
        path: "/socialMedia",
        name: "socialMedia",
        component: SocialMedia
    },
    {
        path: "/achievement",
        name: "achievement",
        component: Achievement
    }
];

export default new VueRouter({
    base: '/admin',
    mode: 'history',
    routes: routes
})