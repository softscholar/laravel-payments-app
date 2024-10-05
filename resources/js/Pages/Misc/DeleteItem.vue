<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {useForm} from '@inertiajs/vue3';

const emit = defineEmits(['closeModal']);

const form  = useForm({});

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
    item: {
        type: Object,
        required: true,
    },
    routeName: {
        type: String,
        required: true,
    },
});

const closeModal = () => {
    emit('closeModal');
};

const deleteProduct = () => {
    form.delete(route(props.routeName, props.item.id), {
        onFinish: () => closeModal(),
    });
};

</script>

<template>
    <section class="space-y-6">

        <Modal :show="showModal" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100 py-2 border-b border-gray-200 dark:border-gray-700"
                >
                    Delete Product
                </h2>

                <div class="mt-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Are you sure you want to delete this product?
                        {{ item }}
                    </p>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteProduct"
                    >
                       Delete Product
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
