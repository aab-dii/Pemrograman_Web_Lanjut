import { createRouter, createWebHistory } from 'vue-router';
import LogPage from '../components/LogPage.vue';
import AdminDashboard from '../components/DashboardAdmin.vue';
import Inventaris from '../components/InventarisComponent.vue';
import MainDashboard from '../components/MainDashboard.vue'; 
import Transaction from '../components/TransactionComponent.vue';
import AddStock from "../components/AddStockComponent.vue";
import User from '../components/ManageUserComponent.vue';
import KaryawanDashboard from '../components/DashboardKaryawan.vue';
import HistoryTransaction from '../components/HistoryTransactionComponent.vue';

const routes = [
    {
      path: '/',
      name: 'LogPage',
      component: LogPage,
    },
    {
      path: '/admin/dashboard',
      name: 'AdminDashboard',
      component: AdminDashboard,
      redirect: { name: 'MainDashboard' },
      children: [
        {
          path: '',
          name: 'MainDashboard',
          component: MainDashboard,
        },
        {
          path: 'products',
          name: 'Inventaris',
          component: Inventaris,
        },
        {
          path: 'transactions',
          name: 'Transaction',
          component: Transaction,
        },
        {
          path: 'addStock',
          name: 'AddStock',
          component: AddStock,
        },
        {
          path: 'HistoryTransaction',
          name: 'HistoryTransaction',
          component: HistoryTransaction,
        },
        {
          path: 'users',
          name: 'User',
          component: User,
        },
      ],
    },
    {
      path: '/karyawan/dashboard',
      name: 'KaryawanDashboard',
      component: KaryawanDashboard,
    //   redirect: { name: 'KaryawanMainDashboard' },
      children: [
        {
          path: '',
          name: 'KaryawanMainDashboard',
          component: MainDashboard,
        },
        {
          path: 'products',
          name: 'KaryawanInventaris',
          component: Inventaris,
        },
        {
          path: 'transactions',
          name: 'KaryawanTransaction',
          component: Transaction,
        },
        {
          path: 'addStock',
          name: 'KaryawanAddStock',
          component: AddStock,
        },
      ],
    },
  ];
  

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;