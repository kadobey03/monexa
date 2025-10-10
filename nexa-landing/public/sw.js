// Basic service worker for Nexa Finance LLC
const CACHE_NAME = 'nexa-cache-v1';
const CORE_ASSETS = [
  '/',
  '/manifest.webmanifest',
  '/logo-nexa.svg'
];

self.addEventListener('install', (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(CORE_ASSETS)).then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', (event) => {
  event.waitUntil(
    caches.keys().then((keys) => Promise.all(keys.filter((k) => k !== CACHE_NAME).map((k) => caches.delete(k)))).then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', (event) => {
  const req = event.request;
  // Network first for navigation, cache first for others
  if (req.mode === 'navigate') {
    event.respondWith(
      fetch(req).catch(() => caches.match('/'))
    );
    return;
  }
  event.respondWith(
    caches.match(req).then((cached) => cached || fetch(req).then((resp) => {
      const respClone = resp.clone();
      caches.open(CACHE_NAME).then((cache) => cache.put(req, respClone));
      return resp;
    }).catch(() => cached))
  );
});

