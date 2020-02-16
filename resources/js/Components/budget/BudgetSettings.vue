<template>
  <b-dropdown no-caret right>
    <template v-slot:button-content>
      <EllipsisIcon/>
    </template>
    <b-dropdown-item @click="$inertia.visit('/groups/create')">
      {{ $t('action.create.group') }}
    </b-dropdown-item>
    <b-dropdown-item @click="$inertia.visit('/categories/create')">
      {{ $t('action.create.category') }}
    </b-dropdown-item>
  </b-dropdown>
</template>

<script>
  import { faEllipsisH } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/helpers'

  export default {
    components: {
      EllipsisIcon: iconComponent({ icon: faEllipsisH })
    }
  }
</script>
