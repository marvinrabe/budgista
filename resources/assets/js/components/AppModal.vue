<template>
    <transition name="modal">
        <div class="modal d-block" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-html="title"></h5>
                        <button type="button" class="close" @click="$emit('close')" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <slot name="body"></slot>
                    </div>
                    <div class="modal-footer">
                        <slot name="footer"></slot>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<style>
    .modal {
        background-color: rgba(0, 0, 0, .5);
        transition: opacity .3s ease;
    }

    .modal-dialog {
        transition: all .3s ease;
    }

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-dialog,
    .modal-leave-active .modal-dialog {
        transform: scale(1.1);
    }
</style>

<script>
    export default {
        props: ['title']
    }
</script>