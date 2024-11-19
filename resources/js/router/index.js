import { createRouter, createWebHistory } from 'vue-router';
import LogPage from '../components/LogPage.vue';
import AdminDashboard from '../components/DashboardAdmin.vue';
import Inventaris from '../components/InventarisComponent.vue';
import MainDashboard from '../components/MainDashboard.vue'; 
import Transaction from '../components/TransactionComponent.vue';
import User from '../components/ManageUserComponent.vue';
import KaryawanDashboard from '../components/DashboardKaryawan.vue';
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
        component: AdminDashboard,
        redirect: {name: 'MainDashboard'},
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
            },
            {
                path: 'users',
                name:  'User',
                component: User
            }
        ]
    },{
        path: '/dashboard',
        name: 'KaryawanDashboard',
        component: KaryawanDashboard,
        redirect: {name: 'MainDashboard'},
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
            },
            {
                path: 'users',
                name:  'User',
                component: User
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