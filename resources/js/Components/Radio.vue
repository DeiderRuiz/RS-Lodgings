<script setup>
import { computed } from 'vue';

const emit = defineEmits(['update:checked']);

const props = defineProps({
    checked: {
        type: [String, Number],
        default: false,
    },
    value: {
        type: [String, Number],
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>


<template>
    <input
        v-model="proxyChecked"
        type="radio"
        :value="value"
        class="rounded border border-crema-dark text-rojo-dark shadow-sm focus:ring-rojo-dark checked:border-crema-dark"
    >
</template>
