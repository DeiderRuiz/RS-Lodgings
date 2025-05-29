<script setup>
/* import { Link } from '@inertiajs/vue3'; */
import { Head } from '@inertiajs/vue3';
import { reactive } from 'vue';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
    services: Object, //Objeto que contiene los servicios disponibles
});

const acordeon = reactive({});
</script>

<template>
  <Head title="Servicios" />
  <CustomerLayout>
    <div class="flex items-center justify-center p-12">
      <div class="flex flex-col items-center w-full">
        <!-- Crea una lista de grupos para clasificar a los servicios según su tipo -->
        <div v-for="(serviceGroup, tipo) in services" :key="tipo" class="w-full">
          <!-- Evento click para abrir o cerrar el acordeon -->
          <button @click="acordeon[tipo] = !acordeon[tipo]" class="flex items-center justify-between w-full p-5 font-medium rtl:text-right bg-crema hover:bg-crema-dark">
            <span>{{ tipo }}</span>
            <!-- Rota el icono en 180 cuando se le da click a una casilla -->
            <svg :class="{'rotate-180': acordeon[tipo]}" class="w-3 h-3 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
          </button>
          <hr class="border-crema-dark border-t-2">
          <!-- Muestra todos los servicios que se encuentran agrupados en el grupo que se le de click -->
          <div v-show="acordeon[tipo]" v-for="service in serviceGroup" :key="service.id" class="bg-crema-dark text-white">
            <div class="flex items-center justify-between w-full p-5 font-medium rtl:text-right">
              <p>{{ service.nombre }}</p>
              <!-- Para ver los detalles de un servicio en concreto -->
              <a :href="route('customer.services.show', service)">Ver más</a>
            </div>
            <hr class="border-crema-light border-t-2">
          </div>
        </div>
      </div>
    </div>
  </CustomerLayout>
</template>

<style>
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>