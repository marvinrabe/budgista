let mix = require('laravel-mix');

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
    .js('resources/assets/js/app.js', 'public/js').sourceMaps()
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
                modernizr$: path.resolve(__dirname, ".modernizrrc")
            }
        }
    });

if (mix.inProduction()) {
    mix.version();
}

