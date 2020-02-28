const mix = require('laravel-mix')
const tailwind = require('tailwindcss')
const webpack = require('./webpack.config')

require('laravel-mix-purgecss');
require('laravel-mix-polyfill');

mix
  .js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css')
  .options({
    processCssUrls: false,
    postCss: [tailwind('tailwind.config.js')],
  })
  .purgeCss({
    whitelistPatternsChildren: [/dropdown/,/notyf/,/nprogress/]
  })
  .polyfill({
    enabled: true,
    useBuiltIns: "usage",
    targets: "> 0.25%, not dead"
  })
  .webpackConfig(webpack)
  .version()
