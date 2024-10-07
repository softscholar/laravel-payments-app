<script setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import {useForm, Link} from '@inertiajs/vue3';

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

const cancelAuthorization = () => {
    alert('Delete');
    form.get(route(props.routeName, {payment_account: props.item.id}), {
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
                    Cancel Authorization
                </h2>

                <div class="mt-4">
                    <p class="text-sm text-gray-700 dark:text-gray-300">
                        Are you sure to cancel authorize the account?
                        <span class="text-red-700">
                            {{ item.account_no}}
                        </span>
                    </p>
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal">
                        Cancel
                    </SecondaryButton>

                    <Link
                        :href="route(props.routeName, {payment_account: item.id})"
                        class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700 dark:focus:ring-offset-gray-800 ms-3"
                    >
                        Cancel Authorization
                    </Link>
                </div>
            </div>
        </Modal>
    </section>
</template>
