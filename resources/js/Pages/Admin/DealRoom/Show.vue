<script setup>
    import { Inertia } from '@inertiajs/inertia';
    import { Head } from '@inertiajs/vue3';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import Forms from '@/Components/Forms.vue';
    import PrimaryLink from '@/Components/PrimaryLink.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';

    const props = defineProps({
        canLogin: Boolean,
        canRegister: Boolean,
        flash: Object,
        deal: Object,
        rooms: Array,
        attached_rooms: Array,
    });

    const agregar = (dealID, roomID) => {
        Inertia.post(route('deal.rooms.attach', {deal: dealID, room: roomID}), {
            onSuccess: () => {
                console.log('Agregado');
            },
        });
    };

    const borrar = (dealID, roomID) => {
        Inertia.post(route('deal.rooms.detach', {deal: dealID, room: roomID}), {
            onSuccess: () => {
                console.log('Borrado');
            },
        });
    };
</script>
<template>
    <Head title="Nueva Habitación" />
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
            <h3 class="text-center text-xl mb-2">Habitaciones incluidas para la oferta {{ deal.nombre }}</h3>
            <div class="grid grid-cols-6 gap-2">
                <button v-for="room in rooms.filter(room => attached_rooms.includes(room.id))" :key="room.id" @click="borrar(deal.id, room.id)" class="w-full bg-rojo border border-rojo-dark text-crema rounded-lg p-3 mb-2">
                    <div class="flex items-center justify-start">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="w-6 h-6">
                                <path fill="currentColor" d="M6 7H5v13a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7zm4 12H8v-9h2zm6 0h-2v-9h2zm.618-15L15 2H9L7.382 4H3v2h18V4z"/>
                            </svg>
                        </span>
                        <span class="ml-2 text-base">N°{{ room.numero }} - {{ room.tipo }}</span>
                    </div>
                </button>
            </div>
            <h3 class="text-center text-xl mb-2">Habitaciones no incluidas para la oferta {{ deal.nombre }}</h3>
            <div class="grid grid-cols-6 gap-2">
                <button v-for="room in rooms.filter(room => !attached_rooms.includes(room.id))" :key="room.id" @click="agregar(deal.id, room.id)" class="w-full bg-rojo-dark border border-rojo text-crema-dark rounded-lg p-3 mb-2">
                    <div class="flex items-center justify-start">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="w-6 h-6">
                                <path fill="currentColor" d="M12 22q-.4 0-.763-.137t-.637-.438l-7.975-8q-.275-.3-.45-.663T2 12t.175-.763t.45-.637l7.975-8q.3-.3.65-.45T12 2t.775.15t.65.45l7.95 8q.275.3.45.65T22 12t-.162.763t-.463.662l-7.95 8q-.275.275-.65.425T12 22m-1-9v2q0 .425.288.713T12 16t.713-.288T13 15v-2h2q.425 0 .713-.288T16 12t-.288-.712T15 11h-2V9q0-.425-.288-.712T12 8t-.712.288T11 9v2H9q-.425 0-.712.288T8 12t.288.713T9 13z"/>
                            </svg>
                        </span>
                        <span class="ml-2 text-base">N°{{ room.numero }} - {{ room.tipo }}</span>
                    </div>
                </button>
            </div>
            <div class="flex items-center justify-start">
                <PrimaryButton type="submit">
                    Agregar
                </PrimaryButton>
                <PrimaryLink class="ms-4" :href="route('admin.deals.show', deal)">
                    Regresar
                </PrimaryLink>
            </div>
        </Forms>
    </AppLayout>
</template>