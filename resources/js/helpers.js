import Formatter from '@/Utils/Money'

export const formatter = new Formatter('de', 'EUR')

export const isProduction = process.env.NODE_ENV === 'production'
