import { createRouter, createWebHistory } from 'vue-router';
import LogPage from '../components/LogPage.vue';
import UserDashboard from '../components/BaseLayoutComponent.vue';
import Inventaris from '../components/InventarisComponent.vue';
import MainDashboard from '../components/MainDashboard.vue'; 
import Transaction from '../components/TransactionComponent.vue';
// import AddStock from '../components/AddStockComponent.vue';

const routes = [
    {
        path: '/',
        name: 'LogPage',
        component: LogPage
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: UserDashboard,
        redirect: 'MainDashboard',
        children: [
            {
                path: '', // Route default untuk dashboard
                name: 'MainDashboard',
                component: MainDashboard
            },
            {
                path: 'products', 
                name: 'Inventaris', 
                component: Inventaris
            },
            {
                path: 'transactions',
                name: 'Transaction',
                component: Transaction
            }
        ]
    }
    // {
    //     path: '/addStock',
    //     name: 'AddStock',
    //     component: AddStock
    // }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;