<template>
    <div class="main">

        <window :title="title"></window>

        <div class="toolbar toolbar-primary">
            <div class="d-md-none">
                <button class="btn" type="button" :aria-label="$t('action.back')" v-on:click="cancel">
                    <span class="fa fa-arrow-left"></span>
                </button>
            </div>

            <div class="col-flex h2 mb-0">
                {{ title }}
            </div>
        </div>

        <div class="content content-decorated">
            <div class="container pt-2">
                <div class="form-group">
                    <label for="amount">{{ $t('form.amount')}}</label>
                    <input id="amount" type="number" v-model="amount" class="form-control" step="0.01" autofocus
                           autocomplete="off"
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
        data: () => ({
            'amount': '',
            'date': new Date().toISOString().slice(0, 10),
            'payee': '',
            'category': '',
            'rrule': '',
        }),

        methods: {

            reset() {
                this.amount = '';
                this.date = new Date().toISOString().slice(0, 10);
                this.payee = '';
                this.category = '';
                this.rrule = '';
            },

            cancel() {
                this.reset();
                this.$router.go(-1);
            },
            save() {

                let result = {
                    'amount': this.amount,
                    'date': this.date,
                    'payee': this.payee,
                    'category_id': this.category,
                    'rrule': this.rrule,
                    'account_id': this.account_id
                };

                this.$store.dispatch('createTransaction', result);
                this.reset();

                this.$router.go(-1);
            }
        }
    }
</script>