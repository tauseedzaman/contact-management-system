<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
const form = useForm({
    file: '',
});
const submit = () => {
    form.post(route('contact.import.store'))
};
const onFileChange = (e) => {
    console.log(e.target.files[0]);
    form.file = e.target.files[0];
}
</script>

<template>
    <Head title="Import Contacts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Import Contacts Contacts</h2>
        </template>
        <div class="py-12">
            <div class="max-w-3xl  py-12 mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="relative py-12 overflow-x-auto shadow-md sm:rounded-lg">
                        <form @submit.prevent="submit" class="max-w-md mx-auto" enctype="multipart/form-data">
                            <h2 class="text-center py-4 text-lg">Import Contacts</h2>
                            <div>
                                <InputLabel for="name" value="Choos Excel File" />

                                <input id="name" type="file" class="mb-4 block w-full" v-on:change="onFileChange" />

                                <InputError class="mt-2" :message="form.errors.file" />
                            </div>
                            <div class="flex items-center justify-center">
                                <Link :href="route('contacts')"
                                    class="font-medium  text-blue-600 dark:text-blue-500 hover:underline mx-1">Cancel
                                </Link>
                                <PrimaryButton class="w-42 ml-4 my-3" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Submit
                                </PrimaryButton>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
