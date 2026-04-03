// EVAi Service Worker básico
const CACHE_NAME = 'evai-v1';

self.addEventListener('install', function (event) {
  self.skipWaiting();
});

self.addEventListener('activate', function (event) {
  event.waitUntil(self.clients.claim());
});

// Sin estrategia de caché activa: red primero, sin interceptar peticiones.
// Ampliar aquí si se necesita soporte offline.
self.addEventListener('fetch', function (event) {
  // Pasar todas las peticiones a la red sin modificar
  event.respondWith(fetch(event.request));
});
