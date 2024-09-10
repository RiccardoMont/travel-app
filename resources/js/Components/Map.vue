<script setup lang="ts">

import leaflet from 'leaflet'
import { onMounted, watchEffect } from 'vue'
import { useGeolocation } from '@vueuse/core'
import { userMarker, nearbyMarkers } from '../Stores/mapStore'


let map: leaflet.Map;
let userGeoMarker: leaflet.Marker;
let currentMarker: leaflet.Marker | null = null;
const { coords } = useGeolocation();

const emit = defineEmits(['get_lat_and_lng']);

onMounted(() => {
    map = leaflet
        .map("map")
        .setView([userMarker.value.latitude, userMarker.value.longitude], 15);

    leaflet
        .tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        })
        .addTo(map);

    if (nearbyMarkers.value.length !== 0) {
        nearbyMarkers.value.forEach(({ latitude, longitude }) => {
            leaflet
                .marker([latitude, longitude])
                .addTo(map)
                .bindPopup(`Saved marker al latitude: ${latitude.toFixed(3)} 
            longitude: ${longitude.toFixed(3)}`);

        });
    }


    map.addEventListener('click', (e) => {
        const { lat: latitude, lng: longitude } = e.latlng;
        console.log({ lat: latitude, lng: longitude });
        console.log(typeof ({ lat: latitude, lng: longitude }));
        console.log(emit);

        emit('get_lat_and_lng', { latitude, longitude });
        //Rimuovo il marker precedente se esiste
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }

        currentMarker = leaflet
            .marker([latitude, longitude])
            .addTo(map)
            .bindPopup(`Saved marker al latitude: ${latitude.toFixed(3)} 
            longitude: ${longitude.toFixed(3)}`)
            .openPopup();


        //Inserisco un valore
        nearbyMarkers.value.push({ latitude, longitude })
        //Elimino il valore precedente
        nearbyMarkers.value.shift();
        console.log(e);
        console.log(nearbyMarkers.value);


    })
})

watchEffect(() => {
    if (coords.value.latitude !== Number.POSITIVE_INFINITY && coords.value.longitude !== Number.POSITIVE_INFINITY) {
        userMarker.value.latitude = coords.value.latitude;
        userMarker.value.longitude = coords.value.longitude;


        /*if (userGeoMarker) {
            map.removeLayer(userGeoMarker);
        }*/

        /*userGeoMarker = leaflet
            .marker([userMarker.value.latitude, userMarker.value.longitude])
            .addTo(map)
            .bindPopup("User Marker");*/


        /*const el = userGeoMarker.getElement();
        if (el) {
            el.style.filter = "hue-rotate(120deg)";
        }*/

        map.setView([userMarker.value.latitude, userMarker.value.longitude], 15);

    }
})

function clearMarkers() {
    nearbyMarkers.value = [];
    localStorage.removeItem("nearbyMarkers");
    console.log('provato a clearare');
    console.log(nearbyMarkers.value);

    //Rimuovo il marker creato cliccando sulla mappa
    if (currentMarker) {
        map.removeLayer(currentMarker);
    }
    //Rimuovo il marker generato dalla 'tua posizione'
    if (userGeoMarker) {
        map.removeLayer(userGeoMarker);
    }

    //Imposto i valori da passare con l'emit (al form) su stringhe vuote
    const latitude = '';
    const longitude = '';

    emit('get_lat_and_lng', { latitude, longitude });


}

function yourPosition() {

    userGeoMarker = leaflet
        .marker([userMarker.value.latitude, userMarker.value.longitude])
        .addTo(map)
        .bindPopup("User Marker");


    //Imposto i valori da passare con l'emit (al form) sui valori della propria posizione
    const latitude = userMarker.value.latitude;
    const longitude = userMarker.value.longitude;

    emit('get_lat_and_lng', { latitude, longitude });

}

function toggleMap() {

    const mapEl = document.getElementById('map');
    mapEl.classList.toggle('hidden');
    //Per il ricalcolo della dimensione effettiva della mappa dato che sto nascondendo l'elemento. In questo modo può adattarsi e non si blocca il caricamento
    map.invalidateSize();
}

</script>

<template>


    <button data-modal-target="default-modal" data-modal-toggle="default-modal"
        class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">
        MODALEMAPPA
    </button>

    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->



            </div>
        </div>
    </div>
    <button @click="toggleMap()">Map</button>
    <div class="box-map">
        <div id="map" class="hidden">
        </div>
    </div>
    <button @click="clearMarkers()">Clear</button>
    <button @click="yourPosition()">Use your position</button>
</template>

<style scoped>
#map {
    height: 40vh;
}
</style>