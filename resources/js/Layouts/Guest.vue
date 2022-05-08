<script setup>
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import {Link} from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <BreezeApplicationLogo class="img-fluid"/>
                </div>

                <div class="container">
                    <slot/>
                </div>
            </div>
        </div>
    </div>
</template>
