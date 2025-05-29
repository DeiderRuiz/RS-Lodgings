<script setup>
/* import { Link } from '@inertiajs/vue3'; */
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import { route } from 'ziggy-js';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    deals: Array,//Array de las ofertas disponibles
});
</script>

<template>
    <Head title="Ofertas" />
    <GuestLayout>
        <div class="flex flex-col items-center justify-center py-12 px-20">
            <!-- Para mostrar todas las ofertas -->
            <div v-for="deal in deals" :key="deal.id" class="flex flex-col items-start bg-crema rounded-lg shadow w-full my-2">
                <div class="flex md:flex-row">
                    <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-s-lg" :src="deal.vista" alt="Oferta">
                    <div class="flex flex-col justify-between items-start p-4 leading-normal">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight dark:text-white">Oferta <span v-if="deal.tipo_de_oferta != 'especial'">de</span> {{ deal.tipo_de_oferta }}: {{ deal.nombre }}</h5>
                        <p class="mb-3 font-normal dark:text-white">{{ deal.descripcion }}</p>
                        <PrimaryLink :href="route('guest.deals.show', deal)">
                            Ver Oferta
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