<script setup>
/* import { Link } from '@inertiajs/vue3'; */
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    cities: Array, //Array de las localizaciones
});
</script>

<template>
    <Head title="Ubicaciones" />
    <GuestLayout>
        <div class="flex items-center justify-center p-12 grid grid-cols-2 gap-2">
            <!-- Muestra todas las localizaciones disponibles -->
            <div v-for="city in cities" :key="city.id" class="flex flex-col items-start bg-crema rounded-lg shadow mx-4 my-2">
                <div class="flex md:flex-row">
                    <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" :src="city.portada" alt="">
                    <div class="flex flex-col justify-between items-start p-4 leading-normal">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ city.ciudad }}</h5>
                        <p class="mb-2 font-normal dark:text-gray-400">Dirección: {{ city.direccion }}</p>
                        <div class="flex items-center justify-center">
                            <!-- Estrellas rellenas -->
                            <div v-for="index in Math.floor(city.rating)" :key="index">
                                <svg class="w-8 h-8 text-oro dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                </svg>                
                            </div>
                            <!-- Media estrella si el rating es decimal -->
                            <div v-if="city.rating % 1 !== 0">
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
                            <!-- Estrellas vacías -->
                            <div v-for="index in 5 - Math.ceil(city.rating)" :key="index">
                                <svg class="w-8 h-8 text-oro dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-width="2" d="M11 5.1a1 1 0 0 1 2 0l1.7 4c.1.4.4.6.8.6l4.5.4a1 1 0 0 1 .5 1.7l-3.3 2.8a1 1 0 0 0-.3 1l1 4a1 1 0 0 1-1.5 1.2l-3.9-2.3a1 1 0 0 0-1 0l-4 2.3a1 1 0 0 1-1.4-1.1l1-4.1c.1-.4 0-.8-.3-1l-3.3-2.8a1 1 0 0 1 .5-1.7l4.5-.4c.4 0 .7-.2.8-.6l1.8-4Z"/>
                                </svg>
                            </div>
                        </div>
                        <h5 class="text-center mb-2">Calificación: {{ city.rating }}</h5>
                        <PrimaryLink :href="route('guest.locations.show', city)">
                            Ver Más
                        </PrimaryLink>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<style>
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>