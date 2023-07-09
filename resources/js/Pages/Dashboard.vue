<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
defineProps({
    contacts: {
        type: Array,
    },
    message: {
        type: String
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Contacts Management</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4">
                        <a target="_blank" href="/export-contact"
                            class="mx-3 bg-green-500 hover:bg-green-700 text-white mb-2 w-42 font-bold py-2 px-4 rounded-full float-right">
                            Export Contacts
                        </a>
                        <Link :href="route('contact.import')"
                            class="mx-3 bg-cyan-500 hover:bg-cyan-700 text-white mb-2 w-42 font-bold py-2 px-4 rounded-full float-right">
                        Import Contacts
                        </Link>
                        <Link :href="route('contact.create')"
                            class="mx-3 bg-blue-500 hover:bg-blue-700 text-white mb-2 w-42 font-bold py-2 px-4 rounded-full float-right">
                        Create Contact
                        </Link>

                        <div v-if="message"
                            class="flex text-lg items-center justify-center w-full bg-blue-200 p-3 font-medium text-sm text-green-600">
                            {{ message }}
                        </div>
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Phone
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Address
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(contact, index) in contacts" :key="index"
                                    class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                    <td class="px-6 py-4">{{ index + 1 }}</td>
                                    <td class="px-6 py-4">{{ contact.category.name }}</td>
                                    <td class="px-6 py-4">{{ contact.name }}</td>
                                    <td class="px-6 py-4">{{ contact.email }}</td>
                                    <td class="px-6 py-4">{{ contact.phone }}</td>
                                    <td class="px-6 py-4">{{ contact.address }}</td>
                                    <td class="px-6 py-4">
                                        <Link :href="route('contact.edit', contact.uuid)"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-1">Edit
                                        </Link>
                                        <Link :href="route('contact.delete', contact.uuid)"
                                            class="font-medium text-red-600 dark:text-red-500 hover:underline mx-1">Delete
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
