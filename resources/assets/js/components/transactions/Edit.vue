<script>
    import Form from './Form'
    import store from '../../store/index'

    /*
    <div class="float-left">
                        <button class="btn btn-outline-danger"
                                :title="$t('action.delete.transaction')"
                                v-on:click="deleteTransaction">
                            <span class="fa fa-trash"></span>
                        </button>
                    </div>
     */

    export default {
        extends: Form,
        props: ['transaction_id'],

        computed: {
            title() {
                return this.$t('action.edit.transaction');
            }
        },

        beforeRouteEnter(to, from, next) {
            if (store.getters.isTransactionLoaded(to.params.transaction_id)) {
                next(vm => vm.initialize());
                return;
            }

            store.dispatch('getTransaction', to.params.transaction_id).then(() => {
                next(vm => vm.initialize())
            });
        },

        beforeRouteUpdate(to, from, next) {
            if (this.$store.getters.isTransactionLoaded(to.params.transaction_id)) {
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

                this.type = 1;
                this.amount = transaction.amount;

                if(transaction.amount < 0) {
                    this.type = -1;
                    this.amount *= -1;
                }

                this.date = transaction.date;
                this.payee = transaction.payee;
                this.category = '';
                if (transaction.category) {
                    this.category = transaction.category.id;
                }
                this.rrule = '';
                if (transaction.recurring) {
                    this.rrule = transaction.rrule;
                }
                this.edit = true;
            },

            save() {

                let transaction = this.getResult();
                transaction.id = this.transaction_id;

                this.$store.dispatch('updateTransaction', transaction);

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