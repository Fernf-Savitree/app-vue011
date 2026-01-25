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
  },

  {
    path: '/add_customer',
    name: 'add_customer',
    
    component: () => import('../views/Add_customer.vue')
  },

  {
    path: '/add_employee',
    name: 'add_employee',
    
    component: () => import('../views/Add_employee.vue')
  },

  {
    path: '/product',
    name: 'product',
    
    component: () => import('../views/Product.vue')
  },

  {
    path: '/product_api',
    name: 'product_api',
    
    component: () => import('../views/Product_API.vue')
  },

  {
    path: '/show_product',
    name: 'show_product',
    
    component: () => import('../views/Show_product.vue')
  }

]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
