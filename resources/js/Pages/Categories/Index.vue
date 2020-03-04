<template>
  <Layout :title="$t('title.categories')">
    <div class="card">
      <div class="card-header flex items-center">
        <h2 class="text-xl">
          {{ $t('title.categories') }}
        </h2>

        <div class="ml-auto flex">
          <AppButton
            :title="$t('action.create.category')"
            to="/categories/create"
            variant="primary"
          >
            <PlusIcon/>
            {{ $t('word.category') }}
          </AppButton>
        </div>
      </div>
      <draggable
        handle=".handle"
        v-model="categories"
        @input="sortCategories"
      >
        <div class="card-item" v-for="category in categories">
          <div class="handle text-gray-6 cursor-move pr-0">
            <GripIcon/>
          </div>
          <a :href="category.links.edit" class="flex-1 flex items-center justify-between hover:no-underline">
            <div class="flex">
              <span class="text-gray-7 font-medium tracking-wide">{{ category.name }}</span>
              <span class="text-gray-6 ml-2" v-if="category.description">{{ category.description }}</span>
            </div>
            <ChevronIcon class="text-gray-6"/>
          </a>
        </div>
      </draggable>
    </div>

  </Layout>
</template>

<script>
  import draggable from 'vuedraggable'
  import Layout from '@/Pages/Settings/Index'
  import { faGripLinesVertical, faPlus, faChevronRight } from '@fortawesome/free-solid-svg-icons'
  import { iconComponent } from '@/Utils/Icons'
  import AppButton from '@/Components/form/AppButton'

  export default {
    components: {
      AppButton,
      draggable,
      Layout,
      PlusIcon: iconComponent({ icon: faPlus }),
      GripIcon: iconComponent({ icon: faGripLinesVertical, fixedWidth: true }),
      ChevronIcon: iconComponent({ icon: faChevronRight, fixedWidth: true })
    },
    props: {
      categories: Array
    },
    methods: {
      sortCategories (result) {
        const ids = result.map(category => category.id).filter(x => x)

        this.$inertia.post('/categories/sort', {
          categories: ids
        }, { preserveScroll: true })
      }
    }
  }
</script>
