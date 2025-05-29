<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        reservas: Array,
    });

    const Show = (id) => {
        Inertia.get(route('admin.reservations.show', id));
    };
</script>
<template>
    <AppLayout>
        <Head title="Reservas"/>
        <div class="w-full flex items-center justify-center px-12 pb-12 pt-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gris-antracita">
                    <thead class="text-xs text-black uppercase bg-crema-dark whitespace-nowrap">
                        <tr>
                            <th class="px-6 py-3">
                                Solicitante
                            </th>
                            <th class="px-6 py-3">
                                Habitación
                            </th>
                            <th class="px-6 py-3">
                                Fecha de inicio
                            </th>
                            <th class="px-6 py-3">
                                Fecha de fin
                            </th>
                            <th class="px-6 py-3">
                                Estado
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="reserva in reservas" :key="reserva.id" @click="Show(reserva)" class="bg-crema border-b border-crema-dark hover:bg-crema-dark cursor-pointer">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <template v-if="reserva.user">
                                    {{ reserva.user.name }} {{ reserva.user.last_name }}
                                </template>
                                <template v-else-if="reserva.guest">
                                    {{ reserva.guest.name }} {{ reserva.guest.last_name }}
                                </template>
                                <template v-else>
                                    Usuario eliminado
                                </template>
                            </td>
                            <td v-if="reserva.rooms.length >= 1" class="px-6 py-4 whitespace-nowrap">
                                <span v-for="room in reserva.rooms" :key="room.id">
                                    N° {{ room.numero }}
                                </span>
                            </td>
                            <td v-else class="px-6 py-4 whitespace-nowrap">
                                <span>
                                    Habitación eliminda
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ reserva.fecha_inicio }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ reserva.fecha_fin }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                {{ reserva.estado }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>