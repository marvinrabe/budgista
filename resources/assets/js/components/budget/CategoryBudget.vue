<template>
    <div v-bind:class="[{ 'py-0': edit }]" class="text-right">
        <div class="link-action width-100"
           v-show="!edit"
           v-on:click="toggleEdit"
           v-bind:class="[{ 'text-muted': mutableValue == 0 }, 'text-dark']">
            {{ formattedValue }}
        </div>

        <input type="number"
               class="form-control form-control-sm text-right"
               step="0.01"
               v-model="mutableValue"
               ref="input"
               v-show="edit"
               v-on:keyup.enter="saveEdit"
               v-on:blur="saveEdit">
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: Number,
                required: true
            }
        },
        computed: {
            formattedValue: function () {
                return this.$formatNumber(this.mutableValue, {style: 'currency', currency: window.currency});
            }
        },
        data: () => ({
            mutableValue: this.value,
            edit: false
        }),
        watch: {
            value: function () {
                this.mutableValue = this.value
            }
        },
        created: function () {
            this.mutableValue = this.value;
        },
        methods: {
            toggleEdit: function () {
                let input = this.$refs.input;
                this.edit = true;

                // Focus input field
                if (this.edit) {
                    Vue.nextTick(function () {
                        input.focus();
                        input.select();
                    });
                }
            },

            saveEdit: function () {
                if(this.edit) {
                    this.$emit('update:value', parseFloat(this.mutableValue));
                    this.edit = false;
                }
            }
        },

    }
</script>