<template>
    <portal to="modal">
        <transition name="modal">
            <div class="modal d-block" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-html="title"></h5>
                            <button type="button" class="close" @click="$emit('close')" aria-label="Close">
                                <font-awesome-icon icon="times"/>
                            </button>
                        </div>
                        <div class="modal-body">
                            <slot></slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </portal>
</template>

<style lang="scss">

    .modal {
        background-color: rgba(0, 0, 0, .5);
        display: block;
        transition: opacity .3s ease;

        &-dialog {
            transition: all .3s ease;
        }

        &-content {
            box-shadow: rgba(0, 0, 0, 0.04) 0 3px 6px 0;
        }

        &-header {
            border: 0;

            .close {
                cursor: pointer;
                line-height: 1.5em;
                font-size: 1.25em;
            }
        }

        &-body {
            padding-top: 0;

            .form-group:last-child {
                margin-bottom: 0;
            }
        }
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
        props: ['title'],
        inject: ['$validator']
    }
</script>