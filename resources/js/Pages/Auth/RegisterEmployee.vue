<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const form = useForm({
    cedula: '',
    name: '',
    last_name: '',
    cellphone: '',
    email: '',
    terms: false,
});

const submit = () => {
    form.post(route('register.employee.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Registro De Empleado" />
    <AppLayout>
        <AuthenticationCard extended>
            <template #logo>
                <AuthenticationCardLogo />
            </template>

            <form @submit.prevent="submit">
                <div class="flex items-center justify-center grid grid-cols-3 gap-2">
                    <div>
                        <InputLabel for="cedula" value="Numero de Identidad" />
                        <TextInput
                            id="cedula"
                            v-model="form.cedula"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="cedula"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    
                    <div>
                        <InputLabel for="name" value="Nombres" />
                        <TextInput
                            id="name"
                            v-model="form.name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>
                    
                    <div>
                        <InputLabel for="last_name" value="Apellidos" />
                        <TextInput
                            id="last_name"
                            v-model="form.last_name"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="last_name"
                        />
                        <InputError class="mt-2" :message="form.errors.last_name" />
                    </div>
                </div>

                <div class="flex items-center justify-center grid grid-cols-2 gap-2">
                    <div class="mt-4">
                        <InputLabel for="cellphone" value="Numero de telefono" />
                        <TextInput
                            id="cellphone"
                            v-model="form.cellphone"
                            type="text"
                            class="mt-1 block w-full"
                            required
                            autofocus
                            autocomplete="cellphone"
                        />
                        <InputError class="mt-2" :message="form.errors.cellphone" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Correo Electrónico" />
                        <TextInput
                            id="email"
                            v-model="form.email"
                            type="email"
                            class="mt-1 block w-full"
                            required
                            autocomplete="username"
                        />
                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>
                </div>

                <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-4">
                    <InputLabel for="terms">
                        <div class="flex items-center">
                            <Checkbox id="terms" v-model:checked="form.terms" name="terms" required />

                            <div class="ms-2">
                                I agree to the <a target="_blank" :href="route('terms.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Terms of Service</a> and <a target="_blank" :href="route('policy.show')" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Privacy Policy</a>
                            </div>
                        </div>
                        <InputError class="mt-2" :message="form.errors.terms" />
                    </InputLabel>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticationCard>
    </AppLayout>
</template>
