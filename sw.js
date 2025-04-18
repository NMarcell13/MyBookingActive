self.addEventListener('install', (event) => {
  console.log('Service Worker telepítve');
});

self.addEventListener('activate', (event) => {
  console.log('Service Worker aktiválva');
});

self.addEventListener('fetch', (event) => {
  event.respondWith(
    fetch(event.request)
      .catch(() => {
        // Offline fallback kezelése
        return new Response('Offline vagy');
      })
  );
});