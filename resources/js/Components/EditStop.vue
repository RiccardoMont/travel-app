<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { initFlowbite } from 'flowbite';

//reinizializzo i componenti altrimenti il bottone non trigghera la modale
onMounted(() => {
    initFlowbite();
})

const form = useForm({
    title: '',
    image: '',
    public: ''
});


//GESTIONE DELLE STELLE
window.onload = function () {

    //Prendo in riferimento .rating altrimenti tutte le altre label del form verrebbero selezionate
    const rating = document.querySelector('.rating');
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
                                <label for="datetime"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Data e
                                    Ora:</label>
                                <input type="datetime-local" id="datetime" name="datetime"
                                    class="border border-gray-300 rounded-lg p-2">
                            </div>
                            
                        </div>
                       
                        <div class="rating">
                            <span>Rate your stop</span>
                            <input type="radio" id="st-1" value="1" name="star-radio" />
                            <label for="st-1"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-2" value="2" name="star-radio" />
                            <label for="st-2"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-3" value="3" name="star-radio" />
                            <label for="st-3"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-4" value="4" name="star-radio" />
                            <label for="st-4"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                            <input type="radio" id="st-5" value="5" name="star-radio" />
                            <label for="st-5"><i class="fa-regular fa-star"></i><i
                                    class="fa-solid fa-star hidden"></i></label>
                        </div>
                        <div class="d-flex items-center">
                            <input id="checked" type="checkbox" value="true" v-model="form.checked"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                            <label for="checked" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Done! It's time for the next stop!</label>
                        </div>
                        <div class="d-flex items-center">
                            <input id="public" type="checkbox" value="true" v-model="form.public"
                                class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-600 dark:border-gray-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" />
                            <label for="public" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Do you
                                want make this Stop Public?</label>
                        </div>
                        <button :disabled="form.processing" type="submit" data-modal-hide="new-stop-modal"
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


input[type=radio]:focus+label {
    outline: 2px dotted black;
}
</style>