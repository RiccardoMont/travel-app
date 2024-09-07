<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
    trip: Object,
});




</script>
<template>

    <Head :title="trip.title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ trip.title }}</h2>
        </template>

        <p>stops</p>

      
    </AuthenticatedLayout>
</template>