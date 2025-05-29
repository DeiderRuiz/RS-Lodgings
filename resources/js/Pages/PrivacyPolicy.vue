<script setup>
import { Head } from '@inertiajs/vue3';
import Navbar from '@/Components/Navbar.vue';
import Foot from '@/Components/FooterComponent.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';

defineProps({
    policy: String,
});
</script>
<template>
    <Head title="Politica De Privacidad" />
    <navbar></navbar>
    <div class="font-sans text-gray-900 antialiased mt-16">
        <div class="pt-4 bg-gray-100">
            <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
                <div>
                    <AuthenticationCardLogo />
                </div>
                <div class="w-full sm:max-w-2xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose">
                    <h2>Política de Privacidad de RS Lodgings</h2>
                    <p><strong>Información que recopilamos</strong></p>
                    <p>RS Lodgings recopila información personal que nos proporcionas directamente cuando utilizas nuestros servicios. Esto puede incluir información que proporcionas cuando creas una cuenta, haces una reserva, te pones en contacto con nosotros, etc. La información personal que recopilamos puede incluir tu nombre, correo electrónico, número de teléfono, dirección, información de pago y cualquier otra información que decidas proporcionarnos.</p>
                    <p><strong>Cómo utilizamos tu información</strong></p>
                    <p>Utilizamos la información que recopilamos para proporcionarte nuestros servicios, procesar y confirmar tus reservas, responder a tus consultas, mejorar nuestros servicios y cumplir con nuestras obligaciones legales.</p>
                    <p><strong>Cómo compartimos tu información</strong></p>
                    <p>RS Lodgings no vende ni alquila tu información personal a terceros. Podemos compartir tu información con proveedores de servicios que nos ayudan a proporcionar nuestros servicios.</p>
                    <p><strong>Tus derechos y opciones</strong></p>
                    <p>Tienes derecho a acceder, corregir, actualizar, borrar, mover o exportar tu información personal en cualquier momento. Para ejercer estos derechos, por favor ponte en contacto con nosotros.</p>
                    <p><strong>Cambios a esta política</strong></p>
                    <p>Podemos actualizar esta política de privacidad de vez en cuando. Si hacemos cambios significativos, te lo notificaremos.</p>
                    <p><strong>Contacto</strong></p>
                    <p>Si tienes alguna pregunta sobre esta política de privacidad, puedes ponerte en contacto con nosotros a través de los datos de contacto proporcionados en nuestro sitio web.</p>
                    <p>Fecha de última actualización: 9/enero/2024</p>
                </div>
            </div>
        </div>
    </div>
    <Foot></Foot>
</template>