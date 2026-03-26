<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<!-- 1. STILURI CSS -->
<?php include __DIR__ . '/partials/styles.php'; ?>

<!-- 2. BARA DE NAVIGARE (NAVBAR) -->
<?php include __DIR__ . '/partials/navbar.php'; ?>

<!-- 3. CONTAINER PRINCIPAL (Lat pe tot ecranul) -->
<div class="container-fluid py-3 px-lg-4">
    
    <!-- Mesaj de Încărcare -->
    <div id="loading-msg" class="text-center mt-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2" data-i18n="loading">Loading...</p>
    </div>

    <!-- Eroare de Autentificare -->
    <div id="auth-error" class="alert alert-danger d-none text-center mt-5">
        Neautorizat. Vă rugăm să vă autentificați.
    </div>

    <!-- Conținutul Adminului (LAYOUT 3 COLOANE) -->
    <div id="admin-content" class="row d-none">
        
        <!-- Header-ul de Sus -->
        <div class="col-12 d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
            <h2 class="h3 mb-0 text-dark"><span data-i18n="welcome">Welcome</span>, <span id="admin-name" class="text-primary">Admin</span>!</h2>
        </div>

        <!-- ========================================== -->
        <!-- COLOANA 1: MENIUL VERTICAL (STÂNGA)        -->
        <!-- ========================================== -->
        <div class="col-lg-2 mb-4">
            <div class="bg-white rounded shadow-sm p-3 h-100 border-top border-3 border-primary">
                <h6 class="text-muted fw-bold mb-3 text-uppercase small" data-i18n="menu_title">Menu Nave</h6>
                
                <ul class="nav flex-column nav-pills gap-2" id="admin-tabs">
                    <li class="nav-item"><button class="nav-link w-100 text-start active" id="btn-section-active" onclick="showSection('active')">📋 <span data-i18n="active_tasks">Active Tasks</span></button></li>
                    <li class="nav-item"><button class="nav-link w-100 text-start" id="btn-section-create" onclick="showSection('create')">➕ <span data-i18n="create_task">New Task</span></button></li>
                    <li class="nav-item"><button class="nav-link w-100 text-start" id="btn-section-completed" onclick="showSection('completed')">✅ <span data-i18n="completed_reports">Completed</span></button></li>
                    <li class="nav-item"><button class="nav-link w-100 text-start" id="btn-section-calendar" onclick="showSection('calendar')">📅 <span data-i18n="calendar_title">Calendar</span></button></li>
                    <li class="nav-item"><button class="nav-link w-100 text-start" id="btn-section-users" onclick="showSection('users')">👥 <span data-i18n="team">Team</span></button></li>
                    <li class="nav-item"><button class="nav-link w-100 text-start" id="btn-section-chat" onclick="showSection('chat')">💬 <span data-i18n="chat">Chat</span></button></li>
                </ul>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- COLOANA 2: CONȚINUTUL PRINCIPAL (CENTRU)   -->
        <!-- ========================================== -->
        <div class="col-lg-7 col-xl-8 mb-4 main-content-area">
            
            <div id="section-active"> 
                <?php include __DIR__ . '/partials/active_tasks.php'; ?> 
            </div>

            <div id="section-create" class="d-none"> 
                <?php include __DIR__ . '/partials/create_task.php'; ?> 
            </div>
            
            <div id="section-completed" class="d-none"> 
                <?php include __DIR__ . '/partials/completed_reports.php'; ?> 
            </div>
            
            <div id="section-calendar" class="d-none"> 
                <?php include __DIR__ . '/partials/calendar.php'; ?> 
            </div>
            
            <div id="section-users" class="d-none"> 
                <?php include __DIR__ . '/partials/users_section.php'; ?> 
            </div>

            <div id="section-chat" class="d-none"> 
                <?php include __DIR__ . '/partials/chat_section.php'; ?> 
            </div>
            
            <div id="section-profile" class="d-none"> 
                <?php include __DIR__ . '/partials/profile_section.php'; ?> 
            </div>

        </div>

        <!-- ========================================== -->
        <!-- COLOANA 3: STATISTICI & ECHIPA (DREAPTA)   -->
        <!-- ========================================== -->
        <div class="col-lg-3 col-xl-2 mb-4">
            
            <!-- WIDGET STATISTICI -->
            <div class="bg-white rounded shadow-sm p-3 mb-3 border-top border-3 border-success">
                <h6 class="fw-bold mb-3 text-success">📊 <span data-i18n="stats_title">Stats</span></h6>
                
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="small text-muted fw-bold" data-i18n="stat_active">Aktive:</span>
                    <span class="badge bg-primary rounded-pill fs-6" id="stat-active">0</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                    <span class="small text-muted fw-bold" data-i18n="stat_completed">Abgeschlossene:</span>
                    <span class="badge bg-success rounded-pill fs-6" id="stat-completed">0</span>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="small text-muted fw-bold" data-i18n="stat_archived">Archiv:</span>
                    <span class="badge bg-secondary rounded-pill fs-6" id="stat-archived">0</span>
                </div>
            </div>

            <!-- WIDGET ECHIPA RAPIDĂ -->
            <div class="bg-white rounded shadow-sm p-3 border-top border-3 border-info">
                <h6 class="fw-bold mb-3 text-info">👥 <span data-i18n="team_quick">Team (Online)</span></h6>
                <div id="right-sidebar-users" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                    <div class="text-center small text-muted">Loading...</div>
                </div>
            </div>

        </div>

    </div>
</div>

<!-- 4. MODALE (POP-UP-URI) -->
<?php include __DIR__ . '/partials/modals.php'; ?>

<!-- 5. SCRIPTURI JAVASCRIPT & FIREBASE -->
<?php include __DIR__ . '/partials/scripts.php'; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>