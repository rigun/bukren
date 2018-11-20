

import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

Vue.use(VueRouter)

const DashboardLayout = Vue.component('dashboard-layout', require('./components/Layout/dashboardLayout.vue'))
const HomeLayout = Vue.component('home-layout', require('./components/Layout/homeLayout.vue'))
const LoginLayout = Vue.component('login-layout', require('./components/Layout/loginLayout.vue'))
const SuksesLayout = Vue.component('SuksesLayout', require('./components/Layout/suksesLayout.vue'))

const Logout = Vue.component('logout', require('./components/LogoutComponent.vue'))


const Landing = Vue.component('Landing', require('./components/home/Landing.vue'))
const List = Vue.component('List', require('./components/home/List.vue'))
const ListType = Vue.component('ListType', require('./components/home/ListTypeComponent.vue'))
const DetailList = Vue.component('DetailList', require('./components/home/DetailList.vue'))
const Page = Vue.component('Page', require('./components/home/PageView.vue'))
const Search = Vue.component('Search', require('./components/home/SearchComponent.vue'))


const DashboardContent = Vue.component('DashboardContent', require('./components/dashboard/DashboardComponent.vue'))
const UserList = Vue.component('UserList', require('./components/dashboard/UserListComponent.vue'))
const BarangList = Vue.component('BarangList', require('./components/dashboard/BarangListComponent.vue'))
const ArticlesList = Vue.component('ArticlesList', require('./components/dashboard/ArticlesListComponent.vue'))
const ArticlesPost = Vue.component('ArticlesPost', require('./components/dashboard/ArticlesPostComponent.vue'))

const userDashboard = Vue.component('UserDashboard', require('./components/Layout/userDashboardLayout.vue'))
const Profile = Vue.component('Profile', require('./components/home/Profile.vue'))
const Bag = Vue.component('Bag', require('./components/home/BagComponent.vue'))
const Barang = Vue.component('Barang', require('./components/home/BarangComponent.vue'))
const Chat = Vue.component('Chat', require('./components/home/ChatComponent.vue'))
const Message = Vue.component('Message', require('./components/home/SendComponent.vue'))


const routes = [
 
    {
        name: 'Logout',
        path: '/logout',
        component: Logout,
      },
      {
        name: 'SuksesLayout',
        path: '/sukses',
        component: SuksesLayout,
      },
    {
        // name: 'HomeLayout',
        path: '/',
        component: HomeLayout,
        children:[
            {
                name: 'Landing',
                path: '/',
                component: Landing    
            },
            {
                path: '/userdashboard/',
                component: userDashboard,
                meta: { requiresAuth: true },
                children:[
                    {
                        name: 'Profile',
                        path: 'profile',
                        component: Profile,
                        meta: { requiresAuth: true },
                    },
                    {
                        name: 'Bag',
                        path: 'bag',
                        component: Bag,
                        meta: { requiresAuth: true },
                    },
                    {
                        name: 'Barang',
                        path: 'book',
                        component: Barang,
                        meta: { requiresAuth: true },
                    },
                    {
                        name: 'Chat',
                        path: 'chat',
                        component: Chat,
                        meta: { requiresAuth: true },
                    },
                    {
                        name: 'Message',
                        path: 'chat/:token',
                        component: Message,
                        meta: { requiresAuth: true },
                    },
                    
                ]    
            },
            {
                name: 'List',
                path: '/list/:kategori',
                component: List    
            },
            {
                name: 'ListType',
                path: '/listbytype/:type',
                component: ListType    
            },
            {
                name: 'DetailList',
                path: '/detaillist/:slug',
                component: DetailList    
            },
            {
                name: 'Page',
                path: '/blog/:slug',
                component: Page    
            },
            {
                name: 'Search',
                path: '/search/:search',
                component: Search    
            },
            
            
        ]
      },
      {
         // name: 'DashboardLayout',
         path: '/dashboard/',
         component: DashboardLayout,
         meta: { requiresAuth: true },
         children:[
             {
                 name: 'DashboardContent',
                 path: '/',
                 component: DashboardContent
               },
             {
                 name: 'UserList',
                 path: 'userlist',
                 component: UserList
               },
             {
                 name: 'BarangList',
                 path: 'baranglist',
                 component: BarangList
               },
             {
                 name: 'ArticlesList',
                 path: 'articleslist',
                 component: ArticlesList
               },
             {
                 name: 'ArticlesPost',
                 path: 'articlespost/:detail/:id',
                 component: ArticlesPost
               },
         ]
      }
];
const router = new VueRouter({mode: 'history', routes: routes});
router.beforeEach((to, from, next) => {

    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedIn) {
        // redirect to login page
        next({ name: 'Landing' })
        return
    }

    if(to.path === '/dashboard' && !store.state.isLoggedIn) {
        next({ name: 'Landing' })
        return
    }


    if(to.path === '/userdashboard' && !store.state.isLoggedIn) {
        next({ name: 'Landing' })
        return
    }

    next()
})
export default router