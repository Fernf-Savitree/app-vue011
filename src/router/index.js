import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/customer',
    name: 'customer',
    
    component: () => import('../views/Customer.vue')
  },

  {
    path: '/contact',
    name: 'contact',
    
    component: () => import('../views/Contact.vue')
  },

  {
    path: '/type',
    name: 'type',
    
    component: () => import('../views/Type.vue')
  },

  {
    path: '/employee',
    name: 'employee',
    
    component: () => import('../views/Employee.vue')
  }

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
