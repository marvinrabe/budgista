importScripts('https://storage.googleapis.com/workbox-cdn/releases/5.0.0/workbox-sw.js')

workbox.setConfig({
  debug: true
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
  new RegExp('.*\.(png|jpg|svg)'),
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: 'images',
    plugins: [
      new workbox.expiration.ExpirationPlugin({
        maxEntries: 60,
        maxAgeSeconds: 30 * 24 * 60 * 60, // 30 Days
      }),
    ],
  })
)

workbox.routing.registerRoute(
  new RegExp('.*\.(js|css)'),
  new workbox.strategies.NetworkFirst({
    cacheName: 'static-cache',
  })
)

workbox.routing.registerRoute(
  new RegExp('^.*$'),
  new workbox.strategies.NetworkFirst({
    cacheName: 'page'
  })
)

workbox.routing.setCatchHandler(({ url, event, params }) => {
  return caches.match('/offline/')
})
