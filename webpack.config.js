const path = require('path')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin

module.exports = {
  output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
  resolve: {
    alias: {
      '@': path.resolve('resources/js'),
      'chart.js': 'chart.js/dist/Chart.js'
    },
  },
  externals: {
    moment: 'moment'
  },
  plugins: [
    new BundleAnalyzerPlugin()
  ]
}
