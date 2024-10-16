import {createRouter,createWebHashHistory,createWebHistory} from 'vue-router';
import routes from './routes.js';

const router = createRouter({
    /*NOTE:
        createWebHistory is creating a #hashtag to direct to diff (router 3)
        createWebHashHistory is creating a #hashtag to direct to diff (router 4)
     */
    // history: createWebHashHistory(),
    base: process.env.BASE_URL,
    history: createWebHistory(),
    routes
})

export default router;
