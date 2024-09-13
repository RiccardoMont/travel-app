<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';
import Map from './Map.vue';

//reinizializzo i componenti altrimenti il bottone non trigghera la modale
onMounted(() => {
    initFlowbite();
    new_stars();
})

const props = defineProps({
    trip: Object,
    statuses: Object
});

const form = useForm({
    title: '',
    image: '',
    date_and_hour: '',
    lat: '',
    lng: '',
    price: '',
    rating: '',
    status_id: '',
    public: '',
    description: '',
    //Passo il valore trip id per poi reindirizzare alla pagina trips.show
    trip_id: props.trip.id
});

//FUNZIONE PER L'EMIT CHE RACCOGLIE LE COORDINATE DAL COMPONENTE
function get_lat_and_lng(coords) {
    form.lat = coords.latitude;
    form.lng = coords.longitude;
    console.log(form.lat);
    console.log(form.lng);
}

//GESTIONE DELLE STELLE
function new_stars() {

    //Prendo in riferimento .new_rating specifico per le stelle nella modale di creazione di un'altra stop
    const rating = document.querySelector('.new_rating');
    // Seleziono tutti i label (o box)
    const labels = rating.querySelectorAll('label');
    //Variabile di supporto per vedere quale stella sia stata cliccata
    let selectedIndex = -1;

    //Ciclo nelle labels
    labels.forEach((label, index) => {
        // Aggiungo l'hover
        label.addEventListener('mouseenter', () => {
            //console.log(label, index);
            //Nascondo le stelle regular e mostro le solid, tutte a partire da sinistra fino al punto scelto
            //Parto da i = 4 perché le precedenti label inficiano l'index del querySelectoAll
            for (let i = 0; i <= index; i++) {
                labels[i].querySelector('.fa-regular').classList.add('hidden');
                labels[i].querySelector('.fa-solid').classList.remove('hidden');
            }
        });

        //Mostro le stelle regular e nascondo le solid, a partire da destra fino al punto scelto
        label.addEventListener('mouseleave', () => {
            //Nel caso nessuna stella sia stata cliccata, la variabile di supporto non cambia
            if (selectedIndex === -1) {
                for (let i = 0; i < labels.length; i++) {
                    labels[i].querySelector('.fa-regular').classList.remove('hidden');
                    labels[i].querySelector('.fa-solid').classList.add('hidden');
                }
                //Nel caso invece una stella sia stata cliccata la variabile di supporto sarà uguale al suo indice
            } else {
                for (let i = selectedIndex + 1; i < labels.length; i++) {
                    labels[i].querySelector('.fa-regular').classList.remove('hidden');
                    labels[i].querySelector('.fa-solid').classList.add('hidden');
                }
            }
        });

        //Aggiungo il click
        label.addEventListener('click', () => {
            //Assegno il valore dell'indice della stella cliccata alla variabile di supporto
            selectedIndex = index;

            //Gestisco le stelle da sinistra fino ad arrivare a quella cliccata rendendole piene
            for (let i = 0; i <= selectedIndex; i++) {
                labels[i].querySelector('.fa-regular').classList.add('hidden');
                labels[i].querySelector('.fa-solid').classList.remove('hidden');
            }

            //Gestisco tutte le stelle da quella successiva a quella cliccata fino alla più a destra rendendole regular
            for (let i = selectedIndex + 1; i < labels.length; i++) {
                labels[i].querySelector('.fa-regular').classList.add('hidden');
                labels[i].querySelector('.fa-solid').classList.remove('hidden');
            }
        })

    });
}

</script>
<template>

    <i data-modal-target="new-stop-modal" data-modal-toggle="new-stop-modal" type="button"
        class="fa-solid fa-plus fa-2x"></i>

    <div id="new-stop-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        New Stop
                    </h3>
                    <button type="button"
                        class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="new-stop-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <form @submit.prevent="form.post(route('stops.store'))" class="space-y-4"
                        enctype="multipart/form-data">
                        <div>
                            <label for="title"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                            <input v-model="form.title" type="text" name="title" id="title"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                placeholder="My sunny holiday" required />
                        </div>
                        <div>
                            <label for="image"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cover
                                Image</label>
                            <input type="file" @input="form.image = $event.target.files[0]" name="image" id="image"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" />
                        </div>
                        <div class="flex">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="date_and_hour"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data e
                                    Ora:</label>
                                <input v-model="form.date_and_hour" type="datetime-local" id="date_and_hour" name="date_and_hour"
                                    class="border border-gray-300 rounded-lg p-2">
                            </div>
                        </div>
                        <Map @get_lat_and_lng="get_lat_and_lng" />
                        <input type="hidden" id="latitude" v-model="form.lat" />
                        <input type="hidden" id="longitude" v-model="form.lng" />
                        <div>
                            <label for="price"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                            <input v-model="form.price" type="string" name="price" id="price"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="$2999">
                        </div>
                        <div class="new_rating">
                            <span>Rate your stop</span>
                            <input type="radio" id="st-1" value="1" v-model="form.rating" name="star-radio" />
                            <label for="st-1"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-2" value="2" v-model="form.rating" name="star-radio" />
                            <label for="st-2"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-3" value="3" v-model="form.rating" name="star-radio" />
                            <label for="st-3"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-4" value="4" v-model="form.rating" name="star-radio" />
                            <label for="st-4"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-5" value="5" v-model="form.rating" name="star-radio" />
                            <label for="st-5"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label for="status"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select v-model="form.status_id" id="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option selected value="">Select status</option>
                                <option v-for="status in statuses" :value="status.id">{{ status.title }}</option>
                            </select>
                        </div>
                        <div class="flex flex-col">
                            <label for="description" class="form-label fs-5 fw-bold">Description</label>
                            <textarea type="text" class="form-control" name="description" id="description" v-model="form.description" rows="6"></textarea>
                        </div>
                        <div class="d-flex items-center">
                            <input id="public" type="checkbox" value="true" v-model="form.public"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                            <label for="public" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Do you
                                want make this Stop Public?</label>
                        </div>
                        <button type="submit" data-modal-hide="new-stop-modal"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


</template>
<style>
input[type=radio] {
    position: fixed;
    opacity: 0;
    left: -90000px;
}


.fa-star {
    color: rgb(178, 152, 4);
}
</style>
