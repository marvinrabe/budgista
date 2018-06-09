<script>
    import Form from './Form'
    import store from '../../store/index'

    var rrulestr = require('rrule').rrulestr;

    export default {
        extends: Form,
        props: ['transaction_id'],

        computed: {
            title() {
                return this.$t('action.edit.transaction');
            },
            transaction() {
                return this.$store.getters.findTransactionById(this.transaction_id);
            }
        },

        beforeRouteEnter(to, from, next) {
            if (store.getters.isTransactionLoaded(to.params.transaction_id)) {
                next(vm => vm.initialize());
                return;
            }

            store.dispatch('loadTransaction', to.params.transaction_id).then(() => {
                next(vm => vm.initialize())
            });
        },

        beforeRouteUpdate(to, from, next) {
            if (this.$store.getters.isTransactionLoaded(to.params.transaction_id)) {
                this.initialize();
                next();
                return;
            }
            this.$store.dispatch('loadTransaction', to.params.transaction_id).then(() => {
                this.initialize();
                next();
            });
        },

        methods: {
            initialize() {
                this.reset();

                let transaction = this.transaction;

                this.type = 1;
                this.amount = transaction.amount;

                if (transaction.amount < 0) {
                    this.type = -1;
                    this.amount *= -1;
                }

                this.date = transaction.date;
                this.payee = transaction.payee;
                this.category = '';
                if (transaction.category_id) {
                    this.category = transaction.category_id;
                }
                if (transaction.recurring) {
                    let rule = rrulestr(transaction.rrule+";COUNT=1");
                    this.recurring = true;
                    this.freq = rule.options.freq;
                    this.interval = rule.options.interval;
                }
            },
            cancel() {
                this.$router.push({ name: 'account', params: { account_id: this.transaction.account_id }});
            },

            saveTransaction() {
                let transaction = this.getResult();
                transaction.id = this.transaction_id;

                this.$store.dispatch('updateTransaction', transaction);

                this.cancel();
            },

            deleteTransaction() {
                let transaction = {
                    'id': this.transaction_id
                };

                this.$store.dispatch('deleteTransaction', transaction);

                this.cancel();
            }
        }
    }
</script>