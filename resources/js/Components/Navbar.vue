<script setup>
import { Link } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>
<template>
<nav class="bg-rojo dark:bg-gray-900 fixed w-full z-50 top-0 start-0 shadow-lg">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a :href="route('index')" class="flex items-center space-x-3 rtl:space-x-reverse">
        <img src="/images/Icon.png" class="h-8" alt="RS" />
        <span class="self-center text-2xl whitespace-nowrap text-white">RS Lodgings</span>
    </a>
    <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
      <div v-if="!canLogin" class="items-center justify-between w-full md:flex md:w-auto md:order-1">
        <Link v-if="$page.props.auth.user" :href="route($page.props.auth.user.role_id === 3 ? 'customer.dashboard' : 'admin.dashboard')" class="text-white hover:text-crema dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Inicio</Link>
          <template v-else>
            <Link :href="route('login')" class="text-white hover:text-crema dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Iniciar sesión</Link>
            <Link v-if="!canRegister" :href="route('register')" class="ms-4 text-white hover:text-crema dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Registrarse</Link>
          </template>
      </div>
      <button data-collapse-toggle="navbar-cta" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-cta" aria-expanded="false">
        <span class="sr-only font-bree-serif">Menú Principal</span>
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
      </button>
    </div>
    <div class="flex items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-cta">
      <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border rounded-lg md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
        <li>
          <NavLink :href="route('guest.rooms.index')" :active="route().current('guest.room.index')">
            Habitaciones
          </NavLink>
        </li>
        <li>
          <NavLink :href="route('guest.services.index')" :active="route().current('guest.services.index')">
            Servicios
          </NavLink>
        </li>
        <li>
          <NavLink :href="route('guest.deals.index')" :active="route().current('guest.deals.index')">
            Ofertas
          </NavLink>
        </li>
        <li>
          <NavLink :href="route('guest.locations.index')" :active="route().current('guest.location.index')">
            Ubicaciones
          </NavLink>
        </li>
      </ul>
    </div>
  </div>
</nav>
</template>