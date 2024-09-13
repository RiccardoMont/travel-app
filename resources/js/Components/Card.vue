<script setup>

const props = defineProps({
    stop_trip: Object
})

</script>
<template>
<div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <a href="#">
        <!--<img v-if="image !== null" :src="'storage/' + image" alt="">-->
        <!--Devo usare questa forma altrimenti l'url viene modificato in http://127.0.0.1:8000/trips/storage/ dando errore 404-->
        <img v-if="stop_trip.image !== null" :src="'http://127.0.0.1:8000/storage/' + stop_trip.image" alt="">
    </a>
    <div class="p-5">
        <a href="#">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ stop_trip.title }}</h5>
        </a>
        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.</p>
        <slot />
    </div>
</div>

</template>