<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link, usePage} from '@inertiajs/vue3';

const gateway = usePage().props.gateway;
</script>

<template>
    <Head title="Payment Accounts" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Payment Accounts
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div
                            v-if="$page.props.paymentAccounts.length > 0"
                            class="grid grid-cols-2 md:grid-cols-2 gap-6">
                            <div class="bg-white shadow-md rounded-lg overflow-hidden relative"
                                 v-for="(account, key) in $page.props.paymentAccounts"
                            >
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden relative transition transform hover:scale-105 hover:shadow-xl">
                                    <!-- Cancel Authorization link in the top-right corner -->
                                    <div class="absolute top-2 right-2">
                                        <button type="submit"
                                                class="bg-red-100 text-red-500 text-xs font-semibold px-3 py-1 rounded-full hover:bg-red-200 transition duration-300 ease-in-out">
                                            Cancel Authorization
                                        </button>
                                    </div>

                                    <div class="px-4 py-6">
                                        <img :src="gateway.url" alt=""
                                             class="w-full h-24 object-contain mb-4">
                                        <div class="text-center">
                                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ account.account_no }}</h3>
                                            <a href=""
                                               class="bg-green-500 text-white font-semibold px-6 py-2 rounded hover:bg-green-600 transition-colors duration-300">
                                                Pay Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div v-else  class="grid grid-cols-2 md:grid-cols-2 gap-6">
                            <div class="text-center bg-white dark:bg-gray-800 shadow rounded-lg">
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                    <div class="p-6 space-y-4">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-xl font-semibold text-gray-700">Just Pay for Now</h3>
                                            <a href=""
                                               class="bg-blue-500 text-white font-semibold px-6 py-2 rounded hover:bg-blue-600 transition">
                                                Pay Now
                                            </a>
                                        </div>

                                        <hr class="border-gray-300">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-xl font-semibold text-gray-700">Save Account for Future</h3>
                                            <div class="flex items-center space-x-2">
                                                <Link :href="route('gateways.process', [$page.props.product.id, { gateway: $page.props.gateway.key, save: 'true' }])"
                                                      class="bg-blue-700 text-white font-semibold px-4 py-1 rounded hover:bg-blue-600 transition">
                                                    Save
                                                </Link>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
