<template>
    <span>
        <a class="link-action text-muted" v-b-modal.createCategory :title="$t('action.new.category')">
            <span class="fa fa-plus"></span>
        </a>

        <b-modal id="createCategory"
                 ref="createCategory"
                 :title="$t('action.new.category')"
                 :state="nameState"
                 @ok="handleOk"
                 @shown="clearName">
            <form @submit.stop.prevent="handleSubmit">
                <b-form-input type="text" :placeholder="$t('form.name')" v-model="name"></b-form-input>
            </form>
        </b-modal>
    </span>
</template>

<script>
    export default {
        props: ['budget', 'month'],
        data: () => ({
            name: ''
        }),
        computed: {
            nameState() {
                return this.name.length >= 1 ? 'valid' : 'invalid';
            }
        },
        methods: {
            clearName() {
                this.name = '';
            },
            handleOk(e) {
                e.cancel();
                if (this.name) {
                    this.handleSubmit()
                }
            },
            handleSubmit() {
                axios
                    .post('/api/budgets/' + this.budget + '/categories', {
                        'name': this.name,
                        'month': this.month
                    })
                    .then(response => {
                        this.$emit('newCategory', response.data);
                    })
                    .catch(e => {
                        console.error(e);
                    });

                this.clearName();
                this.$refs.createCategory.hide()
            }
        }
    }
</script>