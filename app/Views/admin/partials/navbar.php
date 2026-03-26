<nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm py-2 sticky-top" style="z-index: 1050;">
    <div class="container-fluid px-lg-4 d-flex align-items-center justify-content-between">

        <!-- PARTEA STÂNGĂ: Logo și Brand -->
        <div class="d-flex align-items-center" style="min-width: 250px;">
            
            <!-- Imaginea Logo CleanTask -->
            <img src="/cleantask.png" alt="CleanTask Logo" class="me-3 rounded shadow-sm" style="width: 48px; height: 48px; object-fit: contain; background-color: #ffffff;">
            
            <!-- Textul Logo -->
            <div class="lh-1">
                <span class="d-block fw-bold text-dark" style="font-size: 1.25rem; color: #1e293b !important;">CleanTask</span>
                <small class="text-muted" style="font-size: 0.85rem;">Admin Panel</small>
            </div>
        </div>

        <!-- CENTRU: Titlu Aplicație (Despărțit de o linie fină, vizibil pe PC) -->
        <div class="d-none d-md-flex flex-grow-1 ps-4 border-start">
            <h4 class="mb-0 fw-bold" style="color: #0f172a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
                CleanTask Manager
            </h4>
        </div>

        <!-- PARTEA DREAPTĂ: Iconițe (Limbă, Temă, Setări, Ieșire) -->
        <div class="d-flex align-items-center gap-3 ms-auto">
            
            <!-- 1. Limba (Globul) -->
            <div class="dropdown">
                <button class="btn btn-link text-dark p-1 border-0" type="button" data-bs-toggle="dropdown" title="Select Language">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855A8 8 0 0 0 5.145 4H7.5zM4.09 4a9.3 9.3 0 0 1 .64-1.539 7 7 0 0 1 .597-.933A7.03 7.03 0 0 0 2.255 4zm-.582 3.5c.03-.877.138-1.718.312-2.5H1.674a7 7 0 0 0-.656 2.5zM4.847 5a12.5 12.5 0 0 0-.338 2.5H7.5V5zM8.5 5v2.5h2.99a12.5 12.5 0 0 0-.337-2.5zM4.51 8.5a12.5 12.5 0 0 0 .337 2.5H7.5V8.5zm3.99 0V11h2.653c.187-.765.306-1.608.338-2.5zM5.145 12q.208.58.468 1.068c.552 1.035 1.218 1.65 1.887 1.855V12zm.182 2.472a7 7 0 0 1-.597-.933A9.3 9.3 0 0 1 4.09 12H2.255a7 7 0 0 0 3.072 2.472M3.82 11a13.7 13.7 0 0 1-.312-2.5h-2.49c.062.89.291 1.733.656 2.5zm6.853 3.472A7 7 0 0 0 13.745 12H11.91a9.3 9.3 0 0 1-.64 1.539 7 7 0 0 1-.597.933M8.5 12v2.923c.67-.204 1.335-.82 1.887-1.855q.26-.487.468-1.068zm3.68-1h2.146c.365-.767.594-1.61.656-2.5h-2.49a13.7 13.7 0 0 1-.312 2.5m2.802-3.5a7 7 0 0 0-.656-2.5H12.18c.174.782.282 1.623.312 2.5zM11.27 2.461c.247.464.462.98.64 1.539h1.835a7 7 0 0 0-3.072-2.472c.218.284.418.598.597.933M10.855 4a8 8 0 0 0-.468-1.068C9.835 1.897 9.17 1.282 8.5 1.077V4z"/></svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                    <li><a class="dropdown-item" href="#" onclick="setLanguage('en')">🇬🇧 English</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setLanguage('ro')">🇷🇴 Română</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setLanguage('de')">🇩🇪 Deutsch</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setLanguage('it')">🇮🇹 Italiano</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setLanguage('sq')">🇦🇱 Shqip</a></li>
                    <li><a class="dropdown-item" href="#" onclick="setLanguage('pl')">🇵🇱 Polski</a></li>
                </ul>
            </div>

            <!-- 2. Dark Mode Toggle (Luna) -->
            <button class="btn btn-link text-dark p-1 border-0" type="button" onclick="toggleNavbarTheme()" title="Dark Mode">
                <span id="nav-theme-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z"/></svg>
                </span>
            </button>

            <!-- 3. Setări Profil (Rotița) -->
            <button class="btn btn-link text-dark p-1 border-0" type="button" onclick="showSection('profile')" title="Settings">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/><path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/></svg>
            </button>

            <!-- 4. Ieșire Cont (Săgeată Ieșire) -->
            <button class="btn btn-link text-dark p-1 border-0 ms-2" type="button" id="btn-logout" title="Logout">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/><path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/></svg>
            </button>

        </div>
    </div>
</nav>