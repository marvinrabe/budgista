<template>
    <div class="main">

        <window :title="$t('action.edit.transaction')"></window>

        <div class="toolbar toolbar-primary">
            <div class="d-md-none">
                <button class="btn" type="button" :aria-label="$t('action.back')" v-on:click="cancel">
                    <span class="fa fa-arrow-left"></span>
                </button>
            </div>

            <div class="col-flex h2 mb-0">
                {{ $t('action.edit.transaction') }}
            </div>
        </div>

        <div class="content content-decorated">
            <div class="container pt-2">
                <div class="form-group">
                    <label for="amount">{{ $t('form.amount')}}</label>
                    <input id="amount" type="number" v-model="amount" class="form-control" step="0.01" autofocus autocomplete="off"
                           required>
                </div>

                <div class="form-group">
                    <label for="date">{{ $t('form.date')}}</label>
                    <input id="date" type="date" v-model="date" class="form-control" required>
                </div>

                <recurrence :rule.sync="rrule"></recurrence>

                <div class="form-group">
                    <label for="payee">{{ $t('form.payee')}}</label>
                    <input id="payee" type="text" v-model="payee" class="form-control" autocomplete="off" required>
                </div>

                <div class="form-group">
                    <label for="category">{{ $t('form.category')}}</label>
                    <select id="category" class="form-control" v-model="category">
                        <option value="">{{ $t('form.nullCategory') }}</option>
                    </select>
                </div>

                <div class="text-right">
                    <div class="float-left">
                        <button class="btn btn-outline-danger"
                                :title="$t('action.delete.transaction')"
                                v-on:click="deleteTransaction">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>

                    <button class="btn btn-light" v-on:click="cancel">
                        {{ $t('action.cancel') }}
                    </button>
                    <button class="btn btn-primary" v-on:click="save">
                        {{ $t('action.save') }}
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import store from '../../store'

    export default {
        props: ['transaction_id'],
        components: {
            'recurrence': require('./Recurrence.vue')
        },
        data: () => ({
            'amount': '',
            'date': new Date().toISOString().slice(0,10),
            'payee': '',
            'category': '',
            'rrule': ''
        }),

        beforeRouteEnter (to, from, next) {
            if(store.getters.isTransactionLoaded(to.params.transaction_id)) {
                next(vm => vm.initialize());
                return;
            }

            store.dispatch('getTransaction', to.params.transaction_id).then(() => {
                next(vm => vm.initialize())
            });
        },
        beforeRouteUpdate (to, from, next) {
            if(this.$store.getters.isTransactionLoaded(to.params.transaction_id)) {
                this.initialize();
                next();
                return;
            }
            this.$store.dispatch('getTransaction', to.params.transaction_id).then(() => {
                this.initialize();
                next();
            });
        },

        methods: {
            initialize() {
                let transaction = this.$store.getters.findTransactionById(this.transaction_id);

                this.amount = transaction.amount;
                this.date = transaction.date;
                this.payee = transaction.payee;
                this.category = '';
                if(transaction.category) {
                    this.category = transaction.category.id;
                }
                this.rrule = '';
                if(transaction.recurring) {
                    this.rrule = transaction.rrule;
                }
                this.edit = true;
            },
            cancel() {
                this.$router.go(-1);
            },
            save() {

                let result = {
                    'amount': this.amount,
                    'date': this.date,
                    'payee': this.payee,
                    'category_id': this.category,
                    'rrule': this.rrule,
                    'id': this.transaction_id
                };

                this.$store.dispatch('updateTransaction', result);

                this.$router.go(-1);
            },
            deleteTransaction() {

                let transaction = {
                    'id': this.transaction_id
                };

                this.$store.dispatch('deleteTransaction', transaction);

                this.$router.go(-1);
            }
        }
    }
</script>