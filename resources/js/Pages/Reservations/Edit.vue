<script setup>
    import { watchEffect } from 'vue';
    import { Head, useForm } from '@inertiajs/vue3';
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import Checkbox from '@/Components/Checkbox.vue';
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';

    const props = defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        room: Object, //Información de la habitación a reservar
        reserva: Object,
        exclusive_services: Object, //Objeto de Servicios exclusivos
        services: Object, //Objeto de Otros servicios (Dispobibles para todas las habitaciones)
    });

    //PARA MANEJAR ESTADO Y VALIDACIÓN DEL FORMULARIO
    const form = useForm({
        _method: 'patch',
        //INPUTS (Sus nombres)
        cedula: props.reserva.guest.cedula,
        name: props.reserva.guest.name,
        last_name: props.reserva.guest.last_name,
        cellphone: props.reserva.guest.cellphone,
        email: props.reserva.guest.email,
        fecha_inicio: props.reserva.fecha_inicio,
        fecha_fin: props.reserva.fecha_fin,
        huespedes: props.reserva.huespedes,
        servicios: {},//Objeto vacío del checkbox
    });

    watchEffect(() => {
        if (props.reserva.service && props.reserva.service.length > 0) {
            // Itera sobre los servicios seleccionados
            props.reserva.service.forEach(service => {
                form.servicios[service.id] = true; // Marca el servicio como seleccionado
            });
        }
    });

    const noches = () => {
        if (form.fecha_inicio && form.fecha_fin) {
            const inicio = new Date(form.fecha_inicio);
            const fin = new Date(form.fecha_fin);
            const diferenciaTiempo = fin.getTime() - inicio.getTime();
            let diferenciaDias = diferenciaTiempo / (1000 * 3600 * 24);
            
            if (diferenciaDias >= 1) {
                diferenciaDias -= 1;
            }
    
            return diferenciaDias;
        } else {
            return 0;
        }
    };    

    const precioHuepedesExtras = () =>{
        let total = 0;
        if (form.huespedes > 1) {
            for (const room of props.reserva.rooms) {
                total += room.precio_huesped * (form.huespedes-1);
            }            
        }
        return total;
    }

    const precioNochesExtra = () =>{
        let total = 0;
        if (noches() > 0) {
            for(const room of props.reserva.rooms){
                total += room.precio_noche_extra*(noches());
            }
        }
        return total;
    }

    // Función para calcular la suma del campo precio de los servicios seleccionados
    const calcularTotalPrecioServicios = () => {
        let total = 0;
        // Recorre los servicios exclusivos
        for (const id in form.servicios) {
            if (form.servicios[id]) {
                const servicio = props.exclusive_services.find(servicio => servicio.id === parseInt(id));
                if (servicio) {
                    total += servicio.precio;
                }
            }
        }
        // Recorre los otros servicios
        for (const id in form.servicios) {
            if (form.servicios[id]) {
                const servicio = props.services.find(servicio => servicio.id === parseInt(id));
                if (servicio) {
                    total += servicio.precio;
                }
            }
        }
        return total;
    };

    const precioTotal = () => {
        let total = 0
        for (const room of props.reserva.rooms) {
            total += room.precio + (precioHuepedesExtras()) + (precioNochesExtra()) + (calcularTotalPrecioServicios());
        }
        return total
    }

    //PARA MANDAR LOS DATOS DEL FORMULARIO CON POST (SUBE LA INFORMACIÓN)
    function submit() {
        const formData = new FormData();
        formData.append('_method', 'patch');
        form.post(route('guest.reservations.update', [props.reserva, props.room]));
    }
</script>
<template>
    <Head title="Reservar" />
    <GuestLayout>
        <div class="flex items-center justify-center">
            <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
                <h3 class="text-center">Editar reserva para Habitación(es) N°<span v-for="room in reserva.rooms" :key="room.id">{{ room.numero }}</span></h3>
                <form @submit.prevent="submit()"> <!-- @submit.prevent="submit"previene la recarga de la pagina -->
                    <div class="flex items-center justify-center grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="cedula" value="Cedula de Ciudadania" />
                            <!-- v-model Enlaza el input con el nombre que está en UseForm -->
                            <TextInput id="cedula"
                                v-model="form.cedula"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="cedula" 
                            />
                            <!-- Mensaje de error (con v-bind) -->
                            <InputError class="mt-2" :message="form.errors.cedula" />
                        </div>
                        <div>
                            <InputLabel for="name" value="Nombres" />
                            <!-- v-model Enlaza el input con el nombre que está en UseForm -->
                            <TextInput id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="name" 
                            />
                            <!-- Mensaje de error (con v-bind) -->
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div>
                            <InputLabel for="last_name" value="Apellidos" />
                            <TextInput id="last_name"
                                v-model="form.last_name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="last_name" 
                            />
                            <InputError class="mt-2" :message="form.errors.last_name" />
                        </div>
                        <div>
                            <InputLabel for="cellphone" value="Número De telefono" />
                            <TextInput id="cellphone"
                                v-model="form.cellphone"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="cellphone" 
                            />
                            <InputError class="mt-2" :message="form.errors.cellphone" />
                        </div>
                        <div>
                            <InputLabel for="email" value="Correo Electrónico" />
                            <TextInput id="email"
                                v-model="form.email"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="email" 
                            />
                            <InputError class="mt-2" :message="form.errors.email" />
                        </div>
                        <div>
                            <InputLabel for="fecha_inicio" value="Fecha de inicio" />
                            <TextInput id="fecha_inicio"
                                v-model="form.fecha_inicio"
                                type="date"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="fecha_inicio" 
                            />
                            <InputError class="mt-2" :message="form.errors.fecha_inicio" />
                        </div>
                        <div>
                            <InputLabel for="fecha_fin" value="Fecha de fin" />
                            <TextInput id="fecha_fin"
                                v-model="form.fecha_fin"
                                type="date"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="fecha_fin" 
                            />
                            <InputError class="mt-2" :message="form.errors.fecha_fin" />
                        </div>
                        <div>
                            <InputLabel for="huespedes" value="Número de Huespedes" />
                            <TextInput id="huespedes"
                                v-model="form.huespedes"
                                type="number"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="huespedes" 
                            />
                            <InputError class="mt-2" :message="form.errors.huespedes" />
                        </div>
                    </div>
                    <h5 class="text-rojo mt-4">Servicios generales del hotel <span>(al seleccionar un servicio se aplicará para todas las habitacines de esta reserva)</span></h5>
                    <div class="grid gap-4 grid-cols-3 mb-4">
                        <div v-for="service in services" :key="service.id">
                            <label :for="service.id" class="w-full h-full flex items-center justify-start inline-flex items-center px-4 py-2 bg-rojo border border-rojo-dark rounded-md text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150">
                                <Checkbox class="border-2 border-crema-dark" v-model:checked="form.servicios[service.id]" :value="service.id" :id="service.id" />
                                <span class="ml-2 text-crema">{{ service.nombre }} - {{ service.tipo }} (${{ service.precio }} COP)</span>
                            </label>
                        </div>
                    </div>
                    <h5 class="text-rojo mt-4">Servicios exclusivos para la habitación N°{{ room.numero }}</h5>
                    <div class="grid gap-4 grid-cols-3 mb-4">
                        <div v-for="service in room.services" :key="service.id">
                            <label :for="service.id" class="w-full h-full flex items-center justify-start inline-flex items-center px-4 py-2 bg-rojo border border-rojo-dark rounded-md text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150">
                                <Checkbox class="border-2 border-crema-dark" v-model:checked="form.servicios[service.id]" :value="service.id" :id="service.id" />
                                <span class="ml-2 text-crema">{{ service.nombre }} - {{ service.tipo }} (${{ service.precio }} COP)</span>
                            </label>
                        </div>
                    </div>
                    <div class="grid gap-4 grid-cols-2 mb-4">
                        <div>
                            <div v-if="noches() >= 0">
                                <p>Total De Nohes: {{ noches() + 1 }} (${{ room.precio_noche_extra }} COP por cada noche extra)</p>
                            </div>
                            <!-- Muestra los elementos de -->
                            <!-- <p>{{ form.servicios }}</p> -->
                        </div>
                        <div class="text-right">
                            <h5 class="text-rojo mt-4">Precio a pagar</h5>
                            <p v-for="room in props.reserva.rooms" :key="room.id">Valor De La Habitación N°{{ room.numero }} (1 noche): ${{ room.precio }} COP</p>
                            <p v-if="form.huespedes > 1">Valor Adicional Por {{ form.huespedes-1 }} Huesped(es) Extra(s): ${{ precioHuepedesExtras() }} COP</p>
                            <p v-if="noches() > 0">Valor Adicional Por {{ noches() }} Noche(s) Extra(s):  ${{ precioNochesExtra() }} COP</p>
                            <p v-if="calcularTotalPrecioServicios()">Valor Total De Los Servicios Seleccionados: ${{ calcularTotalPrecioServicios() }} COP</p>
                            <p>Valor Total: ${{ precioTotal() }} COP</p>
                            <!-- parseInt(room.precio) -->
                        </div>
                    </div>
                    <!-- El botón se deshabilita y opaca mientras el formulario se manda -->
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                        Reservar
                    </PrimaryButton>
                    <PrimaryLink class="ms-4" :href="route('guest.reservations.show', reserva)">
                        Regresar
                    </PrimaryLink>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>