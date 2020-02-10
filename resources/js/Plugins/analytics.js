import Vue from 'vue'
import VueAnalytics from 'vue-analytics'
import { isProduction } from '@/helpers'

Vue.use(VueAnalytics, {
  id: process.env.VUE_APP_GOOGLE_ANALYTICS,
  debug: {
    sendHitTask: isProduction
  },
  set: [
    { field: 'anonymizeIp', value: true },
    { field: 'allowAdFeatures', value: false }
  ]
})
