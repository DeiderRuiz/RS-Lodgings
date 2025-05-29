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
        deal: Object,
    });

    const form = useForm({
        _method:'patch',
        nombre: props.deal.nombre,
        tipo_de_oferta: props.deal.tipo_de_oferta,
        descripcion: props.deal.descripcion,
        descuento: props.deal.descuento*100,
        fecha_de_inicio: props.deal.fecha_de_inicio,
        fecha_de_fin: props.deal.fecha_de_fin,
        noches_minimas: props.deal.noches_minimas,
        vista: null,
    });

    function submit() {
        const formData = new FormData();
        Object.keys(form).forEach(key => { 
            formData.append(key, form[key]); 
        });

        formData.append('_method', 'patch');

        form.post(route('admin.deals.update', props.deal.id), {
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
    <Head title="Actualizar Oferta" />
    <AppLayout>
        <Forms>
            <h3 class="text-center text-xl mb-2">Acualizar oferta {{ deal.nombre }}</h3>
            <form @submit.prevent="submit()">
                <div class="flex items-center justify-center grid grid-cols-4 gap-4 mb-3">
                    <div>
                        <InputLabel for="nombre" value="Nombre de la oferta"/>
                        <TextInput id="nombre"
                            v-model="form.nombre"
                            type="text"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="nombre"
                        />
                        <InputError class="mt-2" :message="form.errors.nombre"/>
                    </div>
                    <div>
                        <InputLabel for="tipo_de_oferta" value="Tipo de oferta"/>
                        <select id="tipo_de_oferta" v-model="form.tipo_de_oferta" class="border border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full" required autofocus autocomplete="tipo_de_oferta">
                            <option value="" deisabled>Seleccione el tipo de oferta</option>
                            <option value="Temporada">Temporada</option>
                            <option value="Duración">Duración</option>
                            <option value="Especial">Especial</option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.tipo_de_oferta"/>
                    </div>
                    <div>
                        <InputLabel for="descuento" value="Descuento"/>
                        <TextInput id="descuento"
                            v-model="form.descuento"
                            type="number"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="descuento"
                        />
                        <InputError class="mt-2" :message="form.errors.descuento"/>
                    </div>
                    <div>
                        <InputLabel for="noches_minimas" value="Noches minimas"/>
                        <TextInput id="noches_minimas"
                            v-model="form.noches_minimas"
                            type="number"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="noches_minimas"
                        />
                        <InputError class="mt-2" :message="form.errors.noches_minimas"/>
                    </div>
                </div>
                <div class="mb-3">
                    <InputLabel for="descripcion" value="Descripción"/>
                    <textarea id="descripcion"
                        v-model="form.descripcion"
                        autocomplete="descripcion"
                        @input="ajustarAltura"
                        rows="1"
                        required
                        class="overflow-hidden resize-none border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.descripcion"/>
                </div>
                <div class="flex items-center justify-center grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <InputLabel for="fecha_de_inicio" value="Inicio de la oferta"/>
                        <TextInput id="fecha_de_inicio"
                            v-model="form.fecha_de_inicio"
                            type="date"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="fecha_de_inicio"
                        />
                        <InputError class="mt-2" :message="form.errors.fecha_de_inicio"/>
                    </div>
                    <div>
                        <InputLabel for="fecha_de_fin" value="Fin de la oferta"/>
                        <TextInput id="fecha_de_fin"
                            v-model="form.fecha_de_fin"
                            type="date"
                            class="mt-1 text-sm block w-full"
                            required
                            autofocus
                            autocomplete="fecha_de_fin"
                        />
                        <InputError class="mt-2" :message="form.errors.fecha_de_fin"/>
                    </div>
                </div>
                <div class="mb-3">
                    <InputLabel for="vista" value="Seleccionar portada de la oferta"/>
                    <input id="vista"
                        @change="vista"
                        autocomplete="vista"
                        type="file"
                        class="bg-white border border-crema-dark focus:border-rojo-dark focus:ring-rojo-dark rounded-md shadow-sm mt-1 text-sm block w-full"
                    />
                    <InputError class="mt-2" :message="form.errors.vista" />
                </div>
                <div class="flex items-center justify-start">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                        Agregar
                    </PrimaryButton>
                    <PrimaryLink class="ms-4" :href="route('admin.deals.index')">
                        Regresar
                    </PrimaryLink>
                </div>
            </form>
        </Forms>
    </AppLayout>
</template>