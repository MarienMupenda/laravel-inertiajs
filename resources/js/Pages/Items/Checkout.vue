<template>
    <Layout>
        <main class="container p-3">

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                 aria-labelledby="staticBackdropLabel" aria-hidden="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content p-3">
                        <div class="modal-body text-center">
                            <h4>Felications !</h4>
                            <p class="py-3">Veillez entrer le code pin de votre compte pour finaliser cette transaction.</p>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">OK, merci !</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="text-center">
                <img
                    class="d-block mx-auto mb-4"
                    :src="item.image"
                    alt=""
                    style="height: 100px; width: auto"
                />
                <h2>{{ item.name }}{{ quantity }}</h2>
                <p hidden class="lead">
                    Below is an example form built entirely with Bootstrap’s form
                    controls. Each required form group has a validation state that can be
                    triggered by attempting to submit the form without completing it.
                </p>
            </div>

            <div class="row g-5">
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Facture</span>
                        <span class="badge bg-primary rounded-pill">1</span>
                    </h4>
                    <ul class="list-group mb-3">
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ item.name }}</h6>
                                <small class="text-muted">{{}}</small>
                            </div>
                            <span class="text-muted">{{ item.price }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total ({{ item.currency }})</span>
                            <strong>{{ item.price * quantity }}</strong>
                        </li>
                    </ul>

                    <form class="card p-2">
                        <div class="input-group">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Promo code"
                            />
                            <button type="submit" class="btn btn-secondary">Redeem</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Addresse de livraison</h4>
                    <form @submit.prevent="submit" class="needs-validation">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="address" class="form-label">Avenue</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address"
                                    placeholder="1234 Main St"
                                    required
                                />
                                <div class="invalid-feedback">
                                    Please enter your shipping address.
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="address2" class="form-label"
                                >Quartier<span class="text-muted">(Optional)</span></label
                                >
                                <input
                                    type="text"
                                    class="form-control"
                                    id="address2"
                                    placeholder="Apartment or suite"
                                />
                            </div>

                            <div class="col-md-5">
                                <label for="country" class="form-label">Ville</label>
                                <select class="form-select" id="country" required>
                                    <option>Lubumbashi</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid country.
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="state" class="form-label">Commune</label>
                                <select class="form-select" id="state" required>
                                    <option value="">Choisir...</option>
                                    <option>Katuba</option>
                                    <option>Kalondo</option>
                                    <option>Kenya</option>
                                    <option>Lubumbashi</option>
                                    <option>Ruashi</option>
                                    <option>Gecamines</option>
                                    <option>Annexe</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid state.
                                </div>
                            </div>

                            <div class="col-md-3">
                                <label for="zip" class="form-label">Reference</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="zip"
                                    placeholder=""
                                    required
                                />
                            </div>
                        </div>

                        <hr hidden class="my-4"/>

                        <div hidden class="form-check">
                            <input
                                type="checkbox"
                                class="form-check-input"
                                id="same-address"
                            />
                            <label class="form-check-label" for="same-address"
                            >Shipping address is the same as my billing address</label
                            >
                        </div>

                        <div hidden class="form-check">
                            <input type="checkbox" class="form-check-input" id="save-info"/>
                            <label class="form-check-label" for="save-info"
                            >Enregistrer ces informations pour plutard</label
                            >
                        </div>

                        <hr class="my-4"/>

                        <h4 class="mb-3">Payment</h4>

                        <div class="my-3">
                            <div class="d-inline-flex">
                                <img
                                    class="m-1 rounded"
                                    width="80"
                                    src="/img/momo/orange.png"
                                />
                                <img
                                    class="m-1 rounded"
                                    width="80"
                                    src="/img/momo/airtel.png"
                                />
                                <img class="m-1 rounded" width="80" src="/img/momo/mpesa.png"/>
                            </div>
                        </div>

                        <div class="row gy-3">
                            <div class="col-md-8">
                                <label for="pay-number" class="form-label"
                                >Numero de de payement</label
                                >
                                <input
                                    @change="numberChanged"
                                    type="number"
                                    class="form-control"
                                    minlength="10"
                                    maxlength="10"
                                    id="pay-number"
                                    placeholder="0970966587"
                                    required
                                />

                                <div
                                    v-if="$page.props.errors.number"
                                    class="invalid-feedback"
                                    style="display: block"
                                >
                                    {{ $page.props.errors.number }}
                                </div>
                                <small v-else class="text-muted"
                                >Le numero de telephone avec lequel vous souhaitez
                                    payer</small
                                >
                            </div>

                            <div class="col-md-4">
                                <label for="pay-test" class="form-label">---</label>
                                <Link
                                    id="pay-test"
                                    method="post"
                                    :href="route('api.payments.test')"
                                    :data="testParams"
                                    preserve-scroll
                                    as="button"
                                    class="form-control"
                                >Tester avec 100Fc
                                </Link>
                            </div>
                        </div>
                        <button class="w-100 btn btn-primary btn-lg mt-5" type="submit">
                            Payer ({{ item.price * quantity }}{{ item.currency }})
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </Layout>
</template>

<script>
import Layout from "@/Layouts/Layout";
import AlertTest from "@/Components/modals/AlertTest";

export default {
    name: "Checkout",
    components: {AlertTest, Layout},
    props: {
        item: Object,
        quantity: Number,
        number: {
            type: String,
            default: "0970966587",
        },
    },
    methods: {
        numberChanged(e) {
            this.number = e.target.value;
            this.testParams.number = this.number
        },
    },
    computed: {
        testParams() {
            return {
                number: this.number,
            };
        },
    },
};
</script>

<style scoped>
</style>
