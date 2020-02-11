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
    <CreateCategory :bind="{groupId}"/>
    <b-dropdown-divider/>
    <UpdateGroup :bind="{groupId}"/>
    <DeleteGroup :bind="{groupId}"/>
  </b-dropdown>
</template>

<script>
  import { faEllipsisH } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent, prepareComponent } from '../../helpers'
  import CreateCategory from '../../views/categories/Create'
  import DeleteGroup from '../../views/groups/Delete'
  import UpdateGroup from '../../views/groups/Update'
  import DropdownModal from '../DropdownModal'

  export default {
    components: {
      EllipsisIcon: iconComponent({ icon: faEllipsisH }),
      DeleteGroup: prepareComponent(DropdownModal, { component: DeleteGroup, label: 'action.delete.group' }),
      UpdateGroup: prepareComponent(DropdownModal, { component: UpdateGroup, label: 'action.edit.group' }),
      CreateCategory: prepareComponent(DropdownModal, { component: CreateCategory, label: 'action.create.category' })
    },
    props: {
      groupId: {
        type: String,
        required: true
      }
    }
  }
</script>
