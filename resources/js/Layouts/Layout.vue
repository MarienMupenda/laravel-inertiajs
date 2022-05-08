<template>
    <!-- Navigation-->
    <Navigation/>
    <!-- Content-->
        <slot/>
    <!-- Footer-->
    <Footer/>
</template>

<script>
import Navigation from "@/Components/Navigation";
import Footer from "@/Components/Footer";

export default {
    name: "Layout",
    components: {Footer, Navigation}
}
</script>

<style scoped>

</style>
