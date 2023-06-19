import { createRouter, createWebHistory } from 'vue-router';

import InvoiceIndex from '../components/invoices/Index.vue';
import InvoiceCreate from '../components/invoices/Create.vue';
import NotFound from '../components/NotFound.vue';

const routes = [
    {
        path: '/',
        component: InvoiceIndex,
    },
    {
        path: '/invoice/create',
        component: InvoiceCreate,
    },
    {
        path: '/:pathMatch(.*)*',
        component: NotFound,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
