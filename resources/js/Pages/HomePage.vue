<template>
<Layout>
    <!-- Header-->
    <header class="bg-dark py-5" style="background-image: url('imxages/front/pexels-kindel-media-6994306.jpg');">
        <div class="container px-4 px-lg-5 my-5 " >
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">La simplicité dans vos achats</h1>
                <p class="lead fw-normal text-white-50 mb-0">Achetez pa mobile money et nous vous livrons partout à Lubumbashi.</p>
            </div>
        </div>
    </header>
    <!-- Section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 mt-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <div v-for="item in topItems" class="col mb-5">
                   <ItemCard :item="item" />
                </div>
            </div>
        </div>
    </section>
</Layout>
</template>

<script>
import ItemCard from "@/Components/ItemCard";
import Layout from "@/Layouts/Layout";

export default {
    name: "HomePage",
    components: {Layout, ItemCard},
    props: {
        recentItems: {
            type: Array,
            default: () => [],
        },
        topItems: {
            type: Array,
            default: () => [],
        },
    },
}
</script>

<style scoped>

</style>
