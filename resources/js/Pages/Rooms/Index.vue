<script setup>
/* import { Link } from '@inertiajs/vue3'; */
import { Head } from '@inertiajs/vue3';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import SecondaryLink from '@/Components/SecondaryLink.vue';

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: String,
  phpVersion: String,
  rooms: Array, //Array de las habitaciones
});
</script>

<template>
  <Head title="Habitaciones" />
  <GuestLayout>
    <div class="flex items-center justify-center p-12">
      <div class="grid grid-cols-4 gap-4">
        <!-- Bucle para mostrar las habitaciones -->
        <div v-for="room in rooms" :key="room.id" class="max-w-sm bg-crema border border-crema-dark rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
          <img class="rounded-t-lg" :src="room.vista" :alt="room.tipo" />
          <div class="p-5 text-center">
            <h5 class="mb-2 tracking-tight dark:text-white">Habitación {{ room.numero }}: {{room.tipo}}</h5>
            <!-- Si la habitación está dispobible mustra el link hacía la reserva -->
            <PrimaryLink v-if="room.disponibilidad" :href="route('guest.reservations.create', room)" class="flex justify-center w-full mb-5">
              Reservar
            </PrimaryLink>
            <!-- Dehabilita el botón de reservar si la habpitación no está disponible -->
            <PrimaryLink v-else :disabled="Boolean(!room.disponibilidad)" :href="route('guest.reservations.create', room)" class="flex justify-center bg-rojo-dark hover:bg-rojo w-full mb-5">
              Reservado
            </PrimaryLink>
            <!-- Detalles de la habitación -->
            <SecondaryLink :href="route('guest.rooms.show', room)" class="flex justify-center w-full">
              Ver Detalles                         
            </SecondaryLink>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>

<style>
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>