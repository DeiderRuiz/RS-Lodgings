<script setup>
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Forms from '@/Components/Forms.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
    });

    const form = useForm({
        ciudad:'',
        direccion:'',
        url:'',
        cellphone_hotel:'',
        descripcion:'',
        portada:null,
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

        form.post(route('admin.locations.store'), {
            data:formData,
            processData: false, 
            contentType: false,
        });
    }

    const portada = (event) => {
        form.portada = event.target.files[0];
    }

    const galeria = event => {
        form.imagen = Array.from(event.target.files);
    }

    const ajustarAltura = (event) => {
      event.target.style.height = '';
      event.target.style.height = event.target.scrollHeight + 'px';
    };
</script>
<template>
    <Head title="Nueva Ubicación" />
    <AppLayout>
        <Forms>
            <h3 class="text-center text-xl mb-2">Nueva Ubicación</h3>
            <form @submit.prevent="submit()">
                <div class="flex items-center justify-center grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <InputLabel for="ciudad" value="Ciudad"/>
                        <TextInput id="ciudad"
                            v-model="form.ciudad"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="ciudad"
                        />
                        <InputError class="mt-2" :message="form.errors.ciudad" />
                    </div>
                    <div>
                        <InputLabel for="direccion" value="Dirección del hotel"/>
                        <TextInput id="direccion"
                            v-model="form.direccion"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="direccion"
                        />
                        <InputError class="mt-2" :message="form.errors.direccion" />
                    </div>
                    <div>
                        <InputLabel for="url" value="Enlace a la página del hotel"/>
                        <TextInput id="url"
                            v-model="form.url"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="url"
                        />
                        <InputError class="mt-2" :message="form.errors.url" />
                    </div>
                    <div>
                        <InputLabel for="cellphone_hotel" value="Número de contacto"/>
                        <TextInput id="cellphone_hotel"
                            v-model="form.cellphone_hotel"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="cellphone_hotel"
                        />
                        <InputError class="mt-2" :message="form.errors.cellphone_hotel" />
                    </div>
                </div>
                <div class="mb-3">
                    <InputLabel for="descripcion" value="Descripción"/>
                    <textarea id="descripcion"
                        v-model="form.descripcion"
                        @input="ajustarAltura"
                        rows="1"
                        class="overflow-hidden resize-none border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                        required
                        autofocus
                        autocomplete="descripcion"
                    />
                    <InputError class="mt-2" :message="form.errors.descripcion" />
                </div>
                <div class="flex items-center justify-center grid grid-cols-2 gap-4 mb-3">
                    <div class="mb-3">
                        <InputLabel for="portada" value="Foto de portada"/>
                        <input id="portada"
                            @change="portada"
                            type="file"
                            class="bg-white border border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="portada"
                        />
                        <InputError class="mt-2" :message="form.errors.portada" />
                    </div>
                    <div class="mb-3">
                        <InputLabel for="imagen" value="Fotos de la galería"/>
                        <input id="imagen"
                            @change="galeria"
                            type="file"
                            class="bg-white border border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                            required
                            autofocus
                            multiple
                            autocomplete="imagen"
                        />
                        <InputError class="mt-2" :message="form.errors.imagen" />
                    </div>
                </div>
                <div class="flex items-center justify-start">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                        Agregar
                    </PrimaryButton>
                    <PrimaryLink class="ms-4" :href="route('admin.locations.index')">
                        Regresar
                    </PrimaryLink>
                </div>
            </form>
        </Forms>
    </AppLayout>
</template>