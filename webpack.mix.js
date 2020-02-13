const mix = require('laravel-mix')
const tailwind = require('tailwindcss')
const webpack = require('./webpack.config')

require('laravel-mix-purgecss');

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [tailwind('tailwind.config.js')],
  })
  .purgeCss()
  .webpackConfig(webpack)
  .version()
