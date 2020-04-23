<template>
  <AppForm @submit="save" ref="form">
    <h3
      class="text-lg mb-4"
      v-t="'title.updateProfile'"
    />

    <FormGroup name="name">
      <input
        class="form-input"
        slot-scope="{bindings}"
        type="text"
        v-bind="bindings"
        v-model="form.name"
      >
    </FormGroup>

    <div slot="actions">
      <AppButton
        :label="$t('action.settings.profile')"
        :loading="saving"
        variant="primary"
      />
    </div>
  </AppForm>
</template>

<script>
  import AppButton from '@/Components/form/AppButton'
  import AppForm from '@/Components/form/AppForm'
  import FormGroup from '@/Components/form/FormGroup'

  export default {
    components: {
      AppForm,
      AppButton,
      FormGroup
    },
    data () {
      return {
        form: {
          name: this.$page.user.name
        },
        saving: false
      }
    },
    methods: {
      save () {
        this.saving = true

        this.$inertia
          .post('/profile', this.form)
          .finally(() => {
            this.saving = false
          })
      }
    }
  }
</script>
