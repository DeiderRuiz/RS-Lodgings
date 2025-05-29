<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    city: Object, //Localizaciones de los hoteles
    galeries: Object, //Galería de fotos de los hoteles
    ratings: Object, //Calificación de los hoteles
});
</script>
<template>
    <Head :title="city.ciudad" />
    <GuestLayout>
        <div class="relative w-full mt-16 shadow-lg">
            <div class="relative h-96 overflow-hidden w-screen flex justify-center">
                <img 
                    v-for="(galery, index) in galeries" 
                    :key="galery.id" 
                    :src="galery.imagen" 
                    :alt="city.ciudad" 
                    class="animate-display opacity-0 absolute block w-full" 
                    :style="'animation-delay: ' + (index * 4) + 's;'"
                >
            </div>
        </div>
        <h5 class="text-center text-2xl">RS Lodgings - {{ city.ciudad }}</h5>    
        <div class="flex items-center justify-center">
            <!-- Estrellas rellenas que representan la calificación del hotel (Si es de 3.8 muestra 3 estrellas)
                Si el numero es decimal lo redondea a la baja (3.8 será 3)-->
            <div v-for="index in Math.floor(ratings)" :key="index">
                <svg class="w-8 h-8 text-oro dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                </svg>                
            </div>
            <!-- Muestra media estrella si la calificación es un decimal (si la calificación es 3.8, 4.5...) -->
            <div v-if="ratings % 1 !== 0">
                <svg class="w-8 h-8 text-oro dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <defs>
                        <clipPath id="half">
                            <rect x="0" y="0" width="12" height="24"/>
                        </clipPath>
                    </defs>
                    <path clip-path="url(#half)" fill="currentColor" d="M12 4.4v14.8M8.5 9.4l-4.6.3a1 1 0 0 0-.5 1.8l3.4 3c.3.2.4.5.3.9l-1 4.4c-.2.8.7 1.5 1.5 1l3.9-2.3a1 1 0 0 1 1 0l4 2.4c.7.4 1.6-.3 1.4-1.1l-1-4.4c-.1-.4 0-.7.3-1l3.4-3a1 1 0 0 0-.5-1.7l-4.6-.3a1 1 0 0 1-.8-.6l-1.8-4.2a1 1 0 0 0-1.8 0L9.3 8.8a1 1 0 0 1-.8.6Z"/>
                    <path stroke="currentColor" stroke-width="2" d="M12 4.4v14.8M8.5 9.4l-4.6.3a1 1 0 0 0-.5 1.8l3.4 3c.3.2.4.5.3.9l-1 4.4c-.2.8.7 1.5 1.5 1l3.9-2.3a1 1 0 0 1 1 0l4 2.4c.7.4 1.6-.3 1.4-1.1l-1-4.4c-.1-.4 0-.7.3-1l3.4-3a1 1 0 0 0-.5-1.7l-4.6-.3a1 1 0 0 1-.8-.6l-1.8-4.2a1 1 0 0 0-1.8 0L9.3 8.8a1 1 0 0 1-.8.6Z"/>
                </svg>
            </div>
            <!-- Muestra las estrellas vacías necesarias para llegar a 5 estrellas (Si hay 3.8 muestra 1 más)
                Redondea los decimales al alza (3.8 será 4) -->
            <div v-for="index in 5 - Math.ceil(ratings)" :key="index">
                <svg class="w-8 h-8 text-oro dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2" d="M11 5.1a1 1 0 0 1 2 0l1.7 4c.1.4.4.6.8.6l4.5.4a1 1 0 0 1 .5 1.7l-3.3 2.8a1 1 0 0 0-.3 1l1 4a1 1 0 0 1-1.5 1.2l-3.9-2.3a1 1 0 0 0-1 0l-4 2.3a1 1 0 0 1-1.4-1.1l1-4.1c.1-.4 0-.8-.3-1l-3.3-2.8a1 1 0 0 1 .5-1.7l4.5-.4c.4 0 .7-.2.8-.6l1.8-4Z"/>
                </svg>
            </div>
        </div>
        <h5 class="text-center">Calificación: {{ ratings }}</h5>
        <div class="flex items-center justify-center">
            <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
                <h6>Dirección: {{ city.direccion }}, {{ city.ciudad }}</h6>
                <h6>Número de teléfono: {{ city.cellphone_hotel }}</h6>
                <p>{{ city.descripcion }}</p>
                <div class="flex items-center justify-start">
                    <PrimaryLink :href="city.url" class="mr-4">
                        Visitar sitio web
                    </PrimaryLink>
                    <PrimaryLink :href="route('guest.locations.index')" class="ml-4">
                        Regresar
                    </PrimaryLink>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>