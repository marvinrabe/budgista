<template>
  <div class="card mb-3">
    <div class="budget-group">
      <div class="handle budget-group-handle" v-if="group.id">
        <span class="small text-dark">
          <GripIcon/>
        </span>
      </div>
      <div class="budget-group-handle" style="width: 26px;" v-else></div>
      <div class="data">
        <div
          class="budget-column-name ellipsis"
          v-if="group"
        >
          <ChevronRightIcon v-if="collapsed"/>
          <ChevronDownIcon @click.prevent="collapse" v-else/>
          <a
            @click.prevent="collapse"
            class="text-dark ml-1"
            href="#"
            v-text="group.name"
          ></a>
        </div>
        <div
          class="budget-column-name"
          v-else
        >
          {{ $t('title.ungrouped') }}
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
          :group-id="group.id"
          v-if="group.id"
        />
      </div>
    </div>

    <slot v-if="!collapsed"/>
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
      collapsed () {
        return false; // TODO
      },
      sheet () {
        let categories = this.group.categories.map(x => x.id)
        return this.budget.rows.filter(x => categories.includes(x.id))
      },
      budgeted () {
        return this.sheet.reduce((acc, x) => x.budget, 0)
      },
      activity () {
        return this.sheet.reduce((acc, x) => x.activity, 0)
      },
      available () {
        return this.sheet.reduce((acc, x) => x.available, 0)
      }
    },
    methods: {
      collapse () {
        //this.$store.commit('groups/toggleCollapsed', this.group.id)
      }
    }
  }
</script>
