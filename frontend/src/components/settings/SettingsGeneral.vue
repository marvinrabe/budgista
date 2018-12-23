<template>
    <app-form @submit="save" ref="form">

        <div class="form-row align-items-baseline">
            <div class="col-lg-4">
                <h2 class="h5" v-t="'title.localisation'"></h2>
            </div>
            <div class="col-lg-8">
                <form-group name="language">
                    <select class="form-control w-75"
                            slot-scope="{bindings}"
                            v-bind="bindings"
                            v-model="form.language"
                            v-validate="'required'">
                        <option
                                v-for="language in languages"
                                :key="language"
                                :value="language"
                                v-t="'language.'+language"
                        ></option>
                    </select>
                </form-group>

                <form-group name="locale">
                    <select class="form-control w-75"
                            slot-scope="{bindings}"
                            v-bind="bindings"
                            v-model="form.locale"
                            v-validate="'required'">
                        <option
                                v-for="locale in locales"
                                :key="locale"
                                :value="locale"
                                v-t="'language.'+locale"
                        ></option>
                    </select>
                </form-group>

                <form-group name="currency">
                    <select class="form-control w-75"
                            slot-scope="{bindings}"
                            v-bind="bindings"
                            v-model="form.currency"
                            v-validate="'required'">
                        <option
                                v-for="currency in currencies"
                                :key="currency"
                                :value="currency"
                                v-t="'currency.'+currency">
                        </option>
                    </select>
                </form-group>
            </div>
        </div>

        <div slot="actions">
            <app-button :label="$t('action.save')"
                        :busy="saving">
            </app-button>
        </div>

    </app-form>
</template>

<script>
    import _ from 'lodash'
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
                return languages
            },
            locales() {
                return _.keys(this.$i18n.messages[this.$i18n.locale].language)
            },
            currencies() {
                return _.keys(this.$i18n.messages[this.$i18n.locale].currency)
            }
        },
        mounted() {
            this.reset()
        },
        methods: {
            reset() {
                this.form.language = this.$store.state.user.language
                this.form.locale = this.$store.state.user.locale
                this.form.currency = this.$store.state.user.currency
            },
            save() {
                this.saving = true
                this.$store.dispatch('updateSettings', this.form)
                    .then(() => {
                        this.$snotify.success(this.$t('message.updateSettings'))
                    })
                    .catch(this.$refs.form.error)
                    .finally(() => {
                        this.saving = false
                    })
            }
        }
    }
</script>
