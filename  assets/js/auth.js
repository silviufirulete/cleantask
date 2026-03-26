console.log("--> [START] Scriptul auth.js a pornit executia.");

import { auth, db } from './firebase-config.js';
import { signInWithEmailAndPassword, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
import { doc, getDoc } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";

// Asteptam ca pagina sa fie complet incarcata
document.addEventListener('DOMContentLoaded', () => {
    console.log("--> [DOM] Pagina incarcata. Cautam elementele...");

    const loginForm = document.getElementById('login-form');
    const alertBox = document.getElementById('login-alert');
    const btnLogin = document.getElementById('btn-login');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');

    if (!loginForm) {
        console.error("--> [EROARE] Nu am gasit formularul #login-form!");
        return;
    }

    // === 1. MONITORIZARE STARE USER ===
    onAuthStateChanged(auth, async (user) => {
        if (user) {
            console.log(`--> [AUTH] User detectat: ${user.email} (${user.uid})`);
            
            // Afisam mesaj vizual ca sa stii ca se intampla ceva
            if (alertBox) {
                alertBox.classList.remove('d-none', 'alert-danger', 'alert-warning');
                alertBox.classList.add('alert-success');
                alertBox.textContent = `Salut ${user.email}! Verificăm permisiunile...`;
            }

            // Dezactivam butonul sa nu apesi de 2 ori
            if (btnLogin) btnLogin.disabled = true;
            
            await checkRoleAndRedirect(user);
        } else {
            console.log("--> [AUTH] Niciun user logat momentan.");
        }
    });

    // === 2. VERIFICARE ROL SI REDIRECT ===
    async function checkRoleAndRedirect(user) {
        console.log("--> [DB] Încercăm să citim profilul din Firestore...");
        
        try {
            const docRef = doc(db, "users", user.uid);
            const docSnap = await getDoc(docRef);

            if (docSnap.exists()) {
                const userData = docSnap.data();
                console.log("--> [DB] Date găsite:", userData);

                if (userData.role === 'admin') {
                    console.log("--> [REDIRECT] Către ADMIN...");
                    window.location.href = 'admin';
                } else {
                    console.log("--> [REDIRECT] Către USER DASHBOARD...");
                    window.location.href = 'dashboard';
                }
            } else {
                console.warn("--> [DB] Documentul userului NU EXISTĂ!");
                showError(`Contul există, dar profilul din baza de date lipsește.<br>UID: <b>${user.uid}</b>`);
            }
        } catch (error) {
            console.error("--> [EROARE CRITICA]", error);
            // Aici vedem daca e problema de permisiuni
            if (error.code === 'permission-denied') {
                showError("Eroare Permisiuni: Nu ai dreptul să citești baza de date.<br>Verifică tab-ul 'Regeln' în Firebase.");
            } else {
                showError("Eroare Bază de Date: " + error.message);
            }
        }
    }

    // === 3. SUBMIT FORMULAR ===
    loginForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        console.log("--> [CLICK] Buton logare apasat.");

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        // Reset UI
        if(alertBox) alertBox.classList.add('d-none');
        if(btnLogin) btnLogin.disabled = true;
        if(btnText) btnText.textContent = 'Verificare...';
        if(btnSpinner) btnSpinner.classList.remove('d-none');

        try {
            await signInWithEmailAndPassword(auth, email, password);
            // onAuthStateChanged va prelua controlul de aici
        } catch (error) {
            console.error("--> [EROARE LOGIN]", error);
            let msg = "Eroare la autentificare.";
            if (error.code === 'auth/invalid-credential') msg = "Date incorecte.";
            showError(msg);
            
            // Resetam butonul doar la eroare
            if(btnLogin) btnLogin.disabled = false;
            if(btnText) btnText.textContent = 'Logare';
            if(btnSpinner) btnSpinner.classList.add('d-none');
        }
    });

    // Helper pentru afisare erori
    function showError(message) {
        if (alertBox) {
            alertBox.classList.remove('d-none', 'alert-success');
            alertBox.classList.add('alert-danger');
            alertBox.innerHTML = message;
        }
    }
});