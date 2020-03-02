importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js')

workbox.setConfig({
  debug: false
})

workbox.routing.registerRoute(
  /\.(?:png|gif|jpg|jpeg|svg|js|css)/,
  new workbox.strategies.CacheFirst({
    cacheName: 'static',
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 60,
        maxAgeSeconds: 14 * 24 * 60 * 60, // 14 Days
      }),
    ],
  })
)

const defaultExpiration = new workbox.expiration.ExpirationPlugin({
  maxEntries: 60,
  maxAgeSeconds: 24 * 60 * 60, // 1 Day
});

const inertiaStrategy = new workbox.strategies.NetworkFirst({
  cacheName: 'inertia',
  plugins: [
    defaultExpiration,
    new workbox.cacheableResponse.CacheableResponsePlugin({
      headers: {
        'x-inertia': 'true',
      },
    })
  ]
})

const defaultStrategy = new workbox.strategies.NetworkFirst({
  cacheName: 'pages',
  plugins: [
    defaultExpiration
  ]
})

workbox.routing.registerRoute(
  /(.*)/,
  async (params) => {
    if (params.request.headers.has('x-inertia')) {
      return await inertiaStrategy.handle(params)
    }
    return await defaultStrategy.handle(params)
  }
)
