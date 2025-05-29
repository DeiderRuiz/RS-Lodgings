<script setup>
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Forms from '@/Components/Forms.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const props = defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
    });

    const form = useForm({
        numero: '',
        tipo: '',
        detalles: '',
        vista: null,
        precio: '',
        precio_huesped: '',
        precio_noche_extra: '',
    });

    function submit() {
        const formData = new FormData();
        Object.keys(form).forEach(key => { 
            formData.append(key, form[key]); 
        });
        form.post(route('admin.rooms.store'), {
            data: formData, 
            processData: false, 
            contentType: false,
        });
    }

    const ajustarAltura = (event) => {
      event.target.style.height = '';
      event.target.style.height = event.target.scrollHeight + 'px';
    };

    const vista = (event) => {
        form.vista = event.target.files[0];
    };
</script>
<template>
    <Head title="Nueva Habitación" />
    <AppLayout>
        <Forms>
            <h3 class="text-center text-xl mb-2">Nueva Habitación</h3>
            <form @submit.prevent="submit()">
                <div class="flex items-center justify-center grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <InputLabel for="numero" value="Número de la habitación" />
                        <TextInput id="numero"
                            v-model="form.numero"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="numero"
                        />
                        <InputError class="mt-2" :message="form.errors.numero" />
                    </div>
                    <div>
                        <InputLabel for="tipo" value="Tipo de habitación"/>
                        <select id="tipo"
                            v-model="form.tipo"
                            autocomplete="tipo"
                            class="border border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                            required
                        >
                            <option value="" disabled>Seleccione el tipo de habitación</option>
                            <option value="Individual">Individual</option>
                            <option value="Doble">Doble</option>
                            <option value="Suite">Suite</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.tipo" />
                    </div>
                </div>
                <div class="mb-3">
                    <InputLabel for="vista" value="Seleccionar una vista de la habitación"/>
                    <input id="vista" 
                        @change="vista"
                        autocomplete="vista"
                        required 
                        type="file" 
                        class="bg-white border border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.vista" />
                </div>
                <div class="mb-3">
                    <InputLabel for="detalles" value="Detalles de la habitación"/>
                    <textarea id="detalles" 
                        v-model="form.detalles" 
                        autocomplete="detalles" 
                        @input="ajustarAltura" 
                        rows="1" 
                        required 
                        class="overflow-hidden resize-none border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.detalles" />
                </div>
                <div class="flex items-center justify-center grid grid-cols-3 gap-4">
                    <div>
                        <InputLabel for="precio" value="Precio de una noche"/>
                        <TextInput id="precio"
                            v-model="form.precio"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="precio"
                        />
                        <InputError class="mt-2" :message="form.errors.precio" />
                    </div>
                    <div>
                        <InputLabel for="precio_huesped" value="Precio de huésped adicional"/>
                        <TextInput id="precio_huesped"
                            v-model="form.precio_huesped"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="precio_huesped"
                        />
                        <InputError class="mt-2" :message="form.errors.precio_huesped" />
                    </div>
                    <div>
                        <InputLabel for="precio_noche_extra" value="Precio de noches extras"/>
                        <TextInput id="precio_noche_extra"
                            v-model="form.precio_noche_extra"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="precio_noche_extra"
                        />
                        <InputError class="mt-2" :message="form.errors.precio_noche_extra" />
                    </div>
                    <div class="flex items-center justify-start">
                        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                            Agregar
                        </PrimaryButton>
                        <PrimaryLink class="ms-4" :href="route('admin.rooms.index')">
                            Regresar
                        </PrimaryLink>
                    </div>
                </div>
            </form>
        </Forms>
    </AppLayout>
</template>