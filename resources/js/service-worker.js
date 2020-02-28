importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js')

workbox.setConfig({
  debug: false
})

workbox.routing.registerRoute(
  new RegExp('.*(?:googleapis|gstatic)\.com.*$'),
  new workbox.strategies.StaleWhileRevalidate(),
)

workbox.routing.registerRoute(
  new RegExp('.*rsms\.me.*$'),
  new workbox.strategies.CacheFirst(),
)

workbox.routing.registerRoute(
  /\.(?:png|gif|jpg|jpeg|svg|js|css)/,
  new workbox.strategies.CacheFirst({
    cacheName: 'static',
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 60,
        maxAgeSeconds: 30 * 24 * 60 * 60, // 30 Days
      }),
    ],
  })
)

const inertiaStrategy = new workbox.strategies.NetworkFirst({
  cacheName: 'inertia',
  plugins: [
    new workbox.cacheableResponse.CacheableResponsePlugin({
      headers: {
        'x-inertia': 'true',
      },
    })
  ]
})

const defaultStrategy = new workbox.strategies.NetworkFirst()

workbox.routing.registerRoute(
  /(.*)/,
  async (params) => {
    if (params.request.headers.has('x-inertia')) {
      return await inertiaStrategy.handle(params)
    }
    return await defaultStrategy.handle(params)
  }
)
