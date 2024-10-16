import { defineStore } from "pinia";
import Router from "../routes";
// import axios from "axios";
// import axios from "../axios";
// import {useToastr} from '../components/toaster.js';
import { useToast } from 'vue-toast-notification';
const toastr = useToast();
export const useAuthStore = defineStore("auth", {
    state: () => ({
        email: null,
        name: null,
        access_token: null,
        error: null,
    }),
    getters: {

    },
    actions: {
        async login(credentials){
            await axios.post('login',credentials).then((res)=>{
                console.log(res.data.userData);
                this.email = res.data.userData.email;
                this.name = res.data.userData.name;
                Router.push({name: 'dashboard'});
                location.reload();
            })
            .catch((err)=>{
                console.log(err);
                // toastr.open({
                //     message: err.response.data.msg,
                //     type: 'error',
                //     position: 'top-right',
                //     duration: 2000,
                // }); // * usage of Toastr notification
            });
        },
        async logout(){
            await axios.get('logout').then((res)=> {
                console.log('useAuthStore: logout');
                this.$reset();
                Router.push({name: 'login'});
                // location.reload();
            })
            .catch((err)=>{

            });
        },
        resetStore() {
            console.log("useAuthStore: resetStore");
            this.$reset();
        },
    },
    persist: true,
});
