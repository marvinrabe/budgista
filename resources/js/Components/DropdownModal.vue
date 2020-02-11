<template>
  <b-dropdown-item
    @click="showModal"
    v-t="label"
  >
    <component :is="component" @close="hideModal" v-bind="bind" v-if="visible"></component>
  </b-dropdown-item>
</template>

<script>
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
