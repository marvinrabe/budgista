<template>
    <div>
        <input class="form-control"
               type="text"
               list="payees"
               v-bind="$attrs"
               :value="value"
               @input="e => $emit('input', e.target.value)"
               v-validate="'required'">
        <datalist id="payees">
            <option v-for="payee in getPayees" :key="payee" :value="payee"/>
        </datalist>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        inheritAttrs: false,
        props: ['value'],
        computed: {
            ...mapGetters([
                'getPayees'
            ])
        }
    }
</script>
