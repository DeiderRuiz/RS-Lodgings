<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import ButtonLinkPrimary from '@/Components/ButtonLinkPrimary.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        employees: Array, //Array de los empleados
    });

    const Show = (id) => {
        Inertia.get(route('employees.show', id));
    };
</script>
<template>
    <Head title="Empleados"/>
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
        <div class="px-12 pt-6">
            <ButtonLinkPrimary :href="route('register.employee.create')" class="text-white hover:text-crema dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Registrar Empleado
            </ButtonLinkPrimary>
        </div>
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
                        <tr v-for="employee in employees" :key="employee.id" @click="Show(employee)" class="bg-crema border-b border-crema-dark hover:bg-crema-dark cursor-pointer">
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.last_name }} {{ employee.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.cellphone }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.formatted_created_at }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ employee.formatted_updated_at }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>