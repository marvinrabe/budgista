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
    extend: {}
  },
  variants: {},
  plugins: [
    require('tailwindcss-font-inter')({
      importFontFace: true
    })
  ]
}
