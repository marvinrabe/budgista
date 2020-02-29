<template>
  <Layout :title="$t('title.general')">
    <div class="card">
      <div class="card-header">
        <h2 class="text-xl">
          {{ $t('title.general') }}
        </h2>
      </div>
      <div class="card-body">
        <AppForm @submit="save" ref="form">
          <div class="flex flex-wrap items-baseline">
            <div class="w-full lg:w-4/12">
              <h3
                class="text-xl mb-2"
                v-t="'title.localisation'"
              />
            </div>
            <div class="w-full lg:w-8/12">
              <FormGroup name="currency">
                <select
                  class="form-control w-75"
                  slot-scope="{bindings}"
                  v-bind="bindings"
                  v-model="form.currency"
                >
                  <option
                    :key="currency"
                    :value="currency"
                    v-for="currency in currencies"
                    v-t="'currency.'+currency"
                  />
                </select>
              </FormGroup>

              <FormGroup name="language">
                <select
                  class="form-control w-75"
                  slot-scope="{bindings}"
                  v-bind="bindings"
                  v-model="form.language"
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
                >
                  <option
                    :key="locale"
                    :value="locale"
                    v-for="locale in locales"
                    v-t="'language.'+locale"
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
  import Layout from '@/Pages/Settings/Index'
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup.vue'
  import { availableLanguages } from '@/Utils/Language'

  export default {
    components: {
      AppButton,
      AppForm,
      Layout,
      FormGroup
    },
    data () {
      return {
        form: {
          language: this.$page.user.language,
          locale: this.$page.user.locale,
          currency: this.$page.user.currency
        },
        saving: false
      }
    },
    computed: {
      languages () {
        return availableLanguages
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

        this.$inertia
          .post('/settings', this.form)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
