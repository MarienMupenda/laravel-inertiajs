<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <Link class="navbar-brand" href="/">UZARAKA</Link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><Link class="nav-link active" aria-current="page" href="/">Accueil</Link></li>
                    <li class="nav-item"><!--suppress HtmlExtraClosingTag -->
                        <Link class="nav-link" href="#!">A propos</Link></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">Tous les produits</a></li>
                            <li><hr class="dropdown-divider" /></li>
                            <li><a class="dropdown-item" href="#!">Plus populaires</a></li>
                            <li><a class="dropdown-item" href="#!">Recents</a></li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex">
                    <Link :href="route('orders.index')" class="btn btn-outline-dark" as="button">
                        <i class="bi-cart-fill me-1"></i>
                        Commandes
                        <span v-if="$page.props.order_count" class="badge bg-dark text-white ms-1 rounded-pill">{{ $page.props.order_count }}</span>
                    </Link>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navigation"
}
</script>

<style scoped>

</style>
