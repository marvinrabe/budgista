<template>
    <form :class="[{'was-validated': validated}]"
          @submit.stop.prevent="submit"
          novalidate>
        <slot></slot>

        <div class="text-right">
            <slot name="actions"></slot>
        </div>
    </form>
</template>

<script>
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
                    this.validated = true;

                    if (isValid) {
                        this.$emit('submit');
                    }
                });
            }
        }
    }
</script>