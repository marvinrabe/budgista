<template>
    <app-form @submit="save" ref="form">

        <h5>{{ $t('title.general') }}</h5>

        <form-group name="language">
            <select class="form-control"
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="form.language"
                    v-validate="'required'">
                <option v-for="language in languages" :value="language" v-html="$t('language.'+language)"></option>
            </select>
        </form-group>

        <form-group name="locale">
            <select class="form-control"
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="form.locale"
                    v-validate="'required'">
                <option v-for="locale in locales" :value="locale" v-html="$t('language.'+locale)"></option>
            </select>
        </form-group>

        <form-group name="currency">
            <select class="form-control"
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="form.currency"
                    v-validate="'required'">
                <option v-for="currency in currencies" :value="currency" v-html="$t('currency.'+currency)"></option>
            </select>
        </form-group>

        <div slot="actions">
            <app-button :label="$t('action.save')" :busy="saving"></app-button>
        </div>

    </app-form>
</template>

<script>
    import {languages} from '../../config.js'

    export default {
        data() {
            return {
                saving: false,
                form: {
                    language: 'en',
                    locale: 'en',
                    currency: 'EUR'
                }
            }
        },
        computed: {
            languages() {
                return languages;
            },
            locales() {
                return _.keys(this.$i18n.messages[this.$i18n.locale].language);
            },
            currencies() {
                return _.keys(this.$i18n.messages[this.$i18n.locale].currency);
            }
        },
        mounted() {
            this.reset();
        },
        methods: {
            reset() {
                this.form.language = this.$store.state.user.language;
                this.form.locale = this.$store.state.user.locale;
                this.form.currency = this.$store.state.user.currency;
            },
            save() {
                this.saving = true;
                this.$store.dispatch('updateSettings', this.form)
                    .then(() => {
                        this.$snotify.success(this.$t('messages.updateSettings'));
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false;
                    });
            }
        }
    }
</script>