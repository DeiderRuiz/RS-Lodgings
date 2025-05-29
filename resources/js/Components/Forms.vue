<script setup>
    import ApplicationMark from '@/Components/ApplicationMark.vue';
</script>
<template>
    <div class="flex flex-col items-center justify-center p-6">
        <div>
            <ApplicationMark class="block w-14 h-auto" />
        </div>
        <div class="min-w-96 my-3 p-5 bg-crema shadow-md overflow-hidden sm:rounded-lg">
            <slot />
        </div>
    </div>
</template>