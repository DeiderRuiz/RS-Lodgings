<script setup>
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  room: Object, //Obeto con la información de las habitaciones
  services: Object, //Objeto de los servicios disponibles
  exclusive_services: Object, //Objeto de los servicios excusivos para ciertas habitaciones
});
</script>
<template>
  <Head title="Servicios" />
  <GuestLayout>
    <div class="relative h-56 overflow-hidden md:h-96">
      <img class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" :src="room.vista" :alt="room.numero">
    </div>
    <div class="flex items-center justify-center">
      <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
        <h3 class="text-center">Habitación N°{{ room.numero }}</h3>
        <!-- Si la habitación esta disponible... -->
        <h6 v-if="room.disponibilidad" class="text-center uppercase text-rojo">Disponible</h6>
        <!-- sino... -->
        <h6 v-else class="text-center uppercase text-rojo">Reservada</h6>
        <div class="flex items-start justify-center grid grid-cols-2 gap-2">
          <div>
            <p>Tipo de habitación: {{ room.tipo }}</p>
            <p>Precio: ${{ room.precio }} COP <span class="text-rojo uppercase">Por noche</span></p>
            <p>{{ room.detalles }}</p>
          </div>
          <div>
            <h6 class="text-rojo">Servicios exclusivos para esta habitacion</h6>
            <ul class="list-none">
              <!-- Lista de servicios exclusivos de la habitación -->
              <li v-for="exclusive_service in exclusive_services" :key="exclusive_service">
                {{ exclusive_service.nombre }} ({{ exclusive_service.tipo }}): ${{ exclusive_service.precio }}COP
              </li>
            </ul>
            <h6 class="text-rojo">Otros servicios disponibles</h6>
            <ul class="list-none">
              <!-- Lista de servicios disponibles (En general) -->
              <li v-for="service in services" :key="service">
                {{ service.nombre }} ({{ service.tipo }}): ${{ service.precio }} COP
              </li>
            </ul>
          </div>
        </div>
        <PrimaryLink :href="route('guest.rooms.index')" class="mr-4">
          Regresar
        </PrimaryLink>
        <PrimaryLink :href="route('guest.reservations.create', room)"  class="ml-4">
          Reservar
        </PrimaryLink>
      </div>
    </div>
  </GuestLayout>
</template>