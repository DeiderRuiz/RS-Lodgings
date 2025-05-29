<script setup>
import { defineProps } from 'vue';
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import Foot from '@/Components/FooterComponent.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    flash: Object,
});
</script>
<template>
    <Head title="Error" />
    <Navbar></Navbar>
    <AuthenticationCard class="text-center">
        <template #logo>
            <AuthenticationCardLogo />
        </template>
        <h1 class="text-2xl font-bold text-red-600 mb-4">¡Ups! Ocurrió un error</h1>
        <p v-if="$page.props.flash.message" class="text-gray-700 text-lg mb-6">{{ $page.props.flash.message }}</p>
        <p v-else class="text-gray-700 text-lg mb-6">Ha ocurrido un error inesperado.</p>
        <PrimaryLink class="mx-4" :href="route('index')">
            Volver al Inicio
        </PrimaryLink>
    </AuthenticationCard>
    <Foot></Foot>
</template>