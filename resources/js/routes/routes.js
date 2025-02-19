import IndexComponent from '../pages/Index.vue';
import Dashboard from '../pages/Dashboard.vue';
import Module from '../pages/Edocs.vue';
import UserMaster from '../pages/UserMaster.vue';
import Emailer from '../pages/Mailer.vue';
import Login from '../pages/Login.vue'
import ModalSample from '../components/ModalSample.vue'


function checkIfSessionExist(to, from, next) {
    // axios.get('api/check_if_session_exist')
    //     .then((response) => {
    //         if(response['data'].status === 200){
    //             next();
    //         }else{
    //             next({
    //                 path: '/docu-app',
    //                 replace: true
    //             });
    //         }
    //     })
    //     .catch((err) => {
    //         console.log(err)
    //     })
    next();

}

export default [
    {
        path: '/docu-app',
        component: Login,
        name: 'login',
    },
    // {
    //     path: '/modal',
    //     component: ModalSample,
    //     name: 'modal',
    // },
    {
        beforeEnter: checkIfSessionExist,
        path: '/docu-app/main/',
        name: 'main',
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
            {
                path: 'modal',
                component: ModalSample,
                name: 'modal',
            },
            {
                path: 'user_master',
                component: UserMaster,
                name: 'user_master',
            },
            {
                path: 'emailer',
                component: Emailer,
                name: 'emailer',
            }

        ],
    }
];
