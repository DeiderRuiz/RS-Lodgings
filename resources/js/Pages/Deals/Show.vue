<script setup>
    import { Head } from '@inertiajs/vue3';
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        deal: Object,
    });
</script>
<template>
    <Head title="Ofertas" />
    <GuestLayout>
        <div class="flex items-center justify-center p-6">
            <div class="w-full p-6 bg-crema shadow-md overflow-hidden rounded-lg text-black">
                <div class="flex items-start justify-start mb-4">
                    <img class="z-10 inset-0 border-8 border-rojo shadow-xl rounded-xl object-cover w-48 h-48 mr-6" :src="deal.vista" alt="Oferta">
                    <div>
                        <h1 class="text-2xl">{{ deal.nombre }}</h1>
                        <p class="text-lg">Tipo de Oferta: {{ deal.tipo_de_oferta }}</p>
                        <p class="text-lg">Descuento: {{ deal.descuento }}%</p>
                        <p class="text-lg">Oferta disponible a partir de <span class="text-rojo-dark">{{ deal.fecha_inicio }}</span> hasta el <span class="text-rojo-dark">{{ deal.fecha_fin }}</span></p>
                        <p class="text-lg">Esta oferta aplica a partir de un minimo de {{ deal.noches_minimas }} noche(s)</p>
                        <PrimaryLink class="mt-2" :href="route('guest.deals.index')">Regresar</PrimaryLink>
                    </div>
                </div>
                <hr class="border-crema-dark mb-4">
                <div class="grid grid-cols-3 gap-2">
                    <div>
                        <h3 class="text-xl text-rojo-dark">A cerca de la oferta</h3>
                        <p>{{ deal.descripcion }}</p>
                    </div>
                    <div>
                        <h3 class="text-xl text-rojo-dark">Habitaciones requeridas para la oferta</h3>
                        <p>Reserva alguna de las siguientes habitaciones para aplicar a esta oferta:</p>
                        <ul class="list-disc pl-5">
                            <li v-for="room in deal.rooms" :key="room.id">
                                N°{{ room.numero }} - {{ room.tipo }} - ${{ room.precio }} COP
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-xl text-rojo-dark">Servicios requeridos para la oferta</h3>
                        <p>Incluye en tu reserva alguno de los siguientes servicios para aplicar a esta oferta:</p>
                        <ul class="list-disc pl-5">
                            <li v-for="service in deal.services" :key="service.id">
                                {{ service.nombre }} - {{ service.tipo }} - ${{ service.precio }} COP
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>