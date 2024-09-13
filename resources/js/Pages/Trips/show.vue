<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import NewStop from '@/Components/NewStop.vue';
import Card from '@/Components/Card.vue';
import EditStop from '@/Components/EditStop.vue';
import DeleteModal from '@/Components/DeleteModal.vue';


const props = defineProps({
    trip: Object,
    statuses: Object,
    stops: Object,
    old: Object
});




</script>
<template>

    <Head :title="trip.title" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ trip.title }}</h2>
        </template>
        <p>stops</p>
        <!--<NewStop :trip="trip" :statuses="statuses" />-->
        <NewStop :trip="trip" :statuses="statuses" />
        <div class="flex flex-wrap">
            <Card v-for="stop in stops" :stop_trip="stop">
                <!--<i :data-modal-target="'show-stop-modal-' + stop.id" :data-modal-toggle="'show-stop-modal-' + stop.id"
                    type="button" class="fa-solid fa-eye"></i>
                    <ShowStop />-->
                <!--<EditStop :stop="stop" :statuses="statuses" :old="old" />-->
                <EditStop :stop="stop" :statuses="statuses" :old="old" />
                <DeleteModal :stop_trip="stop" :entity_type="'stop'" />
            </Card>
        </div>
    </AuthenticatedLayout>
</template>