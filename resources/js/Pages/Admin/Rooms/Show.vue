<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { ref } from 'vue';
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import ButtonLinkPrimary from '@/Components/ButtonLinkPrimary.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        flash: Object,
        room: Object, //Obeto con la información de las habitaciones
    });

    let ventana = ref(false);

    const showModal = (item) => {
      if (ventana.value === item) {
        closeModal();
      } else {
        ventana.value = item;
      }
    };

    const closeModal = () => {
      ventana.value = null;
    };

    const borrar = (id) => {
        Inertia.delete(route('admin.rooms.destroy', id), {
            onSuccess: () => {
                closeModal(); // Cierra el modal automáticamente
            },
        });
    };

    const formatPrice = (price) => {
        return price.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }
</script>
<template>
    <Head title="Habitaciones" />
    <AppLayout>
        <div class="relative h-56 overflow-hidden md:h-96">
            <img class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" :src="room.vista" :alt="room.numero">
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
        <div class="flex items-center justify-start px-12 pt-6">
            <PrimaryLink :href="route('admin.rooms.index')">
                Regresar
            </PrimaryLink>
            <PrimaryLink v-if="$page.props.auth.user.role_id === 1" :href="route('admin.rooms.edit', room)" class="ml-2">
                Editar
            </PrimaryLink>
            <PrimaryButton v-if="$page.props.auth.user.role_id === 1" @click="showModal(room.id)" class="ml-2">
                Borrar
            </PrimaryButton>
            <PrimaryLink :href="route('rooms.services.show', room)" class="ml-2">
                Servicios exlusivos
            </PrimaryLink>
        </div>
        <div class="w-full flex items-center justify-center px-12 pb-12 pt-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gris-antracita">
                    <tbody>
                        <tr class="bg-crema border-b border-crema-dark hover:bg-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Número de habitación
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                N° {{ room.numero }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Tipo
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ room.tipo }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Descripción
                            </th>
                            <td class="px-6 py-4">
                                {{ room.detalles }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Precio de una noche
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ formatPrice(room.precio) }} COP
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                precio por huesped extra
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ formatPrice(room.precio_huesped) }} COP
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Precio por noche extra
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                ${{ formatPrice(room.precio_noche_extra) }} COP
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Estado de disponibilidad
                            </th>
                            <td v-if="room.disponibilidad" class="px-6 py-4 whitespace-nowrap">
                                Disponible
                            </td>
                            <td v-else class="px-6 py-4 whitespace-nowrap">
                                Reservada
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Fecha de creación
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ room.formatted_created_at }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Ultima actualización
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ room.formatted_updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="ventana === room.id" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-md 2xl:max-w-xl max-h-full">
                <div class="relative bg-crema border border-crema-dark rounded-lg shadow">
                    <div class="p-4 md:p-5 text-center">
                        <svg class="mx-auto mb-4 text-rojo w-12 h-12 2xl:w-14 2xl:h-14 3xl:w-16 3xl:h-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <h3 class="mb-5 text-lg 2xl:text-xl 3xl:text-2xl font-normal">¿Estás seguro de que quieres borrar la habitación <span class="text-rojo-dark text-xl">N°{{ room.numero }}</span>? Esta acción no se puede deshacer.</h3>
                        <div class="flex items-center justify-around">
                            <ButtonLinkPrimary @click="borrar(room.id)">Si, Borrar</ButtonLinkPrimary>
                            <PrimaryButton @click="closeModal()">No, Cancelar</PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>