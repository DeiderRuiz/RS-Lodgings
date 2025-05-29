<script setup>
    import { Head, useForm } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Forms from '@/Components/Forms.vue';
    import TextInput from '@/Components/TextInput.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import Checkbox from '@/Components/Checkbox.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
    });

    const form = useForm({
        nombre:'',
        tipo:'',
        para_habitacion: false,
        detalles:'',
        precio:'',
    });

    function submit() {
        form.post(route('admin.services.store'));
    }

    const ajustarAltura = (event) => {
      event.target.style.height = '';
      event.target.style.height = event.target.scrollHeight + 'px';
    };
</script>
<template>
    <Head title="Nuevo Servicio" />
    <AppLayout>
        <Forms>
            <h3 class="text-center text-xl mb-2">Nueva Habitación</h3>
            <form @submit.prevent="submit()">
                <div class="flex items-center justify-center grid grid-cols-3 gap-4 mb-3">
                    <div>
                        <InputLabel for="nombre" value="Nombre del servicio" />
                        <TextInput id="nombre"
                            v-model="form.nombre"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="nombre"
                        />
                        <InputError class="mt-2" :message="form.errors.nombre" />
                    </div>
                    <div>
                        <InputLabel for="tipo" value="Tipo de servicio" />
                        <select id="tipo" v-model="form.tipo" class="border border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full" required autofocus autocomplete="tipo">
                            <option value="" disabled>Seleccione el tipo de servicio</option>
                            <option value="Actividades">Actividades</option>
                            <option value="Alimentacion">Alimentacion</option>
                            <option value="Alojamiento">Alojamiento</option>
                            <option value="Instalaciones">Instalaciones</option>
                            <option value="Servicios adicionales">Servicios adicionales</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.tipo" />
                    </div>
                    <div>
                        <InputLabel for="precio" value="Precio del servicio" />
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
                </div>
                <div class="mb-3">
                    <InputLabel for="detalles" value="Detalles del servicio"/>
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
                <div class="mb-3">
                    <InputLabel>
                        <Checkbox v-model:checked="form.para_habitacion" name="para_habitacion" id="para_habitacion"/>
                        <span class="ml-2">Marca si este servicio es exclusivo para para algunas habitaciones</span>
                    </InputLabel>
                </div>
                <div class="flex items-center justify-start">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                        Agregar
                    </PrimaryButton>
                    <PrimaryLink class="ms-4" :href="route('admin.services.index')">
                        Regresar
                    </PrimaryLink>
                </div>
            </form>
        </Forms>
    </AppLayout>
</template>