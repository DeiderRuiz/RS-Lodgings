<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
    additionalClasses: {
        type: String,
        default: '',
    },
});
</script>

<template>
    <button :type="type" :class="additionalClasses" class="inline-flex items-center justify-center px-4 py-2 bg-rojo border border-rojo-dark rounded-md text-xs text-white uppercase tracking-widest hover:bg-rojo-dark focus:bg-rojo-dark active:bg-rojo focus:outline-none focus:ring-2 focus:ring-rojo-dark focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </button>
</template>
