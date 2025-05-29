<script setup>
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        reserva: Object, //Objeto que guarda todos los servicios
    });
</script>
<template>
    <Head title="Reservar" />
    <AppLayout>
        <div class="flex items-center justify-center">
            <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
                <h4 class="text-center text-2xl text-rojo-dark">Detalles de la reserva</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div v-if="reserva.user || reserva.guest" >
                            <h6 class="text-rojo-dark text-xl">Información Del Cliente:</h6>
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-crema-dark m-0 p-0">
                                <table class="w-full text-sm text-left text-rojo m-0 p-0">
                                    <tbody>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Cedula De Ciudadanía
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                <span v-if="reserva.user">{{ reserva.user.cedula }}</span>
                                                <span v-else>{{ reserva.guest.cedula }}</span>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Nombre Completo
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                <span v-if="reserva.user">{{ reserva.user.name }} {{ reserva.user.last_name }}</span>
                                                <span v-else>{{ reserva.guest.name }} {{ reserva.guest.last_name }}</span>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Correo Electrónico
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                <span v-if="reserva.user">{{ reserva.user.email }}</span>
                                                <span v-else>{{ reserva.guest.email }}</span>
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Número De Telefono
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                <span v-if="reserva.user">{{reserva.user.cellphone}}</span>
                                                <span v-else>{{reserva.guest.cellphone}}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-else>
                            <h6 class="text-rojo-dark text-xl">Información Del Cliente: <span>Usuario Eliminado</span></h6>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-rojo-dark text-xl">Servicios Adquiridos:</h6>
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-crema-dark m-0 p-0">
                                <table class="w-full text-sm text-left text-rojo m-0 p-0">
                                    <thead class="text-xs uppercase bg-crema-dark">
                                        <tr>
                                            <td scope="col" class="px-6 py-3 text-white">
                                                Servicio
                                            </td>
                                            <td scope="col" class="px-6 py-3 text-white">
                                                Tipo
                                            </td>
                                            <td scope="col" class="px-6 py-3 text-white">
                                                Exclusivo
                                            </td>
                                            <td scope="col" class="px-6 py-3 text-white">
                                                Precio
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="service in reserva.service" class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark last:border-none">
                                            <td class="px-6 py-4 capitalize">
                                                {{ service.nombre }}
                                            </td>
                                            <td class="px-6 py-4 capitalize">
                                                {{ service.tipo }}
                                            </td>
                                            <td class="px-6 py-4 capitalize" v-if="service.para_habitacion == 0">
                                                No
                                            </td>
                                            <td class="px-6 py-4 capitalize" v-else>
                                                Si
                                            </td>
                                            <td class="px-6 py-4 capitalize">
                                                ${{ service.precio }} COP
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-rojo-dark text-xl">Información De La Reserva:</h6>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-crema-dark m-0 p-0">
                            <table class="w-full text-sm text-left text-rojo m-0 p-0">
                                <tbody>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Estado De La Reserva
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            {{ reserva.estado }}
                                        </td>
                                    </tr>
                                    <tr v-if="reserva.rooms.length >= 1" class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Número de habitación
                                        </th>
                                        <td class="px-6 py-4 capitalize" v-for="room in reserva.rooms" :key="room.id">
                                            N°{{ room.numero }}
                                        </td>
                                    </tr>
                                    <tr v-if="reserva.rooms.length >= 1" class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Tipo de Habitación
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            {{ reserva.rooms[0].tipo }}
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Fecha de inicio
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            {{ reserva.fecha_inicio }}
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Fecha de fin
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            {{ reserva.fecha_fin }}
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Noches
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            {{ reserva.noches }}
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Huespedes
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            {{ reserva.huespedes }}
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Precio de la habitación (1 noche)
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            ${{ reserva.monto_habitacion }} COP
                                        </td>
                                    </tr>
                                    <tr v-if="reserva.monto_extra_huesped" class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Monto por huespedes extra
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            ${{ reserva.monto_extra_huesped }} COP
                                        </td>
                                    </tr>
                                    <tr v-if="reserva.monto_noche_extra" class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Monto por noches extra
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            ${{ reserva.monto_noche_extra }} COP
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Monto Total de todos los servicios
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            ${{ reserva.monto_servicios }} COP
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Coste total de la reserva
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            ${{ reserva.monto_habitacion + reserva.monto_extra_huesped + reserva.monto_noche_extra + reserva.monto_servicios }} COP
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>