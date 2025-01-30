<template>
    <section class="content">
        <div class="container-fluid">
            <div style="margin-top: 8%;">
                <h4 class="text-center">Mailer</h4>

                <hr class="my-4 ">

                <h1 class="display-2 text-center">DO NOT CLOSE</h1>

                <hr class="my-4 ">

                <p class="text-center">Auto Mail Notification</p>
                <p class="text-center">{{ date }}</p>
                <p class="text-center">{{ timer }}</p>
                <p class="text-center">{{ day }}</p>
            </div>
        </div>
    </section>
</template>
<script setup>
    import { ref } from 'vue';
    // import api from '../axios';
    import moment from 'moment'
import { Alert } from 'bootstrap';
    const timer = ref();
    const date = ref();
    const day = ref();
    // const timer = ref(moment().format('LTS'));
    // onMounted(() => {
        let today = moment().format('MM/DD/YYYY');
        const getDocumentInfoForEmail  = async ()  => {
            let data = {}
            await axios.get('/api/get_document_Info_for_email',{
                params: data
            }).then((response) => {
                console.log(response);
            }).catch((err) => {
                console.log(err);
            });
        }
        setInterval(() => {
            timer.value = moment().format('LTS');
            date.value = moment().format('l');
            // day.value = moment().format('D');

            if(timer.value === "12:05:00 AM" && moment().format('D') == '16'){
                // loadDataEPRPO(1)
                console.log('12:05:00 AM')

            }
            if(timer.value === "12:05:00 AM" && moment().format('D') == '26'){
            // if(timer.value === "8:12:30 AM" && moment().format('D') == '26'){
                // loadDataEPRPO(2)
                console.log('12:05:00 AM')

            }


            if(timer.value === "7:30:00 AM"){
                getDocumentInfoForEmail();
                // if( ( today >= moment().format('MM/18/YYYY') ) && ( today < moment().format('MM/25/YYYY') )){ // FIRST RECON
                //     // loadChecker(1)
                //     console.log('7:30:00')
                // }

                // if( ( today == moment().format('MM/28/YYYY') ) || ( today <= moment().format('MM/15/YYYY') )){ // SECOND RECON
                //     // loadChecker(2)
                //     console.log('8:30:00')
                // }
            }

            if(timer.value === "6:25:30 PM"){
                // console.log('dsad asd 6:25:00 PM')
                alert('dsad asd 6:25:30 PM')

                // if( ( today >= moment().format('MM/18/YYYY') ) && ( today < moment().format('MM/25/YYYY') )){ // FIRST RECON
                //     // loadChecker(1)
                //     console.log('7:30:00')
                // }

                // if( ( today == moment().format('MM/28/YYYY') ) || ( today <= moment().format('MM/15/YYYY') )){ // SECOND RECON
                //     // loadChecker(2)
                //     console.log('8:30:00')
                // }
            }
        }, 1000);

</script>
