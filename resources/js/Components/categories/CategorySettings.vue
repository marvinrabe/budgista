<template>
  <b-dropdown no-caret right toggle-class="p-2 -my-2">
    <template v-slot:button-content>
      <EllipsisIcon/>
    </template>
    <b-dropdown-item @click="$inertia.visit(category.links.edit)">
      {{ $t('action.edit.category') }}
    </b-dropdown-item>
  </b-dropdown>
</template>

<script>
  import { faEllipsisH } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent, prepareComponent } from '../../helpers'

  export default {
    components: {
      EllipsisIcon: iconComponent({ icon: faEllipsisH })
    },
    props: {
      category: Object
    }
  }
</script>
