<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <BreezeGuestLayout class="p-3">
        <Head title="Register"/>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <b-form-group
                id="input-group-1"
                label="Name"
                label-for="input-1"
            >
                <b-form-input
                    id="input-1"
                    type="text"
                    v-model="form.name" required autofocus autocomplete="name"
                ></b-form-input>
            </b-form-group>
            <b-form-group
                class="mt-4"
                id="input-group-1"
                label="Email address"
                label-for="input-1"
                description="We'll never share your email with anyone else."
            >
                <b-form-input
                    id="input-1"
                    v-model="form.email"
                    type="email"
                    autocomplete="email"
                    placeholder="Enter email"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group
                class="mt-4"
                id="input-group-1"
                label="Password"
                label-for="input-1"
            >
                <b-form-input
                    placeholder="Enter your password"
                    id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                class="mt-4"
                id="input-group-1"
                label="Confirm Password"
                label-for="input-1"
            >
                <b-form-input
                    id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required autocomplete="new-password"
                ></b-form-input>
            </b-form-group>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    Already registered?
                </Link>
            </div>
            <div class="mt-4">
                <b-button type="submit" variant="primary">Register</b-button>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
