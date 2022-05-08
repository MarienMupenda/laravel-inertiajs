<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import {Head, Link, useForm} from '@inertiajs/inertia-vue3';
import Layout from "@/Layouts/Layout";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <BreezeGuestLayout>
        <div class="card">

            <div class="card-body">
                <BreezeValidationErrors class="mb-4"/>

                <div v-if="status" class="mb-4 invalid-feedback" style="display: block">
                    {{ status }}
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <BreezeLabel for="email" value="Email"/>
                        <BreezeInput id="email" type="email" class="form-control" v-model="form.email"
                                     required autofocus
                                     autocomplete="username"/>
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="password" value="Password"/>
                        <BreezeInput id="password" type="password" class="mt-1 form-control"
                                     v-model="form.password" required
                                     autocomplete="current-password"/>
                    </div>

                    <BreezeButton class="mt-4 btn btn-primary" :class="{ 'opacity-25': form.processing }"
                                  :disabled="form.processing">
                        Log in
                    </BreezeButton>

                    <div class="block mt-4">
                        <label class="form-check d-flex justify-content-center">
                            <BreezeCheckbox name="remember" class="form-check-input" v-model:checked="form.remember"/>
                            <span class="form-check-label">Remember me</span>
                        </label>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        <Link v-if="canResetPassword" :href="route('password.request')"
                              class="btn btn-link">
                            Forgot your password?
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </BreezeGuestLayout>

</template>
