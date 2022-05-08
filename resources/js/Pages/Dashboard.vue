<template>
<Authenticated>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard</div>

                    <div class="card-body">
                        <div v-if="status" class="alert alert-success">
                            {{ status }}
                        </div>
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Head title="Dashboard"/>
</Authenticated>

</template>
<script>
import Authenticated from "@/Layouts/Authenticated";

export default {
    name: "HomePage",
    components: {Authenticated},
}
</script>
