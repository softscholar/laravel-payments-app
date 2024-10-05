<script setup>
import { Link } from '@inertiajs/vue3';

// Define props without TypeScript
const props = defineProps({
    data: Object
});

// Extract pagination data from props
const pagination = props.data;
</script>

<template>
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-5 pt-6"
         aria-label="Table navigation">
    <span
        class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
      Showing
      <span class="font-semibold text-gray-900 dark:text-white">
        {{ pagination.from }} - {{ pagination.to }}
      </span> of
      <span class="font-semibold text-gray-900 dark:text-white">{{ pagination.total }}</span>
    </span>

        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            <template v-for="(link, index) in pagination.links" :key="link.label">
                <li>
                    <Link preserve-scroll :href="link.url || ''" v-html="link.label"
                          :disabled="link.url === null || link.active"
                          class="flex items-center justify-center px-3 h-8 border border-gray-300"
                          :class="{
                'text-blue-600 border bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white cursor-not-allowed': link.active,
                'leading-tight text-gray-500 bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white': !link.active,
                '!text-gray-500': !link.url,
                'rounded-s-lg': index === 0,
                'rounded-e-lg': pagination.links.length === index + 1
              }"
                    />
                </li>
            </template>
        </ul>
    </nav>
</template>
