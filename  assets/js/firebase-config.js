// Importam funcțiile necesare direct de pe serverele Google (CDN)
// Folosim versiunea modulară (v10) care este standardul actual
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
import { getFirestore } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
import { getStorage } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";

// Aici preluăm configurația pe care am injectat-o din PHP în header.php
// PHP a scris deja cheile API în variabila window.firebaseConfig
const firebaseConfig = window.firebaseConfig;

// Verificăm dacă PHP a reușit să scrie config-ul (pentru debugging)
if (!firebaseConfig) {
    console.error("Eroare CRITICĂ: Nu s-a găsit window.firebaseConfig! Verifică header.php și fișierul .env");
} else {
    console.log("Firebase Config încărcat cu succes.");
}

// Inițializăm Firebase
const app = initializeApp(firebaseConfig);

// Inițializăm serviciile și le exportăm pentru a fi folosite în alte fișiere (auth.js, etc.)
const auth = getAuth(app);
const db = getFirestore(app);
const storage = getStorage(app);

export { app, auth, db, storage };