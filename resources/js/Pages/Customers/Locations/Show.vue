<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import PrimaryLink from '@/Components/PrimaryLink.vue';
import CustomerLayout from '@/Layouts/CustomerLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    flash: Object,
    city: Object, //Localizaciones de los hoteles
    galeries: Object, //Galería de fotos de los hoteles
    ratings: Object, //Calificación de los hoteles
    fullRatings: Object,
    myRating: Object,
});

const form = useForm({
    calificacion: null,
    review: null,
});

let ventana = ref(false);

const showModal = (item) => {
    if (ventana.value === item) {
        closeModal();
    } else {
        ventana.value = item;
    }
};

const closeModal = () => {
    ventana.value = null;
};

function submit (City) {
    const formData = new FormData();
    form.post(route('customer.ratings.rate', { location: City }), {
        data: formData, 
        processData: false, 
        contentType: false,

        onSuccess: () => {
            console.log('Formulario enviado');
            closeModal()
        },
    });
}

const toRank = ref(0); // Calificación seleccionada
const hoverRating = ref(0); // Calificación al pasar el cursor

const ajustarAltura = (event) => {
    event.target.style.height = '';
    event.target.style.height = event.target.scrollHeight + 'px';
};
</script>
<template>
    <Head :title="city.ciudad" />
    <CustomerLayout>
        <div class="relative w-full mt-16 shadow-lg">
            <div class="relative h-96 overflow-hidden w-screen flex justify-center">
                <img 
                    v-for="(galery, index) in galeries" 
                    :key="galery.id" 
                    :src="galery.imagen" 
                    :alt="city.ciudad" 
                    class="animate-display opacity-0 absolute block w-full" 
                    :style="'animation-delay: ' + (index * 4) + 's;'"
                >
            </div>
        </div>
        <div v-if="$page.props.flash.message" class="flex items-center justify-center px-12 pt-6">
            <div class="place-self-center w-full sm:max-w-6xl p-2 bg-emerald-700 text-crema shadow-md overflow-hidden sm:rounded-lg flex items-center text-sm border border-emerald-900 rounded-lg" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">
                    {{ $page.props.flash.message }}
                </p>
            </div>
        </div>
        <div class="flex items-center justify-center">
            <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
                <h5 class="text-center text-2xl">RS Lodgings - {{ city.ciudad }}</h5>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <h6>Dirección: {{ city.direccion }}, {{ city.ciudad }}</h6>
                        <h6>Número de teléfono: {{ city.cellphone_hotel }}</h6>
                        <p>{{ city.descripcion }}</p>
                        <div class="flex items-center justify-start">
                            <PrimaryLink :href="city.url" class="mr-4">
                                Visitar sitio web
                            </PrimaryLink>
                            <PrimaryLink :href="route('customer.locations.index')" class="ml-4">
                                Regresar
                            </PrimaryLink>
                        </div>
                    </div>
                    <div>
                        <div class="flex items-start" :class="['flex', myRating ? 'justify-center' : 'justify-between']">
                            <div>
                                <div class="flex items-center justify-center">
                                    <!-- Estrellas rellenas que representan la calificación del hotel (Si es de 3.8 muestra 3 estrellas)
                                        Si el numero es decimal lo redondea a la baja (3.8 será 3)-->
                                    <div v-for="index in Math.floor(ratings)" :key="index">
                                        <svg class="w-8 h-8 text-oro dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>                
                                    </div>
                                    <!-- Muestra media estrella si la calificación es un decimal (si la calificación es 3.8, 4.5...) -->
                                    <div v-if="ratings % 1 !== 0">
                                        <svg class="w-8 h-8 text-oro dark:text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <defs>
                                                <clipPath id="half">
                                                    <rect x="0" y="0" width="12" height="24"/>
                                                </clipPath>
                                            </defs>
                                            <path clip-path="url(#half)" fill="currentColor" d="M12 4.4v14.8M8.5 9.4l-4.6.3a1 1 0 0 0-.5 1.8l3.4 3c.3.2.4.5.3.9l-1 4.4c-.2.8.7 1.5 1.5 1l3.9-2.3a1 1 0 0 1 1 0l4 2.4c.7.4 1.6-.3 1.4-1.1l-1-4.4c-.1-.4 0-.7.3-1l3.4-3a1 1 0 0 0-.5-1.7l-4.6-.3a1 1 0 0 1-.8-.6l-1.8-4.2a1 1 0 0 0-1.8 0L9.3 8.8a1 1 0 0 1-.8.6Z"/>
                                            <path stroke="currentColor" stroke-width="2" d="M12 4.4v14.8M8.5 9.4l-4.6.3a1 1 0 0 0-.5 1.8l3.4 3c.3.2.4.5.3.9l-1 4.4c-.2.8.7 1.5 1.5 1l3.9-2.3a1 1 0 0 1 1 0l4 2.4c.7.4 1.6-.3 1.4-1.1l-1-4.4c-.1-.4 0-.7.3-1l3.4-3a1 1 0 0 0-.5-1.7l-4.6-.3a1 1 0 0 1-.8-.6l-1.8-4.2a1 1 0 0 0-1.8 0L9.3 8.8a1 1 0 0 1-.8.6Z"/>
                                        </svg>
                                    </div>
                                    <!-- Muestra las estrellas vacías necesarias para llegar a 5 estrellas (Si hay 3.8 muestra 1 más)
                                        Redondea los decimales al alza (3.8 será 4) -->
                                    <div v-for="index in 5 - Math.ceil(ratings)" :key="index">
                                        <svg class="w-8 h-8 text-oro dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-width="2" d="M11 5.1a1 1 0 0 1 2 0l1.7 4c.1.4.4.6.8.6l4.5.4a1 1 0 0 1 .5 1.7l-3.3 2.8a1 1 0 0 0-.3 1l1 4a1 1 0 0 1-1.5 1.2l-3.9-2.3a1 1 0 0 0-1 0l-4 2.3a1 1 0 0 1-1.4-1.1l1-4.1c.1-.4 0-.8-.3-1l-3.3-2.8a1 1 0 0 1 .5-1.7l4.5-.4c.4 0 .7-.2.8-.6l1.8-4Z"/>
                                        </svg>
                                    </div>
                                </div>
                                <h5 class="text-center">Calificaciones: {{ ratings }}</h5>
                            </div>
                            <div v-if="!myRating" @click="showModal(1)">
                                <PrimaryButton>
                                    ¡Calificanos!
                                </PrimaryButton>
                            </div>
                        </div>
                        <div v-if="myRating" class="border-b border-crema-dark">
                            <h4>{{ myRating.user.name }} {{ myRating.user.last_name }}</h4>
                            <div class="flex items-center justify-start">
                                <div v-for="index in 5" :key="index">
                                    <svg class="w-5 h-5 text-oro" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" :fill="index <= myRating.calificacion ? 'currentColor' : 'none'" viewBox="0 0 24 24">
                                        <path :stroke="index <= myRating.calificacion ? 'none' : 'currentColor'" :stroke-width="index <= myRating.calificacion ? '0' : '2'" d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                    </svg>
                                </div>
                                <span class="ml-2">{{ myRating.formatted_updated_at }}</span>
                            </div>
                            <p>{{ myRating.review }}</p>
                        </div>
                        <div v-for="fullRating in fullRatings" :key="fullRating.id">
                            <div class="border-b border-crema-dark" v-if="!(myRating && fullRating.user.id === myRating.user.id)">
                                <h4>{{ fullRating.user.name }} {{ fullRating.user.last_name }}</h4>
                                <div class="flex items-center justify-start">
                                    <div v-for="index in 5" :key="index">
                                        <svg class="w-5 h-5 text-oro" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" :fill="index <= fullRating.calificacion ? 'currentColor' : 'none'" viewBox="0 0 24 24">
                                            <path :stroke="index <= fullRating.calificacion ? 'none' : 'currentColor'" :stroke-width="index <= fullRating.calificacion ? '0' : '2'" d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"/>
                                        </svg>
                                    </div>
                                    <span class="ml-2">{{ fullRating.formatted_updated_at }}</span>
                                </div>
                                <p>{{ fullRating.review }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="ventana === 1" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
            <div class="relative p-4 w-full max-w-md 2xl:max-w-xl max-h-full">
                <div class="relative bg-crema border border-crema-dark rounded-lg shadow">
                    <div class="p-4 md:p-5 text-center" @submit.prevent="submit()">
                        <h3 class="mb-2 text-lg 2xl:text-xl 3xl:text-2xl font-normal">¿Te has hospedado en este hotel? !Danos tu opinión¡</h3>
                        <form @submit.prevent="submit(city.id)">
                            <div class="flex items-center justify-center mb-3">
                                <div 
                                    v-for="index in 5" 
                                    :key="index"
                                    @mouseover="hoverRating = index"
                                    @mouseleave="hoverRating = 0"
                                    @click="toRank = index; form.calificacion = index;"
                                >
                                    <svg 
                                        class="w-8 h-8 transition-colors duration-300 cursor-pointer text-oro"
                                        aria-hidden="true" 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        :fill="index <= hoverRating || index <= toRank ? 'currentColor' : 'none'"
                                        viewBox="0 0 24 24"
                                    >
                                        <path 
                                            :stroke="index <= hoverRating || index <= toRank ? 'none' : 'currentColor'"
                                            :stroke-width="index <= hoverRating || index <= toRank ? '0' : '2'"
                                            d="M13.8 4.2a2 2 0 0 0-3.6 0L8.4 8.4l-4.6.3a2 2 0 0 0-1.1 3.5l3.5 3-1 4.4c-.5 1.7 1.4 3 2.9 2.1l3.9-2.3 3.9 2.3c1.5 1 3.4-.4 3-2.1l-1-4.4 3.4-3a2 2 0 0 0-1.1-3.5l-4.6-.3-1.8-4.2Z"
                                        />
                                    </svg>
                                </div>
                            </div>
                            <div class="mb-3">
                                <textarea id="review" 
                                    autocomplete="review" 
                                    v-model="form.review"
                                    @input="ajustarAltura" 
                                    rows="1" 
                                    placeholder="Describe tu Experiencia (Opcional)"
                                    class="overflow-hidden resize-none border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                                />
                                <InputError class="mt-2" :message="form.errors.review" />
                            </div>
                            <div class="flex items-center justify-around">
                                <PrimaryButton>Publicar</PrimaryButton>
                                <PrimaryButton @click="closeModal()">Cancelar</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </CustomerLayout>
</template>