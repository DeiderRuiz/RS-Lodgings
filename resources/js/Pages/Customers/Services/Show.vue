<script setup>
    import { Head } from '@inertiajs/vue3';
    import PrimaryLink from '@/Components/PrimaryLink.vue';
    import CustomerLayout from '@/Layouts/CustomerLayout.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        service: Object, //Objeto que guarda todos los servicios
    });
</script>
<template>
    <Head title="Servicios" />
    <CustomerLayout>
        <div class="flex items-center justify-center">
            <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
                <!-- Detalles del servicio -->
                <h3 class="text-center uppercase">{{ service.nombre }}</h3>
                <h6 class="text-center">Servicio de {{ service.tipo }}</h6>
                <p v-if="service.para_habitacion">Exclusivo para algunas habitaciones</p>
                <p v-else>Disponible para todas las habitaciones</p>
                <p>Precio ${{ service.precio }} COP</p>
                <p>{{ service.detalles }}</p>
                <PrimaryLink :href="route('customer.services.index')">
                    Regresar
                </PrimaryLink>
            </div>
        </div>
    </CustomerLayout>
</template>