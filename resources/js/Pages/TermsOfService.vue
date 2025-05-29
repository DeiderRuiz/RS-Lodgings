<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Foot from '@/Components/FooterComponent.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

defineProps({
    terms: String,
});
</script>
<template>
    <Head title="Terminos De Servicio" />
    <navbar></navbar>
    <div class="font-sans text-gray-900 antialiased mt-16">
        <div class="pt-4 bg-gray-100">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>
                <div class="w-full sm:max-w-2xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose">
                    <h2>Términos de Servicio de RS Lodgings</h2>
                    <p><strong>Aceptación de los Términos</strong></p>
                    <p>Al utilizar los servicios de RS Lodgings, aceptas estos Términos de Servicio. Por favor, léelos cuidadosamente.</p>
                    <p><strong>Servicios de RS Lodgings</strong></p>
                    <p>RS Lodgings proporciona una plataforma para reservar habitaciones de hotel. No somos responsables de cualquier problema que pueda surgir durante tu estancia en el hotel.</p>
                    <p><strong>Reservas</strong></p>
                    <p>Al hacer una reserva a través de RS Lodgings, aceptas pagar todas las tarifas asociadas con tu reserva. Las cancelaciones están sujetas a la política de cancelación del hotel.</p>
                    <p><strong>Conducta del Usuario</strong></p>
                    <p>Esperamos que todos nuestros usuarios se comporten de manera respetuosa y considerada. No toleramos ningún comportamiento abusivo o ilegal.</p>
                    <p><strong>Modificaciones a los Términos</strong></p>
                    <p>Podemos modificar estos Términos de Servicio de vez en cuando. Si hacemos cambios significativos, te lo notificaremos.</p>
                    <p><strong>Contacto</strong></p>
                    <p>Si tienes alguna pregunta sobre estos Términos de Servicio, puedes ponerte en contacto con nosotros a través de los datos de contacto proporcionados en nuestro sitio web.</p>
                    <p>Fecha de última actualización: 9/enero/2024</p>
                </div>
            </div>
        </div>
    </div>
    <Foot></Foot>
</template>