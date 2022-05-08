<template>
    <tr class="rounded bg-white mt-5">
        <td class="order-color">{{order.id}}</td>
        <td>{{order.date}}</td>
        <td class="d-flex align-items-center">
            <img :src="order.item.image" class="img-fluid" width="25">
            <span class="ml-2">{{order.item.name}}</span>
        </td>
        <td>
            {{order.quantity}}
        </td>
        <td> {{order.price}}</td>
        <td><span class="badge bg-primary">Primary</span></td>
        <td><span class="badge bg-primary">Primary</span></td>
    </tr>
</template>

<script>
export default {
    name: "OrderRow",
    props: {
        order: {
            type: Object,
            required: true
        }
    },
}
</script>
