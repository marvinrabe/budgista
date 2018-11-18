import Vue from 'vue'
import VueAnalytics from 'vue-analytics'
import router from './router'
import * as Sentry from '@sentry/browser'

let isProduction = process.env.NODE_ENV === 'production'

Vue.use(VueAnalytics, {
    id: process.env.VUE_APP_GOOGLE_ANALYTICS,
    router,
    debug: {
        //enabled: !isProduction,
        sendHitTask: isProduction
    }
})

if (isProduction) {
    Sentry.init({dsn: process.env.VUE_APP_SENTRY})
}
