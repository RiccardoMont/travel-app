<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import NewTrip from '@/Components/NewTrip.vue';
import EditTrip from "@/Components/EditTrip.vue";
import DeleteModal from "@/Components/DeleteModal.vue";
import Card from '@/Components/Card.vue';

const props = defineProps({
    trips: Array,
    statuses: Array,
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
                        <i :data-modal-target="'edit-trip-modal-' + trip.id " :data-modal-toggle="'edit-trip-modal-' + trip.id " type="button" class="fa-solid fa-pencil px-2"></i>
                        <EditTrip :trip="trip" :statuses="statuses" :old="old" />
                        <DeleteModal :store_trip="trip" />
                    </div>

        </Card>
            <!--<div v-for="trip in trips" :key="trip.id"
                class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img v-if="trip.image !== null" :src="'storage/' + trip.image" alt="">
                </a>
                <div class="p-5 flex justify-between">
                    <a href="#">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ trip.title
                            }}
                        </h5>
                    </a>
                    <div class="flex">
                        <Link :href="route('trips.show', trip.id)"><i class="fa-solid fa-signs-post px-2"></i></Link>
                        <i :data-modal-target="'edit-trip-modal-' + trip.id " :data-modal-toggle="'edit-trip-modal-' + trip.id " type="button" class="fa-solid fa-pencil px-2"></i>
                        <EditTrip :trip="trip" :statuses="statuses" :old="old" />
                        <DeleteTrip :trip="trip" />
                    </div>
                </div>
            </div>-->
        </div>

        <NewTrip />
    </AuthenticatedLayout>
</template>
