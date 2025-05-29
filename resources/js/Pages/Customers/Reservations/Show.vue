<script setup>
    import { ref, defineProps, onMounted } from 'vue';
    import { Inertia } from '@inertiajs/inertia';
    import { Head, useForm } from '@inertiajs/vue3';
    import CustomerLayout from '@/Layouts/CustomerLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';

    const props = defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        flash: Object,
        reserva: Object, //Objeto que guarda todos los servicios
        amount: String,
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

    const form = useForm({
        _method: 'patch',
    });

    function cancelar(reserva) {
        const formData = new FormData();
        formData.append('_method', 'patch');
        form.post(route('customer.reservations.cancel', reserva), {
            onSuccess: () => closeModal() // Cierra el modal si la acción se completa con éxito
        });
    }

    let ventanaPago = ref(false);

    const showVentanaPago = (item) => {
      if (ventanaPago.value === item) {
        closeVentanaPago();
      } else {
        ventanaPago.value = item;
      }
    };

    const closeVentanaPago = () => {
        ventanaPago.value = null;
    };

    onMounted(() => {
        // Agregar el script de PayPal al DOM
        const script = document.createElement("script");
        script.src = `https://www.paypal.com/sdk/js?client-id=${import.meta.env.VITE_PAYPAL_CLIENT_ID}`;
        script.async = true;
        document.body.appendChild(script);
        script.onload = () => {
            if (window.paypal) {
                window.paypal.Buttons({
                    createOrder: (data, actions) => {
                        return actions.order.create({
                            purchase_units: [
                                {
                                    amount: { 
                                        value: props.amount,
                                    },
                                },
                            ],
                        });
                    },
                    onApprove: (data, actions) => {
                        return actions.order.capture().then((details) => {
                            console.log("Pago completado:", details);
                            Inertia.post(route("payments", props.reserva), {
                                preserveScroll: true,
                                onSuccess: () => {
                                    console.log("Información del pago guardada exitosamente.");
                                },
                                onError: (errors) => {
                                    console.error("Error al guardar el pago:", errors);
                                },
                            });
                        });
                    },
                }).render("#paypal-button-container-auth");
            } else {
                console.error("El SDK de PayPal no está disponible.");
            }
        };
    });
</script>
<template>
    <Head title="Reservar" />
    <CustomerLayout>
        <div v-if="$page.props.flash.message" class="flex items-center justify-center">
            <div class="place-self-center w-full sm:max-w-6xl mt-6 p-2 bg-emerald-700 text-crema shadow-md overflow-hidden sm:rounded-lg flex items-center text-sm border border-emerald-900 rounded-lg" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">
                    {{ $page.props.flash.message }}
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center">
            <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
                <h4 class="text-center text-2xl text-rojo-dark">Detalles de la reserva</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div>
                            <h6 class="text-rojo-dark text-xl">Información Del Cliente:</h6>
                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg border border-crema-dark m-0 p-0">
                                <table class="w-full text-sm text-left text-rojo m-0 p-0">
                                    <tbody>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Cedula De Ciudadanía
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                {{ reserva.user.cedula }}
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Nombre Completo
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                {{ reserva.user.name }} {{ reserva.user.last_name }}
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Correo Electrónico
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                {{ reserva.user.email }}
                                            </td>
                                        </tr>
                                        <tr class="odd:bg-crema-light even:bg-crema-dark/25">
                                            <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                                Número De Telefono
                                            </th>
                                            <td class="px-6 py-4 capitalize">
                                                {{reserva.user.cellphone}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
                                        <td class="px-6 py-4 capitalize" v-for="room in reserva.rooms" :key="room.id">
                                            {{ reserva.estado }}
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
                                        <th scope="row" class="px-6 py-4 capitalize font-medium whitespace-nowrap">
                                            Número de habitación
                                        </th>
                                        <td class="px-6 py-4 capitalize" v-for="room in reserva.rooms" :key="room.id">
                                            N°{{ room.numero }}
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-crema-light even:bg-crema-dark/25 border-b border-crema-dark">
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
                <div v-if="reserva.estado === 'pendiente'" class="flex items-center mt-4">
                    <PrimaryButton class="mr-4" @click="showVentanaPago(reserva.id)">
                        Pagar y Confirmar Reserva
                    </PrimaryButton>
                    <PrimaryLink class="mx-4" :href="route('customer.reservations.edit', reserva)">
                        Editar Reserva
                    </PrimaryLink>
                    <PrimaryButton @click="showModal(reserva.id)" class="ml-4">
                        Cancelar Reserva
                    </PrimaryButton>
                </div>
                <div v-if="ventana === reserva.id" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
                    <div class="relative p-4 w-full max-w-md 2xl:max-w-xl max-h-full">
                        <div class="relative bg-crema border border-crema-dark rounded-lg shadow">
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-rojo w-12 h-12 2xl:w-14 2xl:h-14 3xl:w-16 3xl:h-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <h3 class="mb-5 text-lg 2xl:text-xl 3xl:text-2xl font-normal">¿Estás seguro de que quieres cancelar esta reserva? Esta acción no se puede deshacer.</h3>
                                <div class="flex items-center justify-around">
                                    <form @submit.prevent="cancelar(reserva.uuid)">
                                        <PrimaryButton type="submit">Si</PrimaryButton>
                                    </form>
                                    <PrimaryButton @click="closeModal()">No</PrimaryButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-show="ventanaPago === reserva.id" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
                    <div class="relative p-4 w-full max-w-md 2xl:max-w-xl max-h-full">
                        <div class="relative bg-crema border border-crema-dark rounded-lg shadow p-6">
                            <div><p class="text-center text-xl">Pagar y confirma tu reserva con PayPal</p></div>
                            <div class="w-full" id="paypal-button-container-auth"></div>
                            <div class="flex items-center justify-around">
                                <PrimaryButton class="w-full" @click="closeVentanaPago()">Cancelar</PrimaryButton>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>