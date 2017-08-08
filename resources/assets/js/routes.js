import FrontendDashboard from './components/pages/frontend/Dashboard.vue';
const routes = [
    {
        path: '/dashboard',
        name: 'dashboard',
        component: FrontendDashboard
    },
    {
        path: '/product-mix',
        name: 'product-mix',
        component: require('./components/pages/frontend/ProductMix.vue')
    },
    {
        path: '/sales-input',
        name: 'sales-input',
        component: require('./components/pages/frontend/SalesInput.vue')
    },
    {
        path: '/product-projection',
        name: 'product-projection',
        component: require('./components/pages/frontend/ProductProjection.vue')
    },
    {
        path: '/hours-operation',
        name: 'hours-operation',
        component: require('./components/pages/frontend/HoursOperation.vue')
    },
];

export default routes;

