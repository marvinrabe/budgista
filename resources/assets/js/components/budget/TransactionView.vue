<template>
    <div class="main">

        <window :title="title"></window>

        <div class="toolbar toolbar-primary">
            <div class="d-md-none">
                <button class="menu-toggle btn" type="button"
                        aria-controls="menu" :aria-label="$t('action.navigation')">
                    <span class="fa fa-navicon"></span>
                </button>
            </div>

            <div class="col-flex h2 mb-0">
                {{ title }}
            </div>
        </div>

        <div class="content">
            <div class="container pt-2">
                <div class="form-group">
                    <label for="amount">{{ $t('form.amount')}}</label>
                    <input id="amount" type="number" class="form-control" step="0.01" autofocus autocomplete="off"
                           required>
                </div>

                <div class="form-group">
                    <label for="date">{{ $t('form.date')}}</label>
                    <input id="date" type="date" class="form-control" required>
                </div>

                <recurrence rule=""></recurrence>

                <div class="form-group">
                    <label for="payee">{{ $t('form.payee')}}</label>
                    <input id="payee" type="text" class="form-control" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="category">{{ $t('form.category')}}</label>
                    <select id="category" class="form-control">

                    </select>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            account_id: {
                type: String,
                default: null
            },
            transaction_id: {
                type: String,
                default: null
            }
        },
        components: {
            'recurrence': require('./Recurrence.vue')
        },
        computed: {
            title() {
                if (this.account_id !== null) {
                    return this.$t('action.new.transaction');
                } else if (this.transaction_id !== null) {
                    return this.$t('action.edit.transaction');
                }
            }
        },
        watch: {
            account_id() {

            },
            transaction_id() {

            }
        },
        data: () => ({})
    }
</script>