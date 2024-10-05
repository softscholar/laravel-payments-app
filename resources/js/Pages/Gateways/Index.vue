<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';

</script>

<template>
    <Head title="Gateways" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Gateways
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                       <div class="grid grid-cols-2 md:grid-cols-2 gap-6">
                           <div class="bg-white shadow-md rounded-lg overflow-hidden relative"
                           v-for="(gateway, key) in $page.props.gateways"
                           >
                               {{ key}}
                               <div class="px-4">
                                   <img :src="gateway.url" :alt="gateway.name" class="w-full h-48 object-cover">
                               </div>
                               <div class="p-4">
                                   <h3 class="text-xl font-bold mb-2">{{ gateway.name }}</h3>
                                   <p class="text-sm text-gray-600 mb-4">{{ gateway.description }}</p>
                                   <Link :href="route('gateways.payment-accounts', [$page.props.product.id, { gateway: key }])"
                                         class="bg-green-500 text-white font-semibold px-6 py-2 rounded hover:bg-green-600 transition-colors duration-300">
                                       Pay with {{ gateway.name }}
                                   </Link>
                               </div>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
