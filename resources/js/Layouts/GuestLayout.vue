<!-- Plantilla para las vistas de invitado -->
<script setup>
/* import { Link } from '@inertiajs/vue3'; */
import Navbar from '@/Components/Navbar.vue';
import Foot from '@/Components/FooterComponent.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>
<template>
<navbar></navbar>
<main class="mt-16 bg-gray-100">
    <slot />
</main>
<Foot></Foot>
</template>