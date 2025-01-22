<template>
    <!-- <footer class="footer footer-dark bg-dark">
      <div class="container text-center py-5">
        <p>
          Laravel and Vue Admin Dashboard @
        </p>
      </div>
    </footer> -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <!-- <div class="row">
                <div class="col-sm-6">
                    <div class="copyright text-left my-auto">
                        <span>Copyright &copy; Rapidv 2024 </span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="copyright text-right my-auto">
                        <span> {{ date }} {{ timer }} </span>
                    </div>
                </div>
            </div> -->
                <div class="copyright text-left my-auto">
                    <span>Copyright &copy; Rapidv 2024 </span>
                </div>
                <div class="copyright text-right my-auto">
                    <span> {{ date }} {{ timer }} </span>
                </div>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';
    // import api from '../axios';
    import moment from 'moment'
    const timer = ref();
    const date = ref();
    const day = ref();
        setInterval(() => {
            timer.value = moment().format('LTS');
            date.value = moment().format('l');
        });
</script>
