<template>
    <Layout>
        <!--single page-->
        <div v-if="$page.props.errors.quantity" class="alert alert-danger" role="alert">
            {{$page.props.errors.quantity}}
        </div>
        <section>
            <div class="container px-4 my-5 px-lg-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="mb-5 card-img-top mb-md-0"
                                               :src="item.image"
                                               alt="..."></div>
                    <div class="col-md-6">
                        <div class="mb-1 small">{{ item.category }}</div>
                        <h1 class="display-5 fw-bolder">{{ item.name }}</h1>
                        <div class="mb-5 fs-5">
                            <span>{{ item.price }} {{ item.currency }}</span>
                        </div>
                        <p class="lead">
                            {{ item.description }}
                        </p>
                        <div class="d-flex">
                            <input @change="changeQty" class="text-center form-control me-3" id="inputQuantity" type="number" value="1"
                                   style="max-width: 3rem">
                            <Link  :href="route('items.checkout',{item:item})" :data="params"
                                  as="button" class="flex-shrink-0 btn btn-outline-dark" type="button">
                                <i class="bi-cart-fill me-1"></i>
                                Commander
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5 bg-light">
            <div class="container px-4 mt-5 px-lg-5">
                <h2 class="mb-4 fw-bolder">Produits similaires</h2>
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div v-for="item in similarItems" class="mb-5 col">
                        <ItemCard :item="item"/>
                    </div>
                </div>
            </div>
        </section>
    </Layout>

</template>

<script>
import Layout from "@/Layouts/Layout";
import ItemCard from "@/Components/ItemCard";

export default {
    name: "ItemShow",
    components: {ItemCard, Layout},
    props: {
        item: {
            type: Object,
            required: true
        },
        similarItems: {
            type: Array,
            required: true
        }
    },
    methods:{
        changeQty(){
            this.params.quantity = document.getElementById('inputQuantity').value
            console.log(this.params)
         }
    },
    data() {
        return {
            params: {
               // item: this.item.id,
                quantity: 1,
               // user: 1
            }
        }
    }

}
</script>
