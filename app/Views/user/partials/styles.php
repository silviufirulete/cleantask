<style>
    /* Stiluri specifice User */
    .card-overdue { border: 2px solid #dc3545 !important; background-color: #fff8f8; }
    .badge-overdue { background-color: #dc3545; animation: pulse 2s infinite; }
    @keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.7; } 100% { opacity: 1; } }
    
    .profile-header-img { 
        width: 150px; height: 150px; object-fit: cover; border-radius: 50%; 
        border: 3px solid #0d6efd; box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        cursor: pointer; transition: all 0.3s ease; position: relative;
    }
    .profile-header-img:hover { transform: scale(1.05); opacity: 0.9; }
    
    /* Navigare */
    .nav-pills .nav-link { border-radius: 20px; padding: 8px 15px; margin-right: 5px; font-weight: 500; cursor: pointer; color: #555; }
    .nav-pills .nav-link.active { background-color: #1a237e; color: white; }
    
    /* Notificari */
    .notif-bell { cursor: pointer; font-size: 1.2rem; position: relative; margin-right: 15px; }
    .notif-badge { position: absolute; top: -5px; right: -5px; font-size: 0.6rem; padding: 3px 5px; }
    
    /* Toast Notificare Mare */
    #task-alert-toast {
        position: fixed; top: 20px; left: 50%; transform: translateX(-50%);
        z-index: 10000; width: 90%; max-width: 400px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        border-left: 5px solid #ffc107;
        display: none;
    }
    
    /* Tabel Istoric */
    .history-row { cursor: pointer; transition: background 0.1s; }
    .history-row:hover { background-color: #f1f1f1; }
    
    /* Calendar Event Cursor */
    .fc-event { cursor: pointer; }
    
    /* Afisare Formatare Rich Text in Carduri */
    .rich-text-content ul, .rich-text-content ol { padding-left: 1.5rem; margin-bottom: 0.5rem; }
    .rich-text-content p { margin-bottom: 0.5rem; }
    
    /* Theme Variables */
    :root { --theme-primary: #0d6efd; --theme-bg: #ffffff; --theme-text: #212529; --theme-navbar-bg: #ffffff; }

    /* Dark Theme */
    body.theme-dark { --theme-bg: #1a1a1a; --theme-text: #e0e0e0; --theme-navbar-bg: #000000; background-color: #1a1a1a; }
    body.theme-dark .navbar { background-color: #000000 !important; }
    body.theme-dark .card { background-color: #2d2d2d !important; color: #e0e0e0 !important; border-color: #404040 !important; }
    body.theme-dark .table { color: #e0e0e0 !important; --bs-table-bg: #2d2d2d; }
    body.theme-dark .table-light { background-color: #3a3a3a !important; color: #e0e0e0 !important; }
    body.theme-dark .form-control, body.theme-dark .form-select { background-color: #3a3a3a; color: #e0e0e0; border-color: #555; }
    body.theme-dark .text-muted { color: #aaa !important; }

    /* Colored Themes */
    body.theme-blue .navbar { background-color: #003d7a !important; }
    body.theme-blue .nav-pills .nav-link.active { background-color: #0066cc; }
    body.theme-green .navbar { background-color: #1b4d2b !important; }
    body.theme-green .nav-pills .nav-link.active { background-color: #2d7a3e; }
    body.theme-red .navbar { background-color: #b71c1c !important; }
    body.theme-red .nav-pills .nav-link.active { background-color: #d32f2f; }
    body.theme-purple .navbar { background-color: #4a2c7a !important; }
    body.theme-purple .nav-pills .nav-link.active { background-color: #6f42c1; }
    
    /* Theme Buttons */
    .theme-btn { transition: all 0.3s ease; font-weight: 500; }
    .theme-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
    .theme-btn.active { font-weight: 700; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25); }
    .btn-outline-purple { color: #6f42c1; border-color: #6f42c1; }
    .btn-outline-purple:hover { background-color: #6f42c1; color: white !important; }

    /* iOS Install Banner */
    .ios-install-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white; padding: 12px 16px; border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown { from { transform: translateY(-100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>