

<template>
    <!-- Loading Spinner -->
    <div class="modal" :id="id" data-backdrop="static">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <div class="loading-spinner mb-2"></div>
                    <div>{{ loadingMsg }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
<!-- Loading, please wait ! -->
<script setup>
import {defineProps,ref,onMounted,computed } from 'vue'
    const props = defineProps({
        loadingMsg: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        },
    })
</script>

<style lang="scss" scoped>
/* Loading Spinner */
  .loading-spinner{
    width:30px;
    height:30px;
    border:2px solid indigo;
    border-radius:50%;
    border-top-color:#0001;
    display:inline-block;
    animation:loadingspinner .7s linear infinite;
  }
  @keyframes loadingspinner{
    0%{
      transform:rotate(0deg)
    }
    100%{
      transform:rotate(360deg)
    }
  }
//   .modal-backdrop.show{
//     position: fixed;
//     top: 0;
//     right: 0;
//     bottom: 0;
//     left: 0;
//     background-color: rgba(0, 0, 0, 0.5);
//     z-index: 1040;
//  }

</style>
