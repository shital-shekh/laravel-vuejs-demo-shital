import { createRouter, createWebHistory } from 'vue-router'

// Import pages
import Login from '../pages/Login.vue'
import Register from '../pages/Register.vue'
import Dashboard from '../pages/Dashboard.vue'
import List from '../pages/categories/List.vue'
import Create from '../pages/categories/Create.vue'
import Edit from '../pages/categories/Edit.vue'
import Profile from '../pages/Profile.vue'

const routes = [
  { path: '/', name: 'login', component: Login, meta: { requiresAuth: false } },
  { path: '/register', name: 'register', component: Register, meta: { requiresAuth: false } },
  { path: '/dashboard', name: 'dashboard', component: Dashboard, meta: { requiresAuth: true } },
  { path: '/categories', name: 'categories', component: List, meta: { requiresAuth: true } },
  { path: '/categories/create', name: 'categories.create', component: Create, meta: { requiresAuth: true } },
  { path: '/categories/:id/edit', name: 'categories.edit', component: Edit, meta: { requiresAuth: true } },
  { path: '/profile', name: 'profile', component: Profile, meta: { requiresAuth: true } },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem("token");

    if (to.meta.requiresAuth && !token) {
        localStorage.removeItem("token");
        return next("/");
    }

    next();
});

export default router
