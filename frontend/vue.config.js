const webpack = require('webpack')
const path = require('path')
const LodashModuleReplacementPlugin = require('lodash-webpack-plugin')
//const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

module.exports = {
    devServer: {
        proxy: 'http://budgista.test'
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
