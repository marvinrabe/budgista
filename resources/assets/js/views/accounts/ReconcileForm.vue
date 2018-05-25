<template>
    <div class="d-flex text-muted flex-column justify-content-center">
        <div class="my-4 text-center">
            <h5 v-t="'title.emptyAccount'"></h5>
            <div class="mt-2">
                <p class="m-0">
                    <span v-t="'message.addTransaction'"></span>
                </p>
                <p class="my-2 small d-none" style="font-weight: 300;">- OR -</p>
                <p class="m-0 d-none">Tell us your current account balance</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            account: {
                type: Object
            }
        }
    }
</script>