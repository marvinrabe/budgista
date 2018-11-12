const webpack = require('webpack')
const mix = require('laravel-mix')
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin')
const GoogleFontsPlugin = require('google-fonts-webpack-plugin')
//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/website.scss', 'public/css')
    .options({
            postCss: [
                require('postcss-discard-comments')({
                    removeAll: true
                })
            ]
        }
    )
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.modernizrrc.js$/,
                    use: ['modernizr-loader']
                },
                {
                    test: /\.modernizrrc(\.json)?$/,
                    use: ['modernizr-loader', 'json-loader']
                }
            ]
        },
        resolve: {
            alias: {
                modernizr$: path.resolve(__dirname, '.modernizrrc'),
                '@': path.resolve(__dirname, 'resources/assets/js')
            }
        },
        plugins: [
            // lodash optimization
            new LodashModuleReplacementPlugin({
                'shorthands': true
            }),
            // Google Fonts
            new GoogleFontsPlugin({
                filename: 'css/fonts.css',
                fonts: [
                    {family: 'Roboto', variants: ['300', '400', '500', '700']}
                ]
            }),
            // Remove moment languages
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
            //new BundleAnalyzerPlugin()
        ]
    })
    .sourceMaps()

if (mix.inProduction()) {
    mix.version()
}

