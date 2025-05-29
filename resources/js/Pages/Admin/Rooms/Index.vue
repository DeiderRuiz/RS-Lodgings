<script setup>
    /* import { Link } from '@inertiajs/vue3'; */
    import { Inertia } from '@inertiajs/inertia';
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        flash: Object,
        rooms: Array, //Array de las habitaciones
    });

    const formatPrice = (price) => {
        return price.toLocaleString('es-CO', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };

    const Show = (id) => {
        Inertia.get(route('admin.rooms.show', id));
    };
</script>

<template>
    <Head title="Habitaciones" />
    <AppLayout>
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
        <div>
            <div class="px-12 pt-6">
                <PrimaryLink v-if="$page.props.auth.user.role_id === 1" :href="route('admin.rooms.create')">
                    Nueva Habitación
                </PrimaryLink>
            </div>
            <div class="w-full flex items-center justify-center px-12 pb-12 pt-6">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                    <table class="w-full text-sm text-left rtl:text-right text-gris-antracita">
                        <thead class="text-xs text-black uppercase bg-crema-dark whitespace-nowrap">
                            <tr>
                                <th class="px-6 py-3">
                                    Número
                                </th>
                                <th class="px-6 py-3">
                                    Tipo
                                </th>
                                <th class="px-6 py-3">
                                    Precio
                                </th>
                                <th class="px-6 py-3">
                                    Fecha de creación
                                </th>
                                <th class="px-6 py-3">
                                    Ultima actualización
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="room in rooms" :key="room.id" @click="Show(room)" class="bg-crema border-b border-crema-dark hover:bg-crema-dark cursor-pointer">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    N°{{ room.numero }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ room.tipo }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    ${{ formatPrice(room.precio) }} COP
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ room.formatted_created_at }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ room.formatted_updated_at }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
<style>
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>