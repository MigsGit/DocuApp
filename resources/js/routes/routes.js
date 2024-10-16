import IndexComponent from '../pages/Index.vue';
import Dashboard from '../pages/Dashboard.vue';
import Module from '../pages/Edocs.vue';
import Login from '../pages/Login.vue'



export default [
    {
        path: '/docu-app',
        component: Login,
        name: 'login',
    },
    {
        path: '/docu-app/main/',
        component: IndexComponent,
        children: [
            {
                path: 'dashboard',
                name: 'dashboard',
                component: Dashboard,
            },
            {
                path: 'module',
                name: 'module',
                component: Module,
            },
        ],
    }
];
