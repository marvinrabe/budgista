<template>
  <Layout>
    <AppToolbar :title="$t('title.settings')"/>

    <div class="card">
      <div class="card-body">
        <AppForm @submit="save" ref="form">
          <div class="form-row align-items-baseline">
            <div class="col-lg-4">
              <h2
                class="h5"
                v-t="'title.localisation'"
              />
            </div>
            <div class="col-lg-8">
              <FormGroup name="language">
                <select
                  class="form-control w-75"
                  slot-scope="{bindings}"
                  v-bind="bindings"
                  v-model="form.language"
                  v-validate="'required'"
                >
                  <option
                    :key="language"
                    :value="language"
                    v-for="language in languages"
                    v-t="'language.'+language"
                  />
                </select>
              </FormGroup>

              <FormGroup name="locale">
                <select
                  class="form-control w-75"
                  slot-scope="{bindings}"
                  v-bind="bindings"
                  v-model="form.locale"
                  v-validate="'required'"
                >
                  <option
                    :key="locale"
                    :value="locale"
                    v-for="locale in locales"
                    v-t="'language.'+locale"
                  />
                </select>
              </FormGroup>

              <FormGroup name="currency">
                <select
                  class="form-control w-75"
                  slot-scope="{bindings}"
                  v-bind="bindings"
                  v-model="form.currency"
                  v-validate="'required'"
                >
                  <option
                    :key="currency"
                    :value="currency"
                    v-for="currency in currencies"
                    v-t="'currency.'+currency"
                  />
                </select>
              </FormGroup>
            </div>
          </div>

          <div slot="actions">
            <AppButton
              :label="$t('action.save')"
              :loading="saving"
              variant="primary"
            />
          </div>
        </AppForm>
      </div>
    </div>
  </Layout>
</template>

<script>
  import axios from 'axios'
  import Layout from '@/Layouts/Default'
  import AppToolbar from '@/Components/AppToolbar'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup.vue'

  const languages = [] // TODO

  export default {
    components: {
      AppButton,
      AppForm,
      Layout,
      AppToolbar,
      FormGroup
    },
    metaInfo () {
      return {
        title: this.$t('title.settings')
      }
    },
    data () {
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
      languages () {
        return languages
      },
      locales () {
        return Object.keys(this.$i18n.messages[this.$i18n.locale].language)
      },
      currencies () {
        return Object.keys(this.$i18n.messages[this.$i18n.locale].currency)
      }
    },
    methods: {
      save () {
        this.saving = true

        axios
          .put('/user', this.form)
          .then(({ data }) => {
            /*changeLanguage(data.data.language)
            this.$apollo.queries.me.refetch()
            this.$snotify.success(this.$t('message.updateSettings'))*/
          })
          .catch(this.$refs.form.error)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
