<template>
    <div v-if="isVisible" class="modal fade" ref="modalSave" id="modalSave" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <!-- <div v-if="isVisible" class="modal fade" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> -->
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <font-awesome-icon :icon="icon"/>&nbsp<h5 class="modal-title" id="staticBackdropLabel"> {{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="$emit('addEvent')" id="formSave" @click="$emit('clickEvent')">
                    <div class="modal-body">
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
        activeId: {
            type: String,
            required: true,
        },
    })
    const emit = defineEmits(['close']);

    // Determine modal visibility based on activeId
    const isVisible = computed(() => props.activeId === props.id);

    const closeModal = () => {
        emit('close'); // Emit close event to parent
    };
</script>

<style lang="scss" scoped>

</style>
