<script setup>
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        customer: Object,
    });
</script>
<template>
    <Head title="Clientes" />
    <AppLayout>
        <div class="px-12 pt-12">
            <PrimaryLink :href="route('customers.index')">
                Regresar
            </PrimaryLink>
        </div>
        <div class="w-full flex items-center justify-center px-12 pb-12 pt-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gris-antracita">
                    <tbody>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Cecula de Ciudadanía
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                {{ customer.cedula }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Nombre completo
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                {{ customer.last_name }} {{ customer.name }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Número de teléfono
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap capitalize">
                                {{ customer.cellphone }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Correo electrónico
                            </th>
                            <td class="px-6 py-4">
                                {{ customer.email }}
                            </td>
                        </tr>
                        <tr class="bg-crema border-b border-crema-dark">
                            <th class="px-6 py-4 whitespace-nowrap">
                                Fecha de registro
                            </th>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ customer.formatted_created_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>