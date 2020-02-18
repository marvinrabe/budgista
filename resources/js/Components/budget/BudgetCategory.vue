<template>
  <div class="budget-row">
    <div class="handle budget-row-handle">
      <span class="small text-dark">
        <GripIcon/>
      </span>
    </div>
    <div
      @click.stop="$refs.input.focus()"
      class="data cursor-pointer"
    >
      <div class="budget-column-name ellipsis">
        {{ category.name }}
      </div>
      <div
        @click.stop
        class="budget-column-budget"
      >
        <AppMoneyInput
          :title="recommendedTitle"
          :value="row.budget"
          @change="val => updateBudget(val)"
          ref="input"
        />
      </div>
      <div class="budget-column-activity">
        <AppMoney :value="row.activity"/>
      </div>
      <div class="budget-column-available">
        <AppMoney
          :value="row.available"
          color
        />
      </div>
    </div>
    <div class="actions">
      <CategorySettings :category="category"/>
    </div>
  </div>
</template>

<script>
  import AppMoney from '../AppMoney'
  import AppMoneyInput from '../form/AppMoneyInput'
  import { faGripLinesVertical } from '@fortawesome/free-solid-svg-icons'
  import { mixin as moneyMixin } from '@/Utils/Money'
  import { iconComponent } from '@/Utils/Icons'
  import CategorySettings from '../categories/CategorySettings'

  export default {
    components: {
      AppMoney,
      AppMoneyInput,
      GripIcon: iconComponent({ icon: faGripLinesVertical, fixedWidth: true }),
      CategorySettings
    },
    mixins: [moneyMixin],
    props: {
      category: Object,
      month: Object,
      budget: Object
    },
    computed: {
      row () {
        return this.budget.rows.filter(x => x.id === this.category.id)[0] || {}
      },
      recommendedTitle () {
        return this.$t('form.recommendedBudget') + ': ' + this.moneyFormat.format(this.row.recommendedBudget)
      }
    },
    methods: {
      updateBudget: function (value) {
        this.$inertia.post(`/budget/${this.month.toString()}/categories/${this.category.id}`, {
          amount: value
        }, { preserveScroll: true })
      }
    }
  }
</script>
