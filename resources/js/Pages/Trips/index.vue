<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import NewTrip from '@/Components/NewTrip.vue';
import EditTrip from "@/Components/EditTrip.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import Card from '@/Components/Card.vue';

const props = defineProps({
    trips: Object,
    statuses: Object,
    old: Object
});




</script>
<template>
    <Head title="Trips" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Trips</h2>
        </template>
        <h3>List of trips:</h3>
        <div class="flex flex-wrap">
            <Card v-for="trip in trips" :stop_trip="trip">
                <div class="flex">
                    <Link :href="route('trips.show', trip.id)"><i class="fa-solid fa-signs-post px-2"></i></Link>
                    <EditTrip :trip="trip" :statuses="statuses" :old="old" />
                    <DeleteModal :stop_trip="trip" :entity_type="'trip'" />
                </div>
            </Card>
        </div>
        <NewTrip />
    </AuthenticatedLayout>
</template>
