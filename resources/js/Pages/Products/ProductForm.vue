<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from '@inertiajs/vue3';
import {nextTick, onMounted, ref, watch} from 'vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";

const emit = defineEmits(['closeModal']);

const props = defineProps({
    showModal: {
        type: Boolean,
        default: false,
    },
    product: {
        type: Object,
        default: null,
    },
});

const nameInput = ref(null);

const form = useForm({
    id: '',
    name: '',
    description: '',
    price: '',
});

const focusTheInput = () => {
    nextTick(() => nameInput.value.focus());
};

// if modal is open then focus on the name input
watch(() => props.showModal, (value) => {
    if (value) {
        focusTheInput();
    }
});

watch(() => props.product, (newProduct) => {
    if (newProduct) {
        form.id = newProduct.id || '';
        form.name = newProduct.name || '';
        form.description = newProduct.description || '';
        form.price = newProduct.price || '';
    } else {
        form.reset();
    }
}, { immediate: true });


onMounted(() => {
    if (props.product) {
        form.id = props.product.id;
        form.name = props.product.name;
        form.description = props.product.description;
        form.price = props.product.price;
    }
});

// handle errors
const validateName = () => {
    if (!form.name) {
        form.errors.name = 'Name is required';
    } else {
        form.errors.name = '';
    }
};

const validateDescription = () => {
    if (!form.description) {
        form.errors.description = 'Description is required';
    } else {
        form.errors.description = '';
    }
};

const validatePrice = () => {
    if (!form.price) {
        form.errors.price = 'Price is required';
    } else {
        form.errors.price = '';
    }
};

const handleSubmit = () => {

    validateName();
    validateDescription();
    validatePrice();

    // handle both create and update
    let routeName = form.id ? route('products.update', form.id) : route('products.store');
    let method = form.id ? 'put' : 'post';

    form[method](routeName, {
        preserveScroll: true,
        onSuccess: () => {
            emit('closeModal');
        },
        onError: () => {
            focusTheInput();
        },
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    emit('closeModal');
    form.clearErrors();
    form.reset();
};
</script>

<template>
    <section class="space-y-6">

        <Modal :show="showModal" @close="closeModal">
            <div class="p-6">
                <h2
                    class="text-lg font-medium text-gray-900 dark:text-gray-100 py-2 border-b border-gray-200 dark:border-gray-700"
                >
                    Create Product
                </h2>

                <form @submit.prevent="handleSubmit">
                    <div class="mt-4">
                        <InputLabel
                            for="name"
                            value="Name"
                            :required=true
                        />

                        <TextInput
                            id="name"
                            ref="nameInput"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            placeholder="Product Name"
                            @keyup.enter=""
                        />

                        <InputError :message="form.errors.name" class="mt-2"/>
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="description"
                            value="Description"
                        />
                        <TextAreaInput
                            id="description"
                            v-model="form.description"
                            class="mt-1 block w-full"
                            placeholder="Product Description"
                            @keyup.enter=""
                        />

                        <InputError :message="form.errors.description" class="mt-2"/>
                    </div>

                    <div class="mt-4">
                        <InputLabel
                            for="Price"
                            value="Price"
                            :required=true
                        />

                        <TextInput
                            id="price"
                            v-model="form.price"
                            type="number"
                            step="0.01"
                            class="mt-1 block w-full"
                            placeholder="Price"
                            @keyup.enter=""
                        />

                        <InputError :message="form.errors.price" class="mt-2"/>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal">
                            Cancel
                        </SecondaryButton>

                        <PrimaryButton
                            class="ms-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            {{ form.id ? 'Update' : 'Create' }} Product
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </Modal>
    </section>
</template>
