<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NewTrip from '@/Components/NewTrip.vue';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

//reinizializzo i componenti altrimenti il bottone non trigghera la modale
onMounted(() => {
    initFlowbite();
})

</script>
<template>
    <Head title="Stops" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Stops</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>
            </div>
        </div>
        <button data-modal-target="authentication-modal" data-modal-toggle="authentication-modal" id="button-modal" type="button" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">Modal</button>
       <NewTrip />
    </AuthenticatedLayout>
</template>

