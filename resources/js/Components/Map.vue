<script setup lang="ts">


import { computed, ref } from 'vue'
import leaflet from 'leaflet'
import { onMounted, watchEffect } from 'vue'
import { useGeolocation } from '@vueuse/core'
import { userMarker, nearbyMarkers } from '../Stores/mapStore'

let map: leaflet.Map;
let userGeoMarker: leaflet.Marker;
let currentMarker: leaflet.Marker | null = null;
const { coords } = useGeolocation();

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
            longitude: ${longitude.toFixed(3)}
            <img src="https://m.media-amazon.com/images/I/610RMVX9zpL.__AC_SX300_SY300_QL70_ML2_.jpg">`);

        });
    }


    map.addEventListener('click', (e) => {
        const { lat: latitude, lng: longitude } = e.latlng;
        console.log({ lat: latitude, lng: longitude });
        console.log(typeof({ lat: latitude, lng: longitude }));
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


        /*leaflet
            .marker([latitude, longitude])
            .addTo(map)
            .bindPopup(`Saved marker al latitude: ${latitude.toFixed(3)} 
            longitude: ${longitude.toFixed(3)}`)*/

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

        if (userGeoMarker) {
            map.removeLayer(userGeoMarker);
        }

        userGeoMarker = leaflet
            .marker([userMarker.value.latitude, userMarker.value.longitude])
            .addTo(map)
            .bindPopup("User Marker");


        const el = userGeoMarker.getElement();
        if (el) {
            el.style.filter = "hue-rotate(120deg)";
        }

        map.setView([userMarker.value.latitude, userMarker.value.longitude], 15);

    }
})

function clearMarkers() {
    nearbyMarkers.value = [];
    localStorage.removeItem("nearbyMarkers");
    console.log('provato a clearare');
    console.log(nearbyMarkers.value);
}
</script>

<template>
    <div id="map">

    </div>
    <button @click="clearMarkers()">Clear</button>
</template>

<style scoped>
#map {
    height: 80vh;
}
</style>