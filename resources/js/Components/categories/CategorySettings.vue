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
    <UpdateCategory :bind="{categoryId}"/>
    <DeleteCategory :bind="{categoryId}"/>
  </b-dropdown>
</template>

<script>
  import { faEllipsisH } from '@fortawesome/free-solid-svg-icons'
  import bDropdown from 'bootstrap-vue/es/components/dropdown/dropdown'
  import { iconComponent, prepareComponent } from '../../helpers'
  import UpdateCategory from '../../views/categories/Update'
  import DeleteCategory from '../../views/categories/Delete'
  import DropdownModal from '../DropdownModal'

  export default {
    components: {
      bDropdown,
      EllipsisIcon: iconComponent({ icon: faEllipsisH }),
      DeleteCategory: prepareComponent(DropdownModal, { component: DeleteCategory, label: 'action.delete.category' }),
      UpdateCategory: prepareComponent(DropdownModal, { component: UpdateCategory, label: 'action.edit.category' })
    },
    props: {
      categoryId: {
        type: String,
        required: true
      }
    }
  }
</script>
