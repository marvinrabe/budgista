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
    <b-dropdown-item @click="$inertia.visit(group.links.categories.create)">
      {{ $t('action.create.category') }}
    </b-dropdown-item>
    <b-dropdown-divider/>
    <b-dropdown-item @click="$inertia.visit(group.links.edit)">
      {{ $t('action.edit.group') }}
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
      group: Object
    }
  }
</script>
