<template>
  <Layout :step="2" :title="$t('title.setupCategories')" @next="save">
    <p class="mb-4">{{ $t('message.setupCategories') }}</p>
    <ol class="flex flex-col">
      <li class="p-1" v-for="(sample, index) in samples">
        <label class="rounded-sm form-check-label border bg-white px-4 py-2 flex items-center"
               :class="{'border-gray-4 bg-gray-0': selected.indexOf(index) !== -1, 'border-gray-3': selected.indexOf(index) === -1}">
          <input type="checkbox" :value="index" v-model="selected">
          <div class="flex flex-col ml-4" :class="{'opacity-50': selected.indexOf(index) === -1}">
            <span class="font-medium text-gray-8">{{ sample.name }}</span>
            <span class="text-gray-6">{{ sample.description }}</span>
          </div>
        </label>
      </li>
    </ol>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Setup'

  export default {
    components: {
      Layout
    },
    props: {
      samples: Array
    },
    data () {
      return {
        selected: []
      }
    },
    methods: {
      save () {
        if(!this.selected.length && !window.confirm(this.$t('message.setupNoCategories'))) {
          return;
        }

        this.$inertia.post('/setup/2', {
          categories: this.selected
        })
      }
    }
  }
</script>
