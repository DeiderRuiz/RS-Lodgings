<script setup>
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import Foot from '@/Components/FooterComponent.vue';
import ThirdLink from '@/Components/ThirdLink.vue';

defineProps({
    ciudades: Array,
});
</script>

<template>
    <CustomerLayout title="Dashboard">
        <div class="bg-img relative w-full h-96 flex items-end justify-end py-20 px-40">
            <div class="bg-black/60 text-white p-3">
                <h1 class="text-6xl">RS Lodgings</h1>
                <h3 class="text-3xl">Your Home Away From Home</h3>
            </div>
        </div>
        <div class="bg-crema-light p-5 shadow">
            <h3 class="text-2xl text-center">Encuéntranos en estas y otras ciudades del país</h3>
            <div class="grid grid-cols-4 gap-16 px-16 pt-5">
                <div v-for="(ciudad, index) in ciudades" :key="index" class="w-full h-full rounded-full overflow-hidden relative">
                    <img v-bind:src="ciudad.portada" v-bind:alt="ciudad.ciudad" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <p class="text-center text-white text-2xl">{{ ciudad.ciudad }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="relative w-full my-5">
            <div class="bg-image relative w-full h-64 flex items-center justify-end pr-40 shadow">
                <div class="bg-crema w-2/5 h-full-plus p-5 relative shadow-lg">
                    <h1 class="text-2xl">¡Bienvenido, {{ $page.props.auth.user.name }}!</h1>
                    <p>
                        Nos alegra tenerte de vuelta en RS Lodgings. Revisa tus próximas reservas, descubre nuevas experiencias y prepárate para una estadía increíble. ¿Sabías que ahora puedes reservar varias habitaciones en una sola reserva? Explora todo lo que puedes hacer y disfruta de tu estadía al máximo. ¡Tu comodidad es nuestra prioridad!
                    </p>
                    <div class="flex items-center justify-start my-2">
                        <!-- Enlaces que usan v-bind (:href="" es la acortación de v-bind:href="") -->
                        <ThirdLink :href="route('customer.deals.index')" class="mr-4">
                            Reservar
                        </ThirdLink>
                        <ThirdLink :href="route('customer.rooms.index')" class="ml-4">
                            ¡Calificanos!
                        </ThirdLink>
                    </div>
                </div>
            </div>
        </div>
        <Foot></Foot>
    </CustomerLayout>
</template>
<style>
.bg-dots-darker {
    background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(0,0,0,0.07)'/%3E%3C/svg%3E");
}
.bg-img {
    background-image: url('/images/RS.png');
    background-size: cover;
}
.bg-image {
    background-image: url('/images/pool.jpg');
    background-size: cover;
}
.h-full-plus {
    height: 116%;
}
@media (prefers-color-scheme: dark) {
    .dark\:bg-dots-lighter {
        background-image: url("data:image/svg+xml,%3Csvg width='30' height='30' viewBox='0 0 30 30' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1.22676 0C1.91374 0 2.45351 0.539773 2.45351 1.22676C2.45351 1.91374 1.91374 2.45351 1.22676 2.45351C0.539773 2.45351 0 1.91374 0 1.22676C0 0.539773 0.539773 0 1.22676 0Z' fill='rgba(255,255,255,0.07)'/%3E%3C/svg%3E");
    }
}
</style>