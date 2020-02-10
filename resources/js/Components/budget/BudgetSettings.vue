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
  import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
  import { iconComponent, prepareComponent } from '../../helpers'
  import CreateCategory from '../../views/categories/Create'
  import CreateGroup from '../../views/groups/Create'
  import DropdownModal from '../DropdownModal'

  export default {
    components: {
      bDropdown,
      EllipsisIcon: iconComponent({ icon: faEllipsisH }),
      CreateGroup: prepareComponent(DropdownModal, { component: CreateGroup, label: 'action.create.group' }),
      CreateCategory: prepareComponent(DropdownModal, { component: CreateCategory, label: 'action.create.category' })
    }
  }
</script>
