const path = require('path')

module.exports = {
  output: { chunkFilename: 'js/[name].js?id=[chunkhash]' },
  resolve: {
    alias: {
      '@': path.resolve('resources/js'),
    },
  },
  module: {
    rules: [
      {
        test: /\.(svelte)$/,
        use: [
          {
            loader: 'svelte-loader',
            options: {
              preprocess: require('svelte-preprocess')({
                postcss: true
              })
            },
          }
        ]
      }
    ]
  }
}