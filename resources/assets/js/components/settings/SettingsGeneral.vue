<template>
    <app-form @submit="save">

        <h5>{{ $t('title.general') }}</h5>

        <form-group name="language">
            <select class="form-control"
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="form.language"
                    v-validate.initial="'required'">
                <option v-for="language in languages" :value="language" v-html="$t('language.'+language)"></option>
            </select>
        </form-group>

        <form-group name="locale">
            <select class="form-control"
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="form.locale"
                    v-validate.initial="'required'">
                <option v-for="locale in locales" :value="locale" v-html="$t('locale.'+locale)"></option>
            </select>
        </form-group>

        <form-group name="currency">
            <select class="form-control"
                    slot-scope="{bindings}"
                    v-bind="bindings"
                    v-model="form.currency"
                    v-validate.initial="'required'">
                <option v-for="currency in currencies" :value="currency" v-html="$t('currency.'+currency)"></option>
            </select>
        </form-group>

        <div slot="actions">
            <button class="btn btn-text-light" @click.prevent="reset">
                {{ $t('action.cancel') }}
            </button>

            <button class="btn btn-primary">
                {{ $t('action.save') }}
            </button>
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
                return [];
            },
            currencies() {
                return [];
            }
        },
        mounted() {
            this.reset();
        },
        methods: {
            reset() {
                this.form.language = this.$store.state.language;
                this.form.locale = this.$store.state.locale;
                this.form.currency = this.$store.state.currency;
            },
            save() {
                console.log('save');
            }
        }
    }
</script>