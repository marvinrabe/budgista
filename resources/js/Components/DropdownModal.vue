<template>
  <b-dropdown-item
    @click="showModal"
    v-t="label"
  >
    <component :is="component" @close="hideModal" v-bind="bind" v-if="visible"></component>
  </b-dropdown-item>
</template>

<script>
  import bDropdownItem from 'bootstrap-vue/es/components/dropdown/dropdown-item'

  export default {
    name: 'DropdownModal',
    props: {
      label: {
        type: String,
        required: true
      },
      component: {
        type: Object,
        required: true
      },
      bind: {
        type: Object,
        default () {
          return {}
        }
      }
    },
    components: {
      bDropdownItem
    },
    data () {
      return {
        visible: false
      }
    },
    methods: {
      showModal () {
        this.visible = true
      },
      hideModal () {
        this.visible = false
      }
    }
  }
</script>
