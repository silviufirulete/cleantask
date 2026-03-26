<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- PWA Manifest & Meta Tags -->
<link rel="manifest" href="/manifest.json">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Tasks">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
<meta name="theme-color" content="#1a237e">

<style>
    /* Stiluri specifice pentru Logo */
    .logo-text {
        font-family: 'Segoe UI', sans-serif;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-shadow: 2px 2px 5px rgba(0,0,0,0.2);
        margin-bottom: 0.5rem;
    }
    .text-dark-blue { color: #1a237e; }
    .text-brand-yellow { color: #ffc107; }

    /* Footer Custom */
    .auth-footer { margin-top: 3rem; text-align: center; font-size: 0.85rem; color: #adb5bd; }
    .auth-footer a { color: #6c757d; text-decoration: none; transition: color 0.3s; }
    .auth-footer a:hover { color: #1a237e; text-decoration: underline; }

    /* Card Sesiune Activa */
    #logged-in-card { display: none; text-align: center; }
    .avatar-welcome { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 4px solid #1a237e; margin-bottom: 15px; }
    
    /* iOS Install Banner */
    .ios-install-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; padding: 12px 16px; border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-bottom: 20px;
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown { from { transform: translateY(-100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<!-- Navbar pentru limbă -->
<div class="position-absolute top-0 end-0 p-3" style="z-index: 1000;">
    <div class="dropdown">
        <button class="btn btn-light shadow-sm dropdown-toggle d-flex align-items-center gap-2" type="button" id="languageDropdown" data-bs-toggle="dropdown">
            🌍 Language
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
            <li><a class="dropdown-item" href="#" onclick="window.setLanguage('en')">🇬🇧 English</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.setLanguage('de')">🇩🇪 Deutsch</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.setLanguage('ro')">🇷🇴 Română</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.setLanguage('it')">🇮🇹 Italiano</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.setLanguage('sq')">🇦🇱 Shqip</a></li>
            <li><a class="dropdown-item" href="#" onclick="window.setLanguage('pl')">🇵🇱 Polski</a></li>
        </ul>
    </div>
</div>

<div class="container d-flex flex-column justify-content-center align-items-center" style="min-height: 100vh;">
    
    <!-- iOS Install Banner -->
    <div id="ios-install-banner" class="ios-install-banner d-none" style="max-width: 400px; width: 100%;">
        <div class="d-flex align-items-center justify-content-between">
            <div class="flex-grow-1">
                <div class="fw-bold mb-1">📱 <span data-i18n="install_app">Install App</span></div>
                <p class="small mb-0" data-i18n="install_msg">Tap Share → Add to Home Screen for better experience!</p>
            </div>
            <button class="btn btn-light btn-sm ms-2" onclick="dismissIOSBanner()">✕</button>
        </div>
    </div>
    
    <!-- CARD LOGIN -->
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 15px; border-top: 5px solid #1a237e;">
        <div class="card-body">
            
            <!-- LOGO -->
            <h3 class="text-center logo-text">
                <span class="text-dark-blue">Clean</span>
                <span class="text-brand-yellow">Task Manager</span>
            </h3>
            
            <div id="login-alert" class="alert alert-danger d-none"></div>

            <!-- FORMULAR LOGIN -->
            <div id="login-section">
                <form id="login-form">
                    <p class="text-center text-muted mb-4 fw-bold" data-i18n="login_title">Login User / Admin</p>
                    <div class="mb-3">
                        <label class="form-label text-dark-blue fw-semibold" data-i18n="login_email">Email</label>
                        <input type="email" class="form-control" id="email" required placeholder="name@company.com">
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-dark-blue fw-semibold" data-i18n="login_pass">Password</label>
                        <input type="password" class="form-control" id="password" required>
                    </div>
                    
                    <!-- Link Resetare Parola -->
                    <div class="text-end mb-3">
                        <a href="#" id="show-reset-btn" class="small text-decoration-none" data-i18n="forgot_pass">Forgot Password?</a>
                    </div>

                    <div class="d-grid gap-2 mt-2">
                        <button type="submit" class="btn btn-primary btn-lg" id="btn-login" style="background-color: #1a237e; border-color: #1a237e;">
                            <span id="btn-text" data-i18n="login_btn">Login</span>
                            <span id="btn-spinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </div>
                </form>

                <!-- FORMULAR RESETARE PAROLA (Ascuns initial) -->
                <form id="reset-form" class="d-none">
                    <p class="text-center text-muted mb-4 fw-bold" data-i18n="reset_title">Reset Password</p>
                    <div class="mb-3">
                        <label class="form-label text-dark-blue fw-semibold" data-i18n="login_email">Email</label>
                        <input type="email" class="form-control" id="reset-email" required placeholder="name@company.com">
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-warning btn-lg" id="btn-reset">
                            <span id="btn-reset-text" data-i18n="send_link">Send Reset Link</span>
                        </button>
                        <button type="button" class="btn btn-light btn-sm mt-2" id="back-to-login-btn" data-i18n="back_login">Back to Login</button>
                    </div>
                </form>
            </div>

            <!-- CARD "DEJA LOGAT" (SAFE MODE) -->
            <div id="logged-in-card">
                <div class="alert alert-success border-0 bg-success bg-opacity-10 text-success">
                    <strong data-i18n="session_active">Session Active!</strong>
                </div>
                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" class="avatar-welcome" id="welcome-avatar">
                <h5 class="fw-bold mb-1" id="welcome-name">User</h5>
                <p class="text-muted small mb-4" id="welcome-email">email@address.com</p>
                
                <div class="d-grid gap-2">
                    <button id="btn-continue" class="btn btn-success fw-bold text-white shadow-sm">
                        🚀 <span data-i18n="btn_continue">Go to Dashboard</span>
                    </button>
                    <button id="btn-force-logout" class="btn btn-outline-danger">
                        🚪 <span data-i18n="logout">Logout</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- FOOTER -->
    <div class="auth-footer">
        <p class="mb-1">© Copyright 2026 | All Right Reserved</p>
        <p>Made by <a href="https://webdesign.silviufirulete.de/" target="_blank">SF Webdesign</a></p>
    </div>
</div>

<!-- TRANSLATION SYSTEM -->
<script>
    const translations = {
        en: { "login_title": "Login User / Admin", "login_email": "Email", "login_pass": "Password", "login_btn": "Login", "session_active": "You are logged in!", "btn_continue": "Continue to Panel", "logout": "Logout", "install_app": "Install App", "install_msg": "Tap Share → Add to Home Screen for better experience!", "forgot_pass": "Forgot Password?", "reset_title": "Reset Password", "send_link": "Send Reset Link", "back_login": "Back to Login", "reset_success": "Check your email (and SPAM folder) for the reset link!" },
        ro: { "login_title": "Logare User / Admin", "login_email": "Email", "login_pass": "Parolă", "login_btn": "Logare", "session_active": "Ești deja logat!", "btn_continue": "Mergi la Panou", "logout": "Deconectare", "install_app": "Instalează App", "install_msg": "Apasă Share → Adaugă la Home Screen pentru experiență mai bună!", "forgot_pass": "Ai uitat parola?", "reset_title": "Resetează Parola", "send_link": "Trimite Link", "back_login": "Înapoi la Logare", "reset_success": "Verifică emailul (și folderul SPAM) pentru link!" },
        de: { "login_title": "Anmelden", "login_email": "E-Mail", "login_pass": "Passwort", "login_btn": "Anmelden", "session_active": "Sitzung aktiv!", "btn_continue": "Weiter zum Panel", "logout": "Abmelden", "install_app": "App installieren", "install_msg": "Tippen Sie auf Teilen → Zum Home-Bildschirm für bessere Erfahrung!", "forgot_pass": "Passwort vergessen?", "reset_title": "Passwort zurücksetzen", "send_link": "Link senden", "back_login": "Zurück zum Login", "reset_success": "Überprüfen Sie Ihre E-Mail (und den SPAM-Ordner)!" },
        it: { "login_title": "Accedi", "login_email": "Email", "login_pass": "Password", "login_btn": "Accedi", "session_active": "Sessione attiva!", "btn_continue": "Vai al Pannello", "logout": "Esci", "install_app": "Installa App", "install_msg": "Tocca Condividi → Aggiungi a Home per un'esperienza migliore!", "forgot_pass": "Password dimenticata?", "reset_title": "Reimposta Password", "send_link": "Invia Link", "back_login": "Torna al Login", "reset_success": "Controlla l'email (e la cartella SPAM) per il link!" },
        sq: { "login_title": "Hyrje", "login_email": "Email", "login_pass": "Fjalëkalimi", "login_btn": "Hyr", "session_active": "Sesioni aktiv!", "btn_continue": "Shko te Paneli", "logout": "Dalje", "install_app": "Instalo App", "install_msg": "Prek Share → Shto në Home Screen për përvojë më të mirë!", "forgot_pass": "Keni harruar fjalëkalimin?", "reset_title": "Rikthe Fjalëkalimin", "send_link": "Dërgo Linkun", "back_login": "Kthehu te Hyrja", "reset_success": "Kontrolloni emailin (dhe dosjen SPAM)!" },
        pl: { "login_title": "Zaloguj się", "login_email": "Email", "login_pass": "Hasło", "login_btn": "Zaloguj", "session_active": "Sesja aktywna!", "btn_continue": "Przejdź do Panelu", "logout": "Wyloguj", "install_app": "Zainstaluj App", "install_msg": "Dotknij Udostępnij → Dodaj do ekranu głównego dla lepszego doświadczenia!", "forgot_pass": "Zapomniałeś hasła?", "reset_title": "Resetuj Hasło", "send_link": "Wyślij Link", "back_login": "Powrót do Logowania", "reset_success": "Sprawdź e-mail (i folder SPAM), aby zresetować hasło!" }
    };
    
    const langNames = { en: "🇬🇧 English", ro: "🇷🇴 Română", de: "🇩🇪 Deutsch", it: "🇮🇹 Italiano", sq: "🇦🇱 Shqip", pl: "🇵🇱 Polski" };

    window.setLanguage = function(lang) {
        localStorage.setItem('appLang', lang);
        document.getElementById('languageDropdown').innerHTML = langNames[lang];
        const dict = translations[lang] || translations['en'];
        document.querySelectorAll('[data-i18n]').forEach(el => {
            const key = el.getAttribute('data-i18n');
            if(dict[key]) { if(el.tagName==='INPUT') el.placeholder=dict[key]; else el.innerText=dict[key]; }
        });
    };
    
    window.dismissIOSBanner = function() { document.getElementById('ios-install-banner').classList.add('d-none'); localStorage.setItem('ios-banner-dismissed', 'true'); }

    function checkIOSInstall() {
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
        const isStandalone = window.navigator.standalone || window.matchMedia('(display-mode: standalone)').matches;
        if (isIOS && !isStandalone && !localStorage.getItem('ios-banner-dismissed')) {
            setTimeout(() => { document.getElementById('ios-install-banner').classList.remove('d-none'); }, 2000);
        }
    }
    
    window.addEventListener('DOMContentLoaded', () => {
        window.setLanguage(localStorage.getItem('appLang') || 'en');
        checkIOSInstall();
        
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/firebase-messaging-sw.js')
                .then(reg => console.log('✅ SW registered'))
                .catch(err => console.error('❌ SW error:', err));
        }
    });
</script>

<!-- FIREBASE LOGIC -->
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    // IMPORTAM NOU: sendPasswordResetEmail
    import { getAuth, signInWithEmailAndPassword, onAuthStateChanged, signOut, sendPasswordResetEmail } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
    import { getFirestore, doc, getDoc, updateDoc } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
    import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

    const firebaseConfig = window.firebaseConfig;
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const db = getFirestore(app);
    
    let messaging = null;
    try { messaging = getMessaging(app); } catch (e) { console.log("FCM not available."); }

    let targetUrl = '/dashboard';
    let currentUserUid = null;

    async function requestAndSaveFCMToken(uid) {
        if (!messaging) return;
        try {
            const permission = await Notification.requestPermission();
            if (permission === 'granted') {
                const currentToken = await getToken(messaging, { 
                    vapidKey: 'BBhSul_Zk66U4O4o-pjmXLR81y1bFL6fqPPzatqOaP9aQVun9ekp-CtFLudotFY_v9AL6OgR4o6kM4-tgnl6jWg' 
                });
                if (currentToken) {
                    await updateDoc(doc(db, "users", uid), { fcmToken: currentToken });
                    console.log("✅ Token FCM NOU salvat cu succes în baza de date!");
                }
            }
        } catch (error) { console.error('❌ Eroare la generarea token-ului FCM:', error); }
    }

    onAuthStateChanged(auth, async (user) => {
        if (user) {
            currentUserUid = user.uid;
            document.getElementById('login-section').style.display = 'none';
            document.getElementById('logged-in-card').style.display = 'block';
            document.getElementById('welcome-email').innerText = user.email;

            try {
                const snap = await getDoc(doc(db, "users", user.uid));
                if (snap.exists()) {
                    const data = snap.data();
                    if (user.email === 'silviu.firulete@gmail.com') data.role = 'super_admin';

                    document.getElementById('welcome-name').innerText = data.name || "User";
                    if(data.photoUrl) document.getElementById('welcome-avatar').src = data.photoUrl;
                    
                    if (data.role === 'admin' || data.role === 'super_admin') {
                        targetUrl = '/admin'; 
                        document.getElementById('btn-continue').innerHTML = '🚀 Go to <b>Admin Panel</b>';
                    } else {
                        targetUrl = '/dashboard';
                    }
                }
            } catch (e) { console.error(e); }
        } else {
            document.getElementById('login-section').style.display = 'block';
            document.getElementById('logged-in-card').style.display = 'none';
            currentUserUid = null;
        }
    });

    document.getElementById('btn-continue').addEventListener('click', async () => {
        const btn = document.getElementById('btn-continue');
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Loading...';
        btn.disabled = true;
        
        if(currentUserUid) await requestAndSaveFCMToken(currentUserUid);
        window.location.href = targetUrl;
    });

    document.getElementById('btn-force-logout').addEventListener('click', () => signOut(auth).then(() => window.location.reload()));

    // LOGIN
    document.getElementById('login-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('btn-login');
        btn.disabled = true;
        try {
            const userCredential = await signInWithEmailAndPassword(auth, document.getElementById('email').value, document.getElementById('password').value);
            await requestAndSaveFCMToken(userCredential.user.uid);
            window.location.reload(); 
        } catch (e) {
            document.getElementById('login-alert').innerText = e.message;
            document.getElementById('login-alert').classList.remove('d-none', 'alert-success');
            document.getElementById('login-alert').classList.add('alert-danger');
            btn.disabled = false;
        }
    });

    // TOGGLE FORMS
    document.getElementById('show-reset-btn').addEventListener('click', (e) => {
        e.preventDefault();
        document.getElementById('login-form').classList.add('d-none');
        document.getElementById('reset-form').classList.remove('d-none');
        document.getElementById('login-alert').classList.add('d-none');
        document.getElementById('reset-email').value = document.getElementById('email').value; // pre-completeaza emailul
    });

    document.getElementById('back-to-login-btn').addEventListener('click', () => {
        document.getElementById('reset-form').classList.add('d-none');
        document.getElementById('login-form').classList.remove('d-none');
        document.getElementById('login-alert').classList.add('d-none');
    });

    // RESET PASSWORD SUBMIT
    document.getElementById('reset-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('btn-reset');
        const emailToReset = document.getElementById('reset-email').value;
        const alertBox = document.getElementById('login-alert');
        
        btn.disabled = true;
        try {
            await sendPasswordResetEmail(auth, emailToReset);
            
            // Afiseaza mesaj de succes in limba selectata
            const lang = localStorage.getItem('appLang') || 'en';
            alertBox.innerText = translations[lang]?.reset_success || translations['en'].reset_success;
            alertBox.classList.remove('d-none', 'alert-danger');
            alertBox.classList.add('alert-success');
            
            // Ascunde formularul dupa 6 secunde si intoarce-te la login
            setTimeout(() => {
                document.getElementById('back-to-login-btn').click();
                alertBox.classList.add('d-none');
                alertBox.classList.remove('alert-success');
                alertBox.classList.add('alert-danger'); // reset pentru erori viitoare
                btn.disabled = false;
            }, 6000);

        } catch (error) {
            alertBox.innerText = error.message;
            alertBox.classList.remove('d-none', 'alert-success');
            alertBox.classList.add('alert-danger');
            btn.disabled = false;
        }
    });

</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>