<template>
  <div class="budget-row">
    <div class="handle budget-row-handle">
      <span class="small text-dark">
        <GripIcon/>
      </span>
    </div>
    <BudgetCategoryLoading
      :category="category"
      v-if="loading"
    />
    <BudgetCategoryData
      :category="category"
      :month="month"
      v-else
    />
    <div class="actions">
      <CategorySettings :category-id="category.id"/>
    </div>
  </div>
</template>

<script>
  import { faGripLinesVertical } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '../../helpers'
  import CategorySettings from '../categories/CategorySettings'
  import BudgetCategoryData from './BudgetCategoryData'
  import BudgetCategoryLoading from './BudgetCategoryLoading'

  export default {
    components: {
      GripIcon: iconComponent({ icon: faGripLinesVertical, fixedWidth: true }),
      BudgetCategoryLoading,
      BudgetCategoryData,
      CategorySettings
    },
    props: {
      category: {
        type: Object,
        required: true
      },
      month: {
        type: Object,
        required: true
      },
      loading: {
        type: Boolean,
        default: true
      }
    }
  }
</script>
