<template>
    <form @submit.stop.prevent="submit"
          novalidate>
        <slot></slot>

        <div class="d-flex justify-content-end align-items-baseline">
            <slot name="actions"></slot>
        </div>
    </form>
</template>

<script>
    import _ from 'lodash'

    export default {
        inject: ['$validator'],
        data() {
            return {
                saving: false,
                validated: false
            }
        },
        methods: {
            submit() {
                // this.errors.clear('settings.general');
                this.$validator.validateAll().then(isValid => {
                    this.validated = true

                    if (isValid) {
                        this.$emit('submit')
                    }
                })
            },
            clearErrors() {
                this.errors.clear()
                this.$validator.reset()
            },
            addError(field, message) {
                if (_.has(this.fields, field)) {
                    this.errors.add(field, message, 'server')
                    this.$validator.flag(field, {
                        invalid: true,
                        valid: false,
                        dirty: true
                    })
                } else {
                    this.$snotify.error(message)
                }
            },
            error(exception) {
                if (_.has(exception, 'response.data.errors')) {
                    let serverErrors = exception.response.data.errors
                    const keys = _.keys(serverErrors)
                    keys.forEach((key) => {
                        let message = _.head(serverErrors[key])
                        this.addError(key, message)
                    })
                } else {
                    this.$snotify.error(this.$t('message.unexpectedError'))
                    throw exception
                }
            }
        }
    }
</script>