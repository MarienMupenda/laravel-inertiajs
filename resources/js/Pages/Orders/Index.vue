<template>
  <Authenticated>
      <div class="container mt-5">
          <table class="table table-borderless main">
              <thead>
              <tr class="head">
                  <th scope="col">No.</th>
                  <th scope="col">Date</th>
                  <th scope="col">Produit</th>
                  <th scope="col">Quantité</th>
                  <th scope="col">Prix</th>
                  <th scope="col">Payment</th>
                  <th scope="col">Livraison</th>
              </tr>
              </thead>
              <tbody>
              <OrderRow v-for="(order, index) in orders" :key="index" :order="order" :index="index"></OrderRow>
              </tbody>
          </table>
      </div>
  </Authenticated>
</template>

<script>
import OrderRow from "@/Components/Orders/OrderRow";
import Authenticated from "@/Layouts/Authenticated";

export default {
    name: "OrdersPage",
    components: {Authenticated, OrderRow},
    props: {
        orders: {
            type: Array,
            default: () => []
        }
    },
}
</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

body{

    background-color: #eee;
    font-family: 'Roboto', sans-serif;
}

.main{

    border-collapse: separate !important;
    border-spacing: 0 11px !important;
}

tr{

    border: 1px solid #eee;
}

.head th{

    font-weight: 500;
}


tr:nth-child(3) { border: solid thin; }

.form-check-input:focus {
    border-color: #8bbafe;
    outline: 0;
    box-shadow: none;
}

.btn{

    height: 27px;
    line-height: 11px;
    color: #fff;
}

.form-check-input {
    width: 1.15em;
    height: 1.15em;
    margin-top: 3px;

}



.btn:focus {
    color: #fff;

    box-shadow: none !important;
}

.order-color{
    color: blue;
}
</style>
