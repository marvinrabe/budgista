<template>
  <div class="card">
    <div class="budget-group">
      <div class="handle budget-group-handle">
        <span class="small text-dark">
          <GripIcon/>
        </span>
      </div>
      <div class="data">
        <div class="budget-column-name cursor-pointer ellipsis hover:text-gray-7" @click="toggleCollapse">
          <ChevronRightIcon v-if="group.collapsed"/>
          <ChevronDownIcon v-else/>
          <span class="font-bold">
          {{ group.name }}
          </span>
        </div>
        <div class="budget-column-budget">
          <AppMoney :value="budgeted"/>
        </div>
        <div class="budget-column-activity">
          <AppMoney :value="activity"/>
        </div>
        <div class="budget-column-available">
          <AppMoney :value="available"/>
        </div>
      </div>
      <div class="actions">
        <GroupSettings
          :group="group"
          v-if="group.id"
        />
      </div>
    </div>

    <slot v-if="!group.collapsed"/>
  </div>
</template>

<script>
  import { faChevronDown, faChevronRight, faGripLinesVertical } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '../../helpers'
  import AppMoney from '../AppMoney'
  import GroupSettings from '../groups/GroupSettings'

  export default {
    components: {
      ChevronDownIcon: iconComponent({ icon: faChevronDown, fixedWidth: true }),
      ChevronRightIcon: iconComponent({ icon: faChevronRight, fixedWidth: true }),
      GripIcon: iconComponent({ icon: faGripLinesVertical, fixedWidth: true }),
      AppMoney,
      GroupSettings
    },
    props: {
      group: Object,
      budget: Object
    },
    computed: {
      sheet () {
        let categories = this.group.categories.map(x => x.id)
        return this.budget.rows.filter(x => categories.includes(x.id))
      },
      budgeted () {
        return this.sheet.reduce((acc, x) => acc + x.budget, 0)
      },
      activity () {
        return this.sheet.reduce((acc, x) => acc + x.activity, 0)
      },
      available () {
        return this.sheet.reduce((acc, x) => acc + x.available, 0)
      }
    },
    methods: {
      toggleCollapse () {
        this.$inertia.post(this.group.links.collapse, {
          collapsed: !this.group.collapsed
        }, { preserveScroll: true })
      }
    }
  }
</script>
