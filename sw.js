// অফলাইনে অ্যাপ খোলার জন্য: পেজ, Tailwind, ফন্ট, আইকন ও Firebase SDK ক্যাশ করে রাখে
const CACHE = 'smart-dokan-v1';
self.addEventListener('install', e => { self.skipWaiting(); e.waitUntil(caches.open(CACHE).then(c => c.addAll(['./', './index.html']).catch(() => {}))); });
self.addEventListener('activate', e => e.waitUntil(
  caches.keys().then(k => Promise.all(k.filter(x => x !== CACHE).map(x => caches.delete(x)))).then(() => self.clients.claim())
));
self.addEventListener('fetch', e => {
  const r = e.request, u = new URL(r.url);
  if (r.method !== 'GET' || /googleapis\.com$/.test(u.hostname) && !/^fonts\./.test(u.hostname) || u.hostname.includes('firebaseapp.com') || u.hostname.includes('accounts.google')) return;
  e.respondWith(caches.open(CACHE).then(async c => {
    const hit = await c.match(r);
    const net = fetch(r).then(res => { if (res.ok || res.type === 'opaque') c.put(r, res.clone()); return res; }).catch(() => hit);
    return hit || net;
  }));
});