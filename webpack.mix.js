const mix = require('laravel-mix')
const webpack = require('./webpack.config')

require('laravel-mix-postcss-config')

mix
  .js('resources/js/app.js', 'public/js')
  .postCss('resources/css/app.css', 'public/css')
  .postCssConfig()
  .webpackConfig(webpack)
  .version()
