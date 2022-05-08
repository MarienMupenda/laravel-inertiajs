<template>
    <div class="card">
        <div class="badge bg-primary text-white position-absolute" style="top: 0.5rem; right: 0.5rem">
            Verifié
        </div>
        <Link class="text-center" :href="item.link">
            <img style="height: 150px; width: auto" :src="item.image" class="card-img-top img-fluid"
                alt="Phone"
            />
        </Link>
        <div class="card-body">
            <h5 class="card-title">{{ item.name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">{{ item.price }}{{ item.currency }}</h6>
        </div>
    </div>
</template>

<script>
export default {
    name: "ItemCard",
    props: {
        item: {
            type: Object,
            required: true
        }
    },
}
</script>

<style scoped>

</style>
