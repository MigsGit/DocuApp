<template>
    <!-- <div class="modal fade" ref="modalSave" id="modalSave" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> -->
    <div class="modal fade" :id="id" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <!-- <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document"> -->
        <div :class="modalDialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <font-awesome-icon :icon="icon"/>&nbsp<h5 class="modal-title" id="staticBackdropLabel"> {{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="$emit('addEvent')" id="formSave" @click="$emit('clickEvent')">
                    <div class="modal-body overflow-auto">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import {defineProps,ref,onMounted,computed } from 'vue'
    const props = defineProps({
        modalDialog: {
            type: String,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        icon: {
            type: String,
            default: '',
        },
        id: {
            type: String,
            required: true,
        },
    })
</script>

<style>
.modal-dialog-scrollable .modal-body {
    max-height: calc(100vh - 200px); /* Adjust this value as needed */
    overflow-y: auto;
}

</style>
