<template>
  <b-dropdown
    no-caret
    right
    size="sm"
    toggle-class="p-0"
    variant="text-dark"
  >
    <template slot="button-content">
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
