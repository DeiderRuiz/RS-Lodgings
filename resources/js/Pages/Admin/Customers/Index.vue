<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        customers: Array, //Array de los clientes
    });
    
    const Show = (id) => {
        Inertia.get(route('customers.show', id));
    };
</script>
<template>
    <Head title="Clientes"/>
    <AppLayout>
        <div class="w-full flex items-center justify-center px-12 pb-12 pt-6">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg w-full">
                <table class="w-full text-sm text-left rtl:text-right text-gris-antracita">
                    <thead class="text-xs text-black uppercase bg-crema-dark whitespace-nowrap">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Nombre
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Teléfono
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Correo electrónico
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Fecha de creación
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Ultima actualización
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in customers" :key="customer.id" @click="Show(customer)" class="bg-crema border-b border-crema-dark hover:bg-crema-dark cursor-pointer">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ customer.last_name }} {{ customer.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ customer.cellphone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ customer.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ customer.formatted_created_at }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ customer.formatted_updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>