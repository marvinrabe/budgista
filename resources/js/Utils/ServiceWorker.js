export function clearCache() {
  window.caches.keys().then(function(names) {
    for (let name of names)
      window.caches.delete(name);
  });
}

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/service-worker.js');
  });
}
