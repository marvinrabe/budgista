<template>
    <datepicker input-class="form-control"
                v-bind:value="date"
                v-on:input="date => updateDate(date)"
                v-bind:language="locale"
                v-bind:format="customFormatter">
    </datepicker>
</template>

<style>
    .vdp-datepicker__calendar .cell.selected, .vdp-datepicker__calendar .cell.selected.highlighted, .vdp-datepicker__calendar .cell.selected:hover {
        background-color: #2196F3 !important;
    }
    .vdp-datepicker__calendar .cell:hover {
        border-color: #2196F3 !important;
    }
    .vdp-datepicker input {
        background: #FFF !important;
    }
</style>

<script>
    import Datepicker from 'vuejs-datepicker';

    export default {
        components: {
            Datepicker
        },
        props: {
            value: String
        },
        computed: {
            locale: function () {
                return this.$store.state.locale;
            },
            date: function () {
                return new Date(this.value);
            }
        },
        methods: {
            updateDate: function(newDate) {
                let dateObject = new Date(newDate);
                this.$emit('input', dateObject.toISOString().slice(0, 10));
            },
            customFormatter(date) {
                return Intl.DateTimeFormat(this.locale, {year: 'numeric', month: '2-digit', day: '2-digit'}).format(date);
            }
        }
    }
</script>