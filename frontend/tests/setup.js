import { config } from '@vue/test-utils'
import translations from '@/lang'

const locale = 'en'

config.mocks['$t'] = (msg) => translations[locale][msg]
config.mocks['$validator'] = (msg) => translations[locale][msg]
