<script setup>
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        flash: Object,
        deal: Object,
    });
</script>
<template>
    <Head title="Ofertas" />
    <AppLayout>
        <div class="relative h-56 overflow-hidden md:h-96">
            <img class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" :src="deal.vista" :alt="deal.nombre">
        </div>
        <div v-if="$page.props.flash.message" class="flex items-center justify-center px-12 pt-6">
            <div class="place-self-center w-full p-2 bg-emerald-700 text-crema shadow-md overflow-hidden sm:rounded-lg flex items-center text-sm border border-emerald-900 rounded-lg" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">
                    {{ $page.props.flash.message }}
                </p>
            </div>
        </div>
        <div class="px-12 pt-6">
            <PrimaryLink :href="route('admin.deals.index')">
                Regresar
            </PrimaryLink>
            <PrimaryLink :href="route('deal.rooms.show', deal)" class="ml-2">
                Asignar Habitaciones
            </PrimaryLink>
            <PrimaryLink :href="route('deal.services.show', deal)" class="ml-2">
                Asignar Servicios
            </PrimaryLink>
        </div>
        <div class="w-full flex items-center justify-center px-12 pb-12 pt-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gris-antracita">
                    <tbody>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Nombre de la oferta
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                {{ deal.nombre }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Tipo
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                {{ deal.tipo_de_oferta }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Descripción
                            </th>
                            <td class="px-6 py-4">
                                {{ deal.descripcion }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Descuento
                            </th>
                            <td class="px-6 py-4">
                                {{ deal.descuento }}%
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Inicio de la oferta
                            </th>
                            <td class="px-6 py-4">
                                {{ deal.fecha_inicio }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Fin de la oferta
                            </th>
                            <td class="px-6 py-4">
                                {{ deal.fecha_fin }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Noches minimas para aplicar la oferta
                            </th>
                            <td class="px-6 py-4">
                                {{ deal.noches_minimas }} noches
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Fecha de creación
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ deal.formatted_created_at }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Ultima actualización
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ deal.formatted_updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>