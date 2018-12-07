const webpack = require('webpack')
const path = require('path')
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin')
//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

module.exports = {
    devServer: {
        proxy: 'http://budgista.test'
    },

    pwa: {
        themeColor: '#2196f3',
        iconPaths: {
            favicon32: 'img/favicon-32x32.png',
            favicon16: 'img/favicon-16x16.png',
            appleTouchIcon: 'img/apple-touch-icon-152x152.png',
            maskIcon: 'img/safari-pinned-tab.svg',
            msTileImage: 'img/mstile-144x144.png'
        }
    },

    outputDir: '../public',

    indexPath: process.env.NODE_ENV === 'production'
        ? '../resources/views/index.blade.php'
        : 'index.html',

    configureWebpack: {
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
        },
        plugins: [
            new LodashModuleReplacementPlugin({
                'shorthands': true
            }),
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)
            //,new BundleAnalyzerPlugin()
        ]
    }
}
