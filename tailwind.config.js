const colors = require('open-color')

module.exports = {
  theme: {
    colors: {
      ...colors,
      transparent: 'transparent'
    },
    container: {
      center: true,
    },
    extend: {},
    customForms: theme => ({
      default: {
        'input, select, checkbox, radio': {
          borderColor: theme('colors.gray.4'),
          '&:focus': {
            borderColor: theme('colors.blue.4'),
          }
        },
        'checkbox, radio': {
          '&:checked': {
            backgroundColor: theme('colors.blue.4'),
          }
        }
      },
    })
  },
  variants: {},
  plugins: [
    require('tailwindcss-font-inter')({
      importFontFace: true
    }),
    require('@tailwindcss/custom-forms')
  ]
}
