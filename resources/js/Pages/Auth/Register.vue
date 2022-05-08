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
    <BreezeGuestLayout>
        <Head title="Register"/>

        <BreezeValidationErrors class="mb-4"/>

        <form @submit.prevent="submit">
            <b-form-group
                id="input-group-1"
                label="Name"
                label-for="input-1"
                description="We'll never share your email with anyone else."
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
                description="We'll never share your email with anyone else."
            >
                <b-form-input
                    placeholder="Enter email"
                    id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
                    autocomplete="new-password"
                ></b-form-input>
                <b-form-invalid-feedback :state="validation">
                    Your user ID must be 5-12 characters long.
                </b-form-invalid-feedback>
                <b-form-valid-feedback :state="validation"> Looks Good. </b-form-valid-feedback>
            </b-form-group>

            <b-form-group
                class="mt-4"
                id="input-group-1"
                label="Confirm Password"
                label-for="input-1"
                description="We'll never share your email with anyone else."
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

                <BreezeButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </BreezeButton>
            </div>
        </form>
    </BreezeGuestLayout>
</template>
