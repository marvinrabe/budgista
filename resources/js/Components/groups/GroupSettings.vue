<template>
  <b-dropdown no-caret right toggle-class="p-2 -my-2">
    <template v-slot:button-content>
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
  import { iconComponent } from '@/Utils/Icons'

  export default {
    components: {
      EllipsisIcon: iconComponent({ icon: faEllipsisH })
    },
    props: {
      group: Object
    }
  }
</script>
