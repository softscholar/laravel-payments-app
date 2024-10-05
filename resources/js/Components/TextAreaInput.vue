
<script setup>
import { defineProps, defineEmits, ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        default: '',
    },
    rows: {
        type: Number,
        default: 4,
    },
    id: {
        type: String,
        required: true,
    },
});

const emit = defineEmits(['update:modelValue']);
const innerValue = ref(props.modelValue);

watch(innerValue, (newValue) => {
    emit('update:modelValue', newValue);
});

watch(() => props.modelValue, (newValue) => {
    innerValue.value = newValue;
});
</script>


<template>
    <textarea
        :id="id"
        v-model="innerValue"
        :placeholder="placeholder"
        class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600"
        :rows="rows"
    ></textarea>
</template>
