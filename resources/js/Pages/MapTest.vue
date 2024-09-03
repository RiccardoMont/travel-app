<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import  Map  from '@/Components/Map.vue';
</script>

<template>
    <Head title="MapTEST" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Map Test</h2>
        </template>

        <div class="py-12">
            <Map />
        </div>
    </AuthenticatedLayout>
</template>
