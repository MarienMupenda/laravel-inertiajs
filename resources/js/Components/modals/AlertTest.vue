<template>
    <div>
        <b-button v-b-modal.modal-1>Launch demo modal</b-button>

        <b-modal id="modal-1" title="BootstrapVue">
            <p class="my-4">Hello from modal!</p>
        </b-modal>
    </div>
    <b-alert show>Default Alert</b-alert>
    <b-alert variant="success" show>Success Alert</b-alert>
    <b-alert v-model="showDismissibleAlert" variant="danger" dismissible> Dismissible Alert!</b-alert>

</template>
<script>
export default {
    name: "AlertTest"
}
</script>

<style scoped>

</style>
