import Vue from 'vue'
import Router from 'vue-router'


import HelloWorld from '@/components/HelloWorld'
import authRoutes from '@/components/auth/auth';

Vue.use(Router)

export default new Router({
  mode:'history',
  routes: [
    { path: '/' , name: 'HelloWorld' , component: HelloWorld },
    ...authRoutes,
  ]
})
