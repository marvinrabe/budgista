<template>
  <Layout :title="title">
    <template v-slot:header>
      <slot name="header"/>
    </template>

    <div class="flex -mx-4 items-stretch">
      <div class="px-4 lg:w-5/12 xl:w-1/3"
           :class="{'hidden lg:block': hasContent, 'w-full': !hasContent}">
        <slot name="menu"/>
      </div>
      <div class="px-4 lg:w-7/12 xl:w-2/3"
           :class="{'w-full': hasContent, 'hidden lg:block': !hasContent}">
        <slot></slot>
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
      },
      hasContent: {
        type: Boolean,
        default: true
      }
    },
    mounted () {
      if (window.innerWidth >= 1024 && !this.hasContent && this.redirectUrl) {
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
      }
    }
  }
</script>
