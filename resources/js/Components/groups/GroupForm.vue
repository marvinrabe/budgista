<template>
  <AppForm @submit="save" ref="form">
    <FormGroup name="name">
      <input
        class="form-control"
        slot-scope="{bindings}"
        type="text"
        v-bind="bindings"
        v-focus
        v-model="name"
        v-validate="'required'"
      >
    </FormGroup>

    <template slot="actions">
      <AppButton
        :label="$t('action.cancel')"
        @click="cancel"
        subtle
      />

      <AppButton
        :label="$t('action.save')"
        :loading="saving"
        variant="primary"
      />
    </template>
  </AppForm>
</template>

<script>
  import AppButton from '../form/AppButton'
  import AppForm from '../form/AppForm'
  import FormGroup from '../form/FormGroup'

  export default {
    props: {
      value: {
        type: Object,
        default () {
          return {}
        }
      },
      saving: {
        type: Boolean,
        default: false
      }
    },
    components: {
      AppButton,
      AppForm,
      FormGroup
    },
    data () {
      return {
        name: '',
        ...this.value
      }
    },
    watch: {
      value: {
        immediate: true,
        handler () {
          this.name = this.value.name
        }
      }
    },
    methods: {
      save () {
        this.$emit('save', {
          name: this.name
        })
      },
      cancel () {
        this.name = this.value.name
        this.$emit('cancel')
      },
      error (error) {
        this.$refs.form.error(error)
      }
    }
  }
</script>
