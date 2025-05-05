import { createRouter, createWebHistory } from 'vue-router'
import DashboardLayout from '../layouts/DashboardLayout.vue'

import employees from './employees'
import dashboard from './dashboard'


const routes = [
    {
        path: '/',
        component: DashboardLayout,
        children: [
            {
                path: "/:",
                redirect: 'dashboard',
            },
            ...dashboard,
            ...employees,
        ]

    },
    {
        path: '/403',
        name: '403',
        component: () => import('./../pages/403.vue'),
        meta: {
            // middleware: 'guest',
            'title': 'Invalid access'
        }
    },
    {
        path: '/404',
        name: '404',
        component: () => import('./../pages/404.vue'),
        meta: {
            // middleware: 'guest',
            'title': 'Not found'
        }
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: "/404",
    }
];

const router = createRouter({
    routes,
    history: createWebHistory()
});

export default router;


