<template>
  <b-dropdown
    no-caret
    right
    variant="light"
  >
    <template slot="button-content">
      <EllipsisIcon/>
    </template>
    <CreateGroup/>
    <CreateCategory/>
  </b-dropdown>
</template>

<script>
  import { faEllipsisH } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent, prepareComponent } from '../../helpers'
  import CreateCategory from '@/Components/categories/Create'
  import CreateGroup from '@/Components/groups/Create'
  import DropdownModal from '../DropdownModal'

  export default {
    components: {
      EllipsisIcon: iconComponent({ icon: faEllipsisH }),
      CreateGroup: prepareComponent(DropdownModal, { component: CreateGroup, label: 'action.create.group' }),
      CreateCategory: prepareComponent(DropdownModal, { component: CreateCategory, label: 'action.create.category' })
    }
  }
</script>
