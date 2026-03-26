// Importă SDK-urile Firebase (versiunea compatibilă cu service worker)
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js');

// INIȚIALIZEAZĂ FIREBASE
const firebaseConfig = {
  apiKey: "AIzaSyB-jGNI1fdPZa9SDgZt_a8_VyBly90Mnzw",
  authDomain: "clean-task-sr.firebaseapp.com",
  projectId: "clean-task-sr",
  storageBucket: "clean-task-sr.firebasestorage.app",
  messagingSenderId: "50909315737",
  appId: "1:50909315737:web:cf971d6470aa3cdc78ee08",
  measurementId: "G-7H36LSJHDH"
};

firebase.initializeApp(firebaseConfig);
const messaging = firebase.messaging();

// ============================================================================
// CRITIC PENTRU PWA: Evenimentul 'fetch' 
// Fără acest cod, Chrome pe Android NU va arăta butonul de "Instalare Aplicație", 
// ci doar "Adaugă pe ecranul de pornire", iar PWA-ul nu va rula corect în background.
// ============================================================================
self.addEventListener('fetch', function(event) {
    // Nu facem nimic, lăsăm browserul să preia controlul.
    // Dar simpla prezență a acestui listener validează PWA-ul pentru Google.
});

// Această funcție prinde notificarea în background
messaging.onBackgroundMessage((payload) => {
  console.log('[firebase-messaging-sw.js] Notificare primită în fundal.', payload);

  // NOTĂ: Dacă trimiți obiectul "notification" din Cloud Function (cum am făcut noi),
  // browser-ul ar trebui să o afișeze automat. 
  // O generăm manual aici doar ca metodă de rezervă (fallback).
  const notificationTitle = payload.notification?.title || 'Notificare Nouă';
  const notificationOptions = {
    body: payload.notification?.body || 'Ai primit un mesaj nou.',
    icon: '/assets/icons/icon-192x192.png', // Verifică dacă calea ta este /icons/ sau /assets/icons/
    badge: '/assets/icons/icon-192x192.png',
    data: payload.data
  };

  return self.registration.showNotification(notificationTitle, notificationOptions);
});

// Opțional: Ce se întâmplă când dai click pe notificare
self.addEventListener('notificationclick', function(event) {
  event.notification.close();
  
  // Deschide aplicația sau adu-o în prim-plan
  event.waitUntil(
    clients.matchAll({ type: 'window', includeUncontrolled: true }).then((clientList) => {
      // Dacă nu ai trimis url din funcția de Cloud, defaultăm la root '/'
      const url = (event.notification.data && event.notification.data.url) ? event.notification.data.url : '/';
      
      for (const client of clientList) {
        // Dacă aplicația este deja deschisă, o aducem în prim-plan (focus)
        if (client.url.includes(url) && 'focus' in client) {
          return client.focus();
        }
      }
      // Altfel, deschidem o fereastră/tab nou cu aplicația
      if (clients.openWindow) {
        return clients.openWindow(url);
      }
    })
  );
});