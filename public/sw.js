const CACHE_NAME = 'cesi-stages-v1';
const STATIC_ASSETS = [
  '/',
  '/offers',
  '/companies',
  '/css/base.css',
  '/css/layout.css',
  '/css/components.css',
  '/css/pages.css',
  '/css/responsive.css',
  '/images/logo-cesi-stages.svg',
  '/offline.html'
];

// Installation — mise en cache des assets statiques
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => cache.addAll(STATIC_ASSETS))
  );
  self.skipWaiting();
});

// Activation — nettoyage des anciens caches
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k)))
    )
  );
  self.clients.claim();
});

// Fetch — stratégie Network First pour PHP, Cache First pour assets
self.addEventListener('fetch', event => {
  const url = new URL(event.request.url);

  // Assets statiques (CSS, JS, images) → Cache First
  if (url.pathname.match(/\.(css|js|png|jpg|svg|ico|woff2?)$/)) {
    event.respondWith(
      caches.match(event.request).then(cached => {
        return cached || fetch(event.request).then(response => {
          const clone = response.clone();
          caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
          return response;
        });
      })
    );
    return;
  }

  // Pages PHP → Network First avec fallback offline
  event.respondWith(
    fetch(event.request).catch(() =>
      caches.match(event.request).then(cached =>
        cached || caches.match('/offline.html')
      )
    )
  );
});