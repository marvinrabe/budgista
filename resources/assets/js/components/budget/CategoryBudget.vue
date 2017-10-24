<template>
    <div class="budget-column-budget" v-bind:class="[{ 'py-0': edit}]">
        <a class="dummy-input"
           v-show="!edit"
           v-on:click="toggleEdit"
           v-bind:class="[{ 'text-muted': mutableValue == 0 }, 'text-dark']">
            <money-format :value="this.mutableValue"></money-format>
        </a>

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
        data: () => ({
            mutableValue: 0,
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
                if (this.edit) {
                    let result = parseFloat(this.mutableValue);
                    if (isNaN(result)) {
                        result = 0;
                    }
                    this.$emit('update:value', result);
                    this.edit = false;
                }
            }
        }

    }
</script>