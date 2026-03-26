<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css' rel='stylesheet' />

<style>
    /* Stiluri Calendar */
    .fc-toolbar-title { font-size: 1.1rem !important; }
    .fc-button { font-size: 0.75rem !important; padding: 0.2rem 0.5rem !important; }
    .fc-event { cursor: pointer; font-size: 0.85rem; }
    .fc-event-title { font-weight: 600; }
    
    /* Thumbnails & Avatar */
    .task-thumb { width: 40px; height: 40px; object-fit: cover; border-radius: 6px; cursor: zoom-in; border: 2px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); transition: transform 0.2s; }
    .task-thumb:hover { transform: scale(3.5); z-index: 100; position: relative; border-color: #1a237e; }
    .report-avatar { width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid #198754; margin-right: 10px; }

    /* Layout Nou - Navigare Verticală */
    .nav-pills .nav-link { color: #495057; font-weight: 600; border-radius: 8px; transition: all 0.2s ease-in-out; padding: 10px 15px; }
    .nav-pills .nav-link:hover { background-color: #f8f9fa; transform: translateX(3px); }
    .nav-pills .nav-link.active { background-color: #0d6efd; color: #fff; box-shadow: 0 4px 6px rgba(13, 110, 253, 0.2); }
    
    /* Status Styles (Light Mode) */
    .row-overdue { border-left: 4px solid #dc3545; background-color: #fff5f5 !important; }
    .text-overdue { color: #dc3545; font-weight: 800; font-size: 0.7rem; text-transform: uppercase; }
    .worker-select-box { max-height: 150px; overflow-y: auto; border: 1px solid #dee2e6; padding: 8px; background: #f8f9fa; border-radius: 4px; }

    /* History & Popups */
    .history-item { border-left: 2px solid #dee2e6; padding-left: 15px; margin-bottom: 15px; position: relative; }
    .history-item::before { content: ''; position: absolute; left: -6px; top: 0; width: 10px; height: 10px; border-radius: 50%; background: #0d6efd; }
    .history-date { font-size: 0.75rem; color: #888; }
    
    #calendar-popout { position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 320px; background: rgba(30, 30, 30, 0.98); backdrop-filter: blur(8px); color: white; padding: 20px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); z-index: 9999; text-align: center; display: none; border: 1px solid rgba(255,255,255,0.2); }
    #calendar-popout h5 { font-size: 1.1rem; margin-bottom: 5px; color: #ffc107; font-weight: bold; }
    #calendar-popout p { font-size: 0.9rem; margin-bottom: 10px; color: #ddd; line-height: 1.4; }
    #calendar-popout .btn-close-custom { position: absolute; top: 10px; right: 10px; cursor: pointer; color: #aaa; font-weight: bold; font-size: 1.2rem; }
    #calendar-popout .pop-info-row { border-top: 1px solid rgba(255,255,255,0.1); margin-top: 10px; padding-top: 10px; text-align: left; font-size: 0.85rem; }
    
    /* Theme Variables (Light by default) */
    :root { --theme-primary: #0d6efd; --theme-bg: #f4f6f9; --theme-text: #212529; }
    body { background-color: var(--theme-bg); }

    /* ========================================================= */
    /* MODERN DEEP NAVY DARK MODE (SAAS ENTERPRISE PREMIUM)      */
    /* ========================================================= */
    body.theme-dark { 
        --theme-bg: #0f172a; /* Fundal principal albastru f. închis (Slate 900) */
        --theme-surface: #1e293b; /* Fundal carduri/containere (Slate 800) */
        --theme-border: #334155; /* Margini fine (Slate 700) */
        --theme-text: #f8fafc; /* Text principal clar (Slate 50) */
        --theme-text-muted: #94a3b8; /* Text secundar/informații (Slate 400) */
        background-color: var(--theme-bg) !important; 
        color: var(--theme-text) !important;
    }

    /* Carduri, Navbar, Meniuri Albe -> Trec în Navy Blue */
    body.theme-dark .card, 
    body.theme-dark .bg-white, 
    body.theme-dark .bg-light,
    body.theme-dark .navbar,
    body.theme-dark .modal-content { 
        background-color: var(--theme-surface) !important; 
        color: var(--theme-text) !important; 
        border-color: var(--theme-border) !important; 
    }

    /* Suprascriere clase de text */
    body.theme-dark .text-dark, 
    body.theme-dark .text-dark-blue,
    body.theme-dark .text-primary,
    body.theme-dark h1, body.theme-dark h2, body.theme-dark h3, body.theme-dark h4, body.theme-dark h5, body.theme-dark h6 { 
        color: var(--theme-text) !important; 
    }
    body.theme-dark .text-muted { color: var(--theme-text-muted) !important; }

    /* Fixăm butoanele principale să fie CYAN, exact ca în poză */
    body.theme-dark .btn-primary {
        background-color: #0ea5e9 !important;
        border-color: #0ea5e9 !important;
        color: #fff !important;
    }
    body.theme-dark .btn-primary:hover {
        background-color: #0284c7 !important;
        border-color: #0284c7 !important;
    }

    /* Margini globale (Borders) curățate */
    body.theme-dark .border, 
    body.theme-dark .border-top, 
    body.theme-dark .border-bottom, 
    body.theme-dark .border-start, 
    body.theme-dark .border-end {
        border-color: var(--theme-border) !important;
    }

    /* Designul Tabelului (Curat, fără gri-uri urâte) */
    body.theme-dark .table { 
        color: var(--theme-text) !important; 
        border-color: var(--theme-border) !important; 
        --bs-table-bg: transparent;
    }
    body.theme-dark .table-light, 
    body.theme-dark .table-light th, 
    body.theme-dark .table-light td { 
        background-color: #0f172a !important; 
        color: var(--theme-text) !important; 
        border-bottom: 2px solid var(--theme-border) !important;
    }
    body.theme-dark .table-hover tbody tr:hover td {
        background-color: #334155 !important;
        color: #ffffff !important;
    }
    
    /* Rândurile colorate din tabel (Overdue / LATE) */
    body.theme-dark .row-overdue {
        border-left: 4px solid #ef4444 !important; /* Roșu subțire elegant */
        background-color: rgba(239, 68, 68, 0.08) !important; /* Roșu transparent */
    }
    body.theme-dark .text-overdue { color: #fca5a5 !important; }
    
    /* Rândurile verzi (Finalizate) */
    body.theme-dark .table-success,
    body.theme-dark .table-success td {
        background-color: rgba(34, 197, 94, 0.08) !important;
        color: var(--theme-text) !important;
        border-color: rgba(34, 197, 94, 0.2) !important;
    }

    /* Meniul vertical din stânga (Pills) */
    body.theme-dark .nav-pills .nav-link { color: var(--theme-text-muted); }
    body.theme-dark .nav-pills .nav-link:hover { background-color: var(--theme-border); color: #fff; }
    body.theme-dark .nav-pills .nav-link.active { 
        background-color: #0ea5e9 !important; /* Cyan premium */
        color: #fff !important; 
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3); 
    }

    /* Input-uri, Select-uri și Dropdown-uri */
    body.theme-dark .form-control, 
    body.theme-dark .form-select { 
        background-color: #0f172a !important; 
        color: var(--theme-text) !important; 
        border-color: var(--theme-border) !important; 
    }
    body.theme-dark .form-control:focus, 
    body.theme-dark .form-select:focus {
        border-color: #0ea5e9 !important;
        box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.25) !important;
    }
    body.theme-dark .dropdown-menu { background-color: var(--theme-surface); border-color: var(--theme-border); }
    body.theme-dark .dropdown-item { color: var(--theme-text); }
    body.theme-dark .dropdown-item:hover { background-color: var(--theme-border); color: #fff; }

    /* Quill Editor în Dark Mode (Corectură totală) */
    body.theme-dark .ql-toolbar.ql-snow { background-color: var(--theme-border) !important; border-color: var(--theme-border) !important; }
    body.theme-dark .ql-container.ql-snow { background-color: #0f172a !important; border-color: var(--theme-border) !important; color: var(--theme-text) !important; }
    body.theme-dark .ql-snow .ql-stroke { stroke: var(--theme-text-muted) !important; }
    body.theme-dark .ql-snow .ql-fill, body.theme-dark .ql-snow .ql-stroke.ql-fill { fill: var(--theme-text-muted) !important; }
    body.theme-dark .ql-snow .ql-picker { color: var(--theme-text-muted) !important; }
    
    /* Modale în Dark mode - Butonul X să fie alb */
    body.theme-dark .btn-close { filter: invert(1) grayscale(100%) brightness(200%); }

    /* ========================================================= */
    /* Celelalte culori din temă (Albastru, Verde, Rosu etc)     */
    /* ========================================================= */
    body.theme-blue .navbar { background-color: #003d7a !important; }
    body.theme-blue .nav-pills .nav-link.active { background-color: #0066cc; }
    body.theme-blue .btn-primary { background-color: #0066cc; border-color: #0066cc; }

    body.theme-green .navbar { background-color: #1b4d2b !important; }
    body.theme-green .nav-pills .nav-link.active, body.theme-green .btn-primary { background-color: #2d7a3e; border-color: #2d7a3e; }

    body.theme-red .navbar { background-color: #b71c1c !important; }
    body.theme-red .nav-pills .nav-link.active, body.theme-red .btn-primary { background-color: #d32f2f; border-color: #d32f2f; }

    body.theme-purple .navbar { background-color: #4a2c7a !important; }
    body.theme-purple .nav-pills .nav-link.active, body.theme-purple .btn-primary { background-color: #6f42c1; border-color: #6f42c1; }

    .theme-btn { transition: all 0.3s ease; font-weight: 500; }
    .theme-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
    .theme-btn.active { font-weight: 700; box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25); }
</style>