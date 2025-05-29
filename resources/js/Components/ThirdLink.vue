<script setup>
defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <a :href="href" class="inline-flex items-center px-4 py-2 bg-rojo-dark border border-rojo rounded-md text-xs text-crema uppercase tracking-widest hover:bg-rojo focus:bg-rojo active:bg-rojo-dark focus:outline-none focus:ring-2 focus:ring-rojo focus:ring-offset-2 transition ease-in-out duration-150">
        <slot />
    </a>
</template>