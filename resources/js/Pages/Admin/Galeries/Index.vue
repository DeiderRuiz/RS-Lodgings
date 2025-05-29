<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { ref } from 'vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import ButtonLinkPrimary from '@/Components/ButtonLinkPrimary.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import Forms from '@/Components/Forms.vue';

    const props = defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        galeries: Array,
        flash: Object,
        location: Object,
    });

    const form = useForm({
        imagen:[],
    });

    function submit(){
        const formData = new FormData();

        // Agrega los campos normales al FormData
        Object.keys(form).forEach(key => { 
            if (key !== 'imagen') {
                formData.append(key, form[key]);
            }
        });
        // Agrega cada archivo de imagen al FormData
        form.imagen.forEach((archivo, index) => {
            formData.append(`imagen[${index}]`, archivo);
        });

        form.post(route('galeries.store', props.location), {
            data:formData,
            processData: false, 
            contentType: false,
        });
    }

    const galeria = event => {
        form.imagen = Array.from(event.target.files);
    }

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

    const borrar = (id) => {
        Inertia.delete(route('galeries.destroy', {galery: id}));
    };
</script>
<template>
    <Head title="Galería" />
    <AppLayout>
        <div v-if="$page.props.flash.message" class="flex items-center justify-center px-12 pt-6">
            <div class="place-self-center w-full p-2 bg-emerald-700 text-crema shadow-md overflow-hidden sm:rounded-lg flex items-center text-sm border border-emerald-900 rounded-lg" role="alert">
                <svg class="flex-shrink-0 inline w-5 h-5 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm13.707-1.293a1 1 0 0 0-1.414-1.414L11 12.586l-1.793-1.793a1 1 0 0 0-1.414 1.414l2.5 2.5a1 1 0 0 0 1.414 0l4-4Z" clip-rule="evenodd"/>
                </svg>
                <p class="font-medium">
                    {{ $page.props.flash.message }}
                </p>
            </div>
        </div>
        <Forms>
            <h3 class="text-2xl text-center">Galería fotos del hotel de {{ location.ciudad }} - {{ location.direccion }}</h3>
            <form @submit.prevent="submit">
                <InputLabel for="imagen" value="Fotos de la galería"/>
                <div class="flex items center justify-center">
                    <div class="w-full">
                        <input id="imagen"
                            @change="galeria"
                            type="file"
                            class="bg-white border border-rojo-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-s-md shadow-sm text-sm block w-full"
                            required
                            multiple
                            autocomplete="imagen"
                        />
                    </div>
                    <button class="inline-flex items-center px-4 py-2 bg-rojo border-t border-b border-rojo-dark text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                        Agregar
                    </button>
                    <a class="inline-flex items-center px-4 py-2 bg-rojo border border-rojo-dark rounded-e-md text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150" :href="route('admin.locations.show', location)">
                        Regresar
                    </a>
                </div>
                <InputError class="mt-2" :message="form.errors.imagen" />
            </form>
            <div class="grid grid-cols-4 gap-4 mt-4">
                <div v-for="galery in galeries" :key="galery.id" class="max-w-sm bg-white border border-rojo-dark rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                    <div class="h-40 w-full overflow-hidden relative">
                        <img class="w-full h-full object-cover object-center rounded-t-lg" :src="galery.imagen" :alt="location.ciudad" />
                    </div>
                    <div>
                        <!-- <button class="flex items-center justify-center w-full inline-flex items-center px-4 py-2 bg-crema border-t border-rojo-dark rounded-b-md text-rojo uppercase tracking-widest hover:bg-crema-dark hover:text-rojo-dark focus:bg-crema-dark active:bg-crema focus:outline-none focus:ring-2 focus:ring-crema-dark focus:ring-offset-2 transition ease-in-out duration-150"> -->
                        <button @click="showModal(galery.id)" class="flex items-center justify-center w-full inline-flex items-center px-4 py-2 bg-rojo border-t border-rojo-dark rounded-b-md text-crema uppercase tracking-widest hover:bg-rojo-dark hover:text-crema-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="w-6 h-6">
                                <path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7zm4 12H8v-9h2zm6 0h-2v-9h2zm.618-15L15 2H9L7.382 4H3v2h18V4z"/>
                            </svg>
                            <span>Borrar</span>
                        </button>
                    </div>
                </div>
            </div>
            <div v-for="galery in galeries" :key="galery.id">
                <div v-if="ventana === galery.id" class="overflow-y-auto overflow-x-hidden fixed top-0 right-0 bottom-0 left-0 z-50 flex justify-center items-center bg-black bg-opacity-50">
                    <div class="relative p-4 w-full max-w-md 2xl:max-w-xl max-h-full">
                        <div class="relative bg-crema border border-crema-dark rounded-lg shadow">
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-rojo w-12 h-12 2xl:w-14 2xl:h-14 3xl:w-16 3xl:h-16" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                                <h3 class="mb-5 text-lg 2xl:text-xl 3xl:text-2xl font-normal">¿Estás seguro de que quieres borrar esta imagen de la galería? Esta acción no se puede deshacer.</h3>
                                <div class="flex items-center justify-around">
                                    <ButtonLinkPrimary @click="borrar(galery.id)">Si, Borrar</ButtonLinkPrimary>
                                    <PrimaryButton @click="closeModal()">No, Cancelar</PrimaryButton>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Forms>
    </AppLayout>
</template>