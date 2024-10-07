<script setup>
import {ref, watch, computed, onMounted} from 'vue'

const props = defineProps({
    title: { type: String, default: '' },
    message: { type: String, default: '' },
    type: { type: String, default: 'info' }, // Can be 'success', 'error', 'warning', 'info'
    duration: { type: Number, default: 3000 } // Duration in milliseconds
});

onMounted(() => {
    console.log(props.title);
});

const visible = ref(true)

const flashClasses = computed(() => {
    return {
        'bg-green-100 text-green-700': props.type === 'success',
        'bg-red-100 text-red-700': props.type === 'error',
        'bg-yellow-100 text-yellow-700': props.type === 'warning',
        'bg-blue-100 text-blue-700': props.type === 'info',
    }
})

// Hide the flash message after a certain duration
watch(visible, (isVisible) => {
    if (isVisible) {
        setTimeout(() => {
            visible.value = false
        }, props.duration)
    }
})
</script>

<template>
    <div v-if="visible" :class="flashClasses" class="p-4 rounded-md shadow-md flex items-center space-x-3">
        <div class="flex-shrink-0">
            <span v-if="type === 'success'" class="text-green-500">✔️</span>
            <span v-if="type === 'error'" class="text-red-500">❌</span>
            <span v-if="type === 'warning'" class="text-yellow-500">⚠️</span>
            <span v-if="type === 'info'" class="text-blue-500">ℹ️</span>
        </div>
        <div>
            <h3 class="text-lg font-semibold">{{ title }}</h3>
            <p class="text-sm">{{ message }}</p>
        </div>
    </div>
</template>

<style scoped>
/* Optional styles for better appearance */
</style>
