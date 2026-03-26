<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- 1. STILURI CSS & MANIFEST PWA -->
<link rel="manifest" href="/manifest.json">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Tasks">
<link rel="apple-touch-icon" href="/icons/icon-152x152.png">
<?php include __DIR__ . '/partials/styles.php'; ?>

<!-- 2. BARA DE NAVIGARE (NAVBAR) -->
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- 3. CONTAINER PRINCIPAL -->
<div class="container py-3">

<!-- Mesaje de Încărcare -->
<div id="loading-msg" class="text-center mt-5">
<div class="spinner-border text-primary" role="status"></div>
<p class="mt-2" data-i18n="loading">Loading...</p>
</div>

<!-- Conținutul Meniului (Apare doar dacă e logat ca User) -->
<div id="user-content" class="d-none">

<!-- Bannere Globale (iOS Install & Push Push Permission) -->
<div id="ios-install-banner" class="ios-install-banner mb-3 d-none">
<div class="d-flex align-items-center justify-content-between">
<div class="flex-grow-1">
<div class="fw-bold mb-1">📱 Install App</div>
<p class="small mb-0">Tap <strong>Share</strong> → <strong>Add to Home Screen</strong></p>
</div>
<button class="btn btn-light btn-sm ms-2" onclick="dismissIOSBanner()">✕</button>
</div>
</div>

<div id="push-permission-alert" class="alert alert-warning mb-3 shadow-sm d-flex align-items-center justify-content-between d-none">
<div>🔔 <span data-i18n="enable_push_msg">Enable push notifications?</span></div>
<button class="btn btn-sm btn-dark fw-bold" onclick="requestPushPermission()" data-i18n="enable">Enable</button>
</div>

<!-- Meniu Navigare (Tabs) -->
<ul class="nav nav-pills mb-4 justify-content-center flex-wrap gap-1" id="pills-tab">
<li class="nav-item"><button class="nav-link active" onclick="showSection('tasks')">📋 <span data-i18n="tab_tasks">My Tasks</span></button></li>
<li class="nav-item"><button class="nav-link" onclick="showSection('history')">✅ <span data-i18n="tab_done">History</span></button></li>
<li class="nav-item"><button class="nav-link" onclick="showSection('calendar')">📅 <span data-i18n="tab_calendar">Calendar</span></button></li>
<!-- TAB NOU: CHAT CU BADGE NOTIFICARE -->
<li class="nav-item">
<button class="nav-link position-relative" onclick="showSection('chat')">
💬 <span data-i18n="chat">Chat</span>
<span id="chat-unread-badge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" style="font-size: 0.65rem; padding: 0.35em 0.5em;">0</span>
</button>
</li>
</ul>

<!-- SECTIUNILE DE CONȚINUT (Includerile) -->
<?php include __DIR__ . '/partials/tasks_section.php'; ?>

<?php include __DIR__ . '/partials/history_section.php'; ?>

<?php include __DIR__ . '/partials/calendar_section.php'; ?>

<?php include __DIR__ . '/partials/profile_section.php'; ?>

<?php include __DIR__ . '/partials/chat_section.php'; ?>

</div>
</div>

<!-- 4. MODALE (POP-UP-URI) -->
<?php include __DIR__ . '/partials/modals.php'; ?>

<!-- 5. SCRIPTURI JAVASCRIPT & FIREBASE -->
<?php include __DIR__ . '/partials/scripts.php'; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>