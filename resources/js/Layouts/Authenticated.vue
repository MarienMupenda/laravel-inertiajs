<script setup>
import { ref } from 'vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <Link class="navbar-brand" :href="route('home')">
                UZARAKA
            </Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <Link class="nav-link" :href="route('orders.index')">
                            <i class="fas fa-home"></i>
                            <span class="d-md-inline d-none">Commandes</span>
                            <span v-if="$page.props.order_count" class="badge bg-dark text-white ms-1 rounded-pill">{{ $page.props.order_count }}</span>

                        </Link>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Profile
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <Link as="button" class="dropdown-item">
                                {{ $page.props.auth.user.name }}
                            </Link>
                            <Link as="button" class="dropdown-item" :href="route('home')">
                                Store
                            </Link>
                            <Link as="button" method="post" class="dropdown-item" :href="route('logout')">
                                Logout
                            </Link>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <slot/>
</template>
