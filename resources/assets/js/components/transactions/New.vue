<script>
    import Form from './Form'

    export default {
        extends: Form,
        props: ['account_id'],
        computed: {
            title() {
                return this.$t('action.new.transaction');
            }
        },

        beforeRouteEnter(to, from, next) {
            next(vm => {
                vm.reset();
                vm.isNew = true;
            })
        },

        beforeRouteUpdate(to, from, next) {
            this.reset();
            this.isNew = true;
        },


        methods: {
            saveTransaction() {
                let transaction = this.getResult();
                transaction.account_id = this.account_id;

                this.$store.dispatch('createTransaction', transaction);

                this.cancel();
            },
            saveAndNew() {
                let transaction = this.getResult();
                transaction.account_id = this.account_id;

                this.$store.dispatch('createTransaction', transaction);

                this.reset();
                this.$nextTick(() => {
                    this.$refs.amount.$el.focus();
                });
            },
        }
    }
</script>