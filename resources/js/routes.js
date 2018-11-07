

import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'

Vue.use(VueRouter)

const DashboardLayout = Vue.component('dashboard-layout', require('./components/Layout/dashboardLayout.vue'))
const HomeLayout = Vue.component('home-layout', require('./components/Layout/homeLayout.vue'))
const LoginLayout = Vue.component('login-layout', require('./components/Layout/loginLayout.vue'))
const Logout = Vue.component('logout', require('./components/LogoutComponent.vue'))


const Landing = Vue.component('Landing', require('./components/home/Landing.vue'))
const routes = [
    {
        name: 'LoginLayout',
        path: '/login',
        component: LoginLayout,
      },
    {
        name: 'Logout',
        path: '/logout',
        component: Logout,
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
            }
        ]
      },
      {
        name: 'DashboardLayout',
        path: '/dashboard/',
        component: DashboardLayout,
        meta: { requiresAuth: true },
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

    next()
})
export default router