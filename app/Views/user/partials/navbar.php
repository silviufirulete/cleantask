<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
        <span data-i18n="worker_db">Worker Dashboard</span>
    </a>
    
    <div class="d-flex align-items-center gap-2">
        <!-- NOTIFICATION CENTER (BELL) -->
        <div class="dropdown">
            <div class="notif-bell text-secondary" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <span id="bell-icon">🔔</span> 
                <span id="notif-counter" class="badge rounded-pill bg-danger notif-badge d-none">0</span>
            </div>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-0" style="width: 300px; max-height: 400px; overflow-y: auto;">
                <li class="dropdown-header bg-light border-bottom d-flex justify-content-between align-items-center">
                    <span class="fw-bold" data-i18n="notifications">Notifications</span>
                    <div>
                        <button class="btn btn-sm btn-link text-decoration-none text-muted me-2" onclick="toggleNotificationPreference()" id="btn-mute-toggle" title="Toggle Sound">🔊</button>
                        <button class="btn btn-link btn-sm p-0 text-decoration-none" onclick="clearNotifications()" data-i18n="clear">Clear</button>
                    </div>
                </li>
                <div id="notif-list">
                    <li class="text-center p-3 text-muted small" id="no-notifs" data-i18n="no_notifs">No new notifications</li>
                </div>
            </ul>
        </div>

        <!-- Language Switcher -->
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="langUserDropdown" data-bs-toggle="dropdown">🌍</button>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                <li><a class="dropdown-item" href="#" onclick="setLanguage('en')">🇬🇧 English</a></li>
                <li><a class="dropdown-item" href="#" onclick="setLanguage('de')">🇩🇪 Deutsch</a></li>
                <li><a class="dropdown-item" href="#" onclick="setLanguage('ro')">🇷🇴 Română</a></li>
                <li><a class="dropdown-item" href="#" onclick="setLanguage('it')">🇮🇹 Italiano</a></li>
                <li><a class="dropdown-item" href="#" onclick="setLanguage('sq')">🇦🇱 Shqip</a></li>
                <li><a class="dropdown-item" href="#" onclick="setLanguage('pl')">🇵🇱 Polski</a></li>
            </ul>
        </div>

        <!-- Profile Menu -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown">
                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="32" height="32" class="rounded-circle border" id="nav-profile-img">
            </a>
            <ul class="dropdown-menu dropdown-menu-end text-small shadow border-0">
                <li><a class="dropdown-item" href="#" onclick="showSection('profile')">👤 <span data-i18n="my_profile">My Profile</span></a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="#" id="btn-logout" data-i18n="logout">Logout</a></li>
            </ul>
        </div>
    </div>
  </div>
</nav>

<!-- BIG ALERT TOAST -->
<div id="task-alert-toast" class="alert alert-light alert-dismissible fade show" role="alert">
    <div class="d-flex align-items-center">
        <div class="fs-1 me-3">🔔</div>
        <div>
            <h5 class="alert-heading fw-bold mb-1" data-i18n="new_task_alert">New Task!</h5>
            <p class="mb-0 small" id="toast-body">A new task is available.</p>
        </div>
    </div>
    <button type="button" class="btn-close" onclick="closeToast()"></button>
    <div class="mt-2 d-grid">
        <button class="btn btn-warning btn-sm fw-bold" onclick="closeToast()" data-i18n="close">OK</button>
    </div>
</div>