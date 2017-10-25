<template>
    <div class="budget-column-budget">
        <a class="dummy-input"
           v-show="!edit"
           v-on:click="toggleEdit"
           v-bind:class="[{ 'text-muted': mutableValue == 0 }, 'text-dark']">
            <money-format :value="this.mutableValue"></money-format>
        </a>

        <money-input
                class="text-right py-0 px-1"
                :value="mutableValue"
                @update:value="val => saveEdit(val)"
                v-show="edit"
                ref="input">
        </money-input>
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
                let input = this.$refs.input.$el;
                this.edit = true;

                // Focus input field
                if (this.edit) {
                    Vue.nextTick(function () {
                        input.focus();
                    });
                }
            },

            saveEdit: function (value) {
                if (this.edit) {
                    let result = parseInt(value);
                    if (isNaN(result)) {
                        result = 0;
                    }
                    this.mutableValue = result;
                    this.$emit('update:value', result);
                    this.edit = false;
                }
            }
        }

    }
</script>