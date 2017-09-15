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
        methods: {
            save() {
                let transaction = this.getResult();
                transaction.account_id = this.account_id;

                this.$store.dispatch('createTransaction', transaction);
                this.reset();

                this.$router.go(-1);
            }
        }
    }
</script>