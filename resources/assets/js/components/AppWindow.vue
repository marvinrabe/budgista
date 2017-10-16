<script>
    export default {
        name: 'window',
        props: ['title'],
        created() {
            this.updateTitle(this.title);
        },
        watch: {
            title() {
                this.updateTitle(this.title);
            }
        },
        render() {
            // Has to be defined.
        },
        methods: {
            updateTitle: function (title) {
                if (title.length) {
                    document.title = title + ' - ' + this.$t('app.name');
                } else {
                    document.title = this.$t('app.name');
                }
            }
        }
    }
</script>