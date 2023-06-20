import { createRouter, createWebHistory } from 'vue-router';

import InvoiceIndex from '../components/invoices/Index.vue';
import InvoiceCreate from '../components/invoices/Create.vue';
import InvoiceShow from '../components/invoices/Show.vue';
import InvoiceEdit from '../components/invoices/Edit.vue';
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
        path: '/invoice/show/:id',
        component: InvoiceShow,
        props: true,
    },
    {
        path: '/invoice/edit/:id',
        component: InvoiceEdit,
        props: true,
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
