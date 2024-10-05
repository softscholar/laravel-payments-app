<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, Link} from '@inertiajs/vue3';
import { PackageIcon, PlusIcon, EditIcon, TrashIcon } from 'lucide-vue-next'
import {ref, onMounted} from 'vue';
import Pagination from "@/Pages/Misc/Pagination.vue";
import ProductForm from "@/Pages/Products/ProductForm.vue";
import DeleteItem from "@/Pages/Misc/DeleteItem.vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

const { products } = defineProps({
    products: {
        type: Object,
        required: true,
    },
});

const product = ref(null);
const deletingProductId = ref(null);
const isDeletingModalShow = ref(false);
const deletingProduct = ref(null);

const loading = ref(false)

// Simulated API call to fetch products
const fetchProducts = async () => {
    // Simulate API delay
    // await new Promise(resolve => setTimeout(resolve, 1000))
    loading.value = false
}

const editProduct = (productData) => {
    isShowProductModal.value = true;
    product.value = {...productData};
};
const deleteProduct = (productData) => {
    deletingProduct.value = productData;
    deletingProductId.value = productData.id;
    isDeletingModalShow.value = true;
    // products.value = products.value.filter(p => p.id !== productId)
}

onMounted(fetchProducts);

const isShowProductModal = ref(false);

</script>

<template>
    <Head title="Products" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="">
                            <div class="flex justify-between items-center mb-6">
                                <h1 class="text-3xl font-semibold text-gray-900 dark:text-white">Product List</h1>
                                <button @click="isShowProductModal = true" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900">
                                    <PlusIcon class="h-5 w-5 mr-2" />
                                    Add Product
                                </button>
                            </div>

<!--                            <div v-if="loading" class="text-center py-12">-->
<!--                                <Loader2Icon class="h-12 w-12 animate-spin text-gray-400 dark:text-gray-600 mx-auto" />-->
<!--                                <p class="mt-4 text-gray-600 dark:text-gray-400">Loading products...</p>-->
<!--                            </div>-->

                            <div v-if="products.data.length === 0" class="text-center py-12 bg-white dark:bg-gray-800 shadow rounded-lg">
                                <PackageIcon class="h-16 w-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" />
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">No products found</h3>
                                <p class="mt-1 text-gray-500 dark:text-gray-400">Get started by adding a new product.</p>
                                <button @click="isShowProductModal = true" class="mt-6 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-900">
                                    <PlusIcon class="h-5 w-5 mr-2" />
                                    Add Product
                                </button>
                            </div>

                            <div v-else class="bg-white dark:bg-gray-800 shadow-md rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sl</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Payment</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <tr v-for="(product, index) in products.data" :key="product.id" class="transition-opacity duration-300 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">
                                                    {{ (products.current_page - 1) * products.per_page + index + 1 }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ product.name }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-500 dark:text-gray-300">{{ product.description }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 dark:text-white">${{ product.price.toFixed(2) ?? '' }}</div>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <Link :href="route('gateways.index', product.id )"
                                                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300"
                                                >
                                                    Complete Payment
                                                </Link>
                                            </td>

                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <button @click="editProduct(product)" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-4">
                                                    <EditIcon class="h-5 w-5 inline" />
                                                    <span class="ml-1">Edit</span>
                                                </button>
                                                <button @click="deleteProduct(product)" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">
                                                    <TrashIcon class="h-5 w-5 inline" />
                                                    <span class="ml-1">Delete</span>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <template v-if="Number(products.last_page) > 1">
                                <Pagination :data="products" />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ProductForm
            :showModal="isShowProductModal"
            :product="product"
            @closeModal="isShowProductModal = false"
        />

        <DeleteItem
            :show-modal="isDeletingModalShow"
            :item="deletingProduct"
            route-name="products.destroy"
            @close-modal="isDeletingModalShow = false"
        />
    </AuthenticatedLayout>
</template>

<style scoped>
.list-enter-active,
.list-leave-active {
    transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
}
</style>
