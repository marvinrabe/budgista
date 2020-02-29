<template>
  <Layout :title="title">
    <div class="flex -m-2 items-stretch">
      <div class="p-2 lg:w-1/3 xl:w-1/4"
           :class="{'hidden md:block w-5/12': hasContent, 'w-full md:w-5/12 ': !hasContent}">
        <div class="sticky" style="top: 5rem;">
          <slot name="menu"/>
        </div>
      </div>
      <div class="p-2 lg:w-2/3 xl:w-3/4"
           :class="{'w-full md:w-7/12': hasContent, 'hidden md:block w-7/12 ': !hasContent}">
        <slot>
          <slot name="placeholder"/>
        </slot>
      </div>
    </div>
  </Layout>
</template>

<script>
  import Layout from '@/Layouts/Default'
  import _ from 'lodash'

  export default {
    components: {
      Layout
    },
    props: {
      title: String,
      redirect: {
        type: [String, Array],
        default: null
      }
    },
    mounted () {
      if (window.innerWidth >= 768 && !this.hasContent && this.redirectUrl) {
        this.$inertia.visit(this.redirectUrl, { replace: true })
      }
    },
    computed: {
      redirectUrl () {
        if (_.isArray(this.redirect)) {
          return this.redirect[0]
        } else {
          return this.redirect
        }
      },
      hasContent () {
        return !!this.$slots.default
      }
    }
  }
</script>
