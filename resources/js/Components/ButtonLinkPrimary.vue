<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <a href="#" class="inline-flex items-center px-4 py-2 bg-rojo border border-rojo-dark rounded-md text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </a>
</template>