<script setup>
defineProps({
    extended: {
        type: Boolean,
        default: false
    }
});
</script>
<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <slot name="logo" />
        </div>

        <div 
            :class="{'w-full sm:max-w-2xl mt-6 px-6 py-4 bg-crema-light shadow-md overflow-hidden sm:rounded-lg': extended, 
            'w-full sm:max-w-md mt-6 px-6 py-4 bg-crema-light shadow-md overflow-hidden sm:rounded-lg': !extended}"
        >
            <slot />
        </div>
    </div>
</template>
