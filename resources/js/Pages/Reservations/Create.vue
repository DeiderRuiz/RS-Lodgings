<script setup>
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
        services: Object, //Objeto de Otros servicios (Dispobibles para todas las habitaciones)
    });

    //PARA MANEJAR ESTADO Y VALIDACIÓN DEL FORMULARIO
    const form = useForm({
        //INPUTS (Sus nombres)
        cedula: '',
        name: '',
        last_name: '',
        cellphone: '',
        email: '',
        fecha_inicio: '',
        fecha_fin: '',
        huespedes: '',
        servicios: {},//Objeto vacío del checkbox
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
            return null;
        }
    };

    let precioHuespedExtra = 0;

    // Función para calcular la suma del campo precio de los servicios seleccionados
    const calcularTotalPrecioServicios = () => {
        let total = 0;
        // Recorre los servicios exclusivos
        for (const id in form.servicios) {
            if (form.servicios[id]) {
                const servicio = props.room.services.find(servicio => servicio.id === parseInt(id));
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

    //PARA MANDAR LOS DATOS DEL FORMULARIO CON POST (SUBE LA INFORMACIÓN)
    function submit() {
        form.post(route('guest.reservations.store', props.room));
    }
</script>
<template>
    <Head title="Reservar" />
    <GuestLayout>
        <div class="flex items-center justify-center">
            <div class="w-full sm:max-w-6xl my-6 p-6 bg-crema shadow-md overflow-hidden sm:rounded-lg prose text-black">
                <h3 class="text-center">Reservar Habitación N°{{ room.numero }}</h3>
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
                            <label :for="service.id" class="w-full h-full flex items-center justify-start inline-flex items-center px-4 py-2 bg-rojo border border-rojo-dark rounded-md text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                                <Checkbox class="border-2 border-crema-dark" v-model="form.servicios[service.id]" :value="service.id" :id="service.id" />
                                <span class="ml-2 text-crema">{{ service.nombre }} - {{ service.tipo }} (${{ service.precio }} COP)</span>
                            </label>
                        </div>
                    </div>
                    <h5 class="text-rojo mt-4">Servicios exclusivos para la habitación N°{{ room.numero }}</h5>
                    <div class="grid gap-4 grid-cols-3 mb-4">
                        <div v-for="service in room.services" :key="service.id">
                            <label :for="service.id" class="w-full h-full flex items-center justify-start inline-flex items-center px-4 py-2 bg-rojo border border-rojo-dark rounded-md text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150 cursor-pointer">
                                <Checkbox class="border-2 border-crema-dark" v-model="form.servicios[service.id]" :value="service.id" :id="service.id" />
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
                            <p>Valor De La Habitación (1 noche): ${{ room.precio }} COP</p>
                            <p v-if="form.huespedes > 1">Valor Adicional Por {{ form.huespedes-1 }} Huesped(es) Extra(s): ${{ precioHuespedExtra = room.precio_huesped * (form.huespedes-1) }} COP</p>
                            <p v-if="noches() > 0">Valor Adicional Por {{ noches() }} Noche(s) Extra(s):  ${{ room.precio_noche_extra*(noches()) }} COP</p>
                            <p v-if="calcularTotalPrecioServicios()">Valor Total De Los Servicios Seleccionados: ${{ calcularTotalPrecioServicios() }} COP</p>
                            <p>Valor Total: ${{ room.precio + precioHuespedExtra + (room.precio_noche_extra*(noches())) + calcularTotalPrecioServicios() }} COP</p>
                            <!-- parseInt(room.precio) -->
                        </div>
                    </div>
                    <!-- El botón se deshabilita y opaca mientras el formulario se manda -->
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" type="submit">
                        Reservar
                    </PrimaryButton>
                    <PrimaryLink class="ms-4" :href="route('guest.rooms.index')">
                        Regresar
                    </PrimaryLink>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>