// Service Worker for PWA
const CACHE_NAME = 'restoranku-v1';
const urlsToCache = [
  '/',
  '/menu',
  '/cart',
  '/assets/customer/css/bootstrap.min.css',
  '/assets/customer/js/bootstrap.bundle.min.js',
  '/assets/customer/lib/owlcarousel/owl.carousel.min.js',
  '/img_item_upload/no_image.jpg'
];

// Install event
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        return cache.addAll(urlsToCache);
      })
  );
});

// Fetch event
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Return cached version or fetch from network
        return response || fetch(event.request);
      }
    )
  );
});

// Activate event
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames => {
      return Promise.all(
        cacheNames.map(cacheName => {
          if (cacheName !== CACHE_NAME) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});