/**
 * Clean Task Manager - Internationalization (i18n)
 * Supports: EN, DE, RO, IT, SQ, PL
 */

const translations = {
    en: { 
        // --- General ---
        "welcome": "Welcome",
        "logout": "Logout",
        "my_profile": "My Profile",
        "app_info": "App Info",
        "cancel": "Cancel",
        "delete": "Delete",
        "save_changes": "Save Changes",
        "actions": "Actions",
        "status": "Status",
        "date": "Date",
        "by": "By",
        
        // --- Navigation ---
        "admin_panel": "Admin Panel",
        "user_panel": "User Dashboard",
        "team": "Team",
        "tasks": "Tasks",
        "archive": "Archive",
        
        // --- Admin Dashboard Specific ---
        "create_task": "Create Task",
        "calendar_title": "Calendar",
        "active_tasks": "Active Tasks",
        "completed_reports": "Completed Reports",
        "team_mgmt": "Team Management",
        "add_employee": "Add Employee",
        "edit_task": "Edit Task",
        
        // --- Task Form ---
        "title": "Title",
        "desc": "Description",
        "images": "Images",
        "priority": "Priority",
        "deadline": "Deadline",
        "assign": "Assign",
        "global_assign": "Global (Everyone)",
        "specific_assign": "Specific Workers",
        "save_task": "SAVE TASK",
        "assigned_to": "Assigned To",
        "task": "Task",
        
        // --- User/Team Form ---
        "name": "Name",
        "job": "Job",
        "role": "Role",
        "action": "Action",
        "ph_fullname": "Full Name",
        "ph_email": "Email Address",
        "ph_pass": "Password",
        "create_user": "Create User",
        "phone": "Phone",
        
        // --- Security ---
        "security": "Security",
        "password_hint": "Update your password securely. Min 6 chars.",
        "new_password": "New Password",
        "confirm_password": "Confirm Password",
        "update_password": "Update Password"
    },
    de: { 
        "welcome": "Willkommen",
        "logout": "Abmelden",
        "my_profile": "Mein Profil",
        "app_info": "App Info",
        "cancel": "Abbrechen",
        "delete": "Löschen",
        "save_changes": "Änderungen speichern",
        "actions": "Aktionen",
        "status": "Status",
        "date": "Datum",
        "by": "Von",
        
        "admin_panel": "Admin Bereich",
        "user_panel": "Benutzer Dashboard",
        "team": "Team",
        "tasks": "Aufgaben",
        "archive": "Archiv",
        
        "create_task": "Aufgabe erstellen",
        "calendar_title": "Kalender",
        "active_tasks": "Aktive Aufgaben",
        "completed_reports": "Erledigte Berichte",
        "team_mgmt": "Teamverwaltung",
        "add_employee": "Mitarbeiter hinzufügen",
        "edit_task": "Aufgabe bearbeiten",
        
        "title": "Titel",
        "desc": "Beschreibung",
        "images": "Bilder",
        "priority": "Priorität",
        "deadline": "Frist",
        "assign": "Zuweisen",
        "global_assign": "Global (Alle)",
        "specific_assign": "Spezifisch",
        "save_task": "SPEICHERN",
        "assigned_to": "Zugewiesen an",
        "task": "Aufgabe",
        
        "name": "Name",
        "job": "Position",
        "role": "Rolle",
        "action": "Aktion",
        "ph_fullname": "Vollständiger Name",
        "ph_email": "E-Mail",
        "ph_pass": "Passwort",
        "create_user": "Erstellen",
        "phone": "Telefon",
        
        "security": "Sicherheit",
        "password_hint": "Passwort sicher aktualisieren. Min 6 Zeichen.",
        "new_password": "Neues Passwort",
        "confirm_password": "Bestätigen",
        "update_password": "Passwort ändern"
    },
    ro: { 
        "welcome": "Bine ai venit",
        "logout": "Ieșire",
        "my_profile": "Profilul Meu",
        "app_info": "Info Aplicație",
        "cancel": "Anulează",
        "delete": "Șterge",
        "save_changes": "Salvează Modificări",
        "actions": "Acțiuni",
        "status": "Status",
        "date": "Dată",
        "by": "De",
        
        "admin_panel": "Panou Admin",
        "user_panel": "Panou Utilizator",
        "team": "Echipă",
        "tasks": "Task-uri",
        "archive": "Arhivă",
        
        "create_task": "Creează Task",
        "calendar_title": "Calendar",
        "active_tasks": "Task-uri Active",
        "completed_reports": "Rapoarte Finalizate",
        "team_mgmt": "Gestiune Echipă",
        "add_employee": "Adaugă Angajat",
        "edit_task": "Editează Task",
        
        "title": "Titlu",
        "desc": "Descriere",
        "images": "Imagini",
        "priority": "Prioritate",
        "deadline": "Termen Limită",
        "assign": "Asignare",
        "global_assign": "Global (Toți)",
        "specific_assign": "Muncitori Specifici",
        "save_task": "SALVEAZĂ TASK",
        "assigned_to": "Asignat Lui",
        "task": "Task",
        
        "name": "Nume",
        "job": "Funcție",
        "role": "Rol",
        "action": "Acțiune",
        "ph_fullname": "Nume Complet",
        "ph_email": "Adresă Email",
        "ph_pass": "Parolă",
        "create_user": "Creează Utilizator",
        "phone": "Telefon",
        
        "security": "Securitate",
        "password_hint": "Actualizează parola. Min 6 caractere.",
        "new_password": "Parolă Nouă",
        "confirm_password": "Confirmă Parola",
        "update_password": "Schimbă Parola"
    },
    it: { 
        "welcome": "Benvenuto",
        "logout": "Esci",
        "my_profile": "Il Mio Profilo",
        "app_info": "Info App",
        "cancel": "Annulla",
        "delete": "Elimina",
        "save_changes": "Salva Modifiche",
        "actions": "Azioni",
        "status": "Stato",
        "date": "Data",
        "by": "Da",
        
        "admin_panel": "Pannello Amm.",
        "user_panel": "Pannello Utente",
        "team": "Team",
        "tasks": "Attività",
        "archive": "Archivio",
        
        "create_task": "Crea Attività",
        "calendar_title": "Calendario",
        "active_tasks": "Attività Attive",
        "completed_reports": "Rapporti Completati",
        "team_mgmt": "Gestione Team",
        "add_employee": "Aggiungi Dipendente",
        "edit_task": "Modifica Attività",
        
        "title": "Titolo",
        "desc": "Descrizione",
        "images": "Immagini",
        "priority": "Priorità",
        "deadline": "Scadenza",
        "assign": "Assegna",
        "global_assign": "Globale (Tutti)",
        "specific_assign": "Lavoratori Specifici",
        "save_task": "SALVA ATTIVITÀ",
        "assigned_to": "Assegnato A",
        "task": "Attività",
        
        "name": "Nome",
        "job": "Lavoro",
        "role": "Ruolo",
        "action": "Azione",
        "ph_fullname": "Nome Completo",
        "ph_email": "Email",
        "ph_pass": "Password",
        "create_user": "Crea Utente",
        "phone": "Telefono",
        
        "security": "Sicurezza",
        "password_hint": "Aggiorna password. Min 6 caratteri.",
        "new_password": "Nuova Password",
        "confirm_password": "Conferma Password",
        "update_password": "Aggiorna Password"
    },
    sq: { 
        "welcome": "Mirësevini",
        "logout": "Dalje",
        "my_profile": "Profili Im",
        "app_info": "Info Aplikacioni",
        "cancel": "Anulo",
        "delete": "Fshi",
        "save_changes": "Ruaj Ndryshimet",
        "actions": "Veprimet",
        "status": "Statusi",
        "date": "Data",
        "by": "Nga",
        
        "admin_panel": "Paneli i Adminit",
        "user_panel": "Paneli i Përdoruesit",
        "team": "Ekipi",
        "tasks": "Detyrat",
        "archive": "Arkivi",
        
        "create_task": "Krijo Detyrë",
        "calendar_title": "Kalendari",
        "active_tasks": "Detyrat Aktive",
        "completed_reports": "Raportet e Përfunduara",
        "team_mgmt": "Menaxhimi i Ekipit",
        "add_employee": "Shto Punonjës",
        "edit_task": "Ndrysho Detyrën",
        
        "title": "Titulli",
        "desc": "Përshkrimi",
        "images": "Imazhe",
        "priority": "Prioriteti",
        "deadline": "Afati",
        "assign": "Cakto",
        "global_assign": "Globale (Të gjithë)",
        "specific_assign": "Punonjës Specifikë",
        "save_task": "RUAJ DETYRËN",
        "assigned_to": "Caktuar për",
        "task": "Detyra",
        
        "name": "Emri",
        "job": "Puna",
        "role": "Roli",
        "action": "Veprimi",
        "ph_fullname": "Emri i Plotë",
        "ph_email": "Email",
        "ph_pass": "Fjalëkalimi",
        "create_user": "Krijo Përdorues",
        "phone": "Telefoni",
        
        "security": "Siguria",
        "password_hint": "Përditëso fjalëkalimin. Min 6 karaktere.",
        "new_password": "Fjalëkalimi i Ri",
        "confirm_password": "Konfirmo Fjalëkalimin",
        "update_password": "Përditëso Fjalëkalimin"
    },
    pl: { 
        "welcome": "Witaj",
        "logout": "Wyloguj",
        "my_profile": "Mój Profil",
        "app_info": "Info o Aplikacji",
        "cancel": "Anuluj",
        "delete": "Usuń",
        "save_changes": "Zapisz Zmiany",
        "actions": "Akcje",
        "status": "Status",
        "date": "Data",
        "by": "Przez",
        
        "admin_panel": "Panel Admina",
        "user_panel": "Panel Użytkownika",
        "team": "Zespół",
        "tasks": "Zadania",
        "archive": "Archiwum",
        
        "create_task": "Utwórz Zadanie",
        "calendar_title": "Kalendarz",
        "active_tasks": "Aktywne Zadania",
        "completed_reports": "Ukończone Raporty",
        "team_mgmt": "Zarządzanie Zespołem",
        "add_employee": "Dodaj Pracownika",
        "edit_task": "Edytuj Zadanie",
        
        "title": "Tytuł",
        "desc": "Opis",
        "images": "Zdjęcia",
        "priority": "Priorytet",
        "deadline": "Termin",
        "assign": "Przypisz",
        "global_assign": "Globalne (Wszyscy)",
        "specific_assign": "Konkretni Pracownicy",
        "save_task": "ZAPISZ ZADANIE",
        "assigned_to": "Przypisane Do",
        "task": "Zadanie",
        
        "name": "Imię",
        "job": "Stanowisko",
        "role": "Rola",
        "action": "Akcja",
        "ph_fullname": "Pełne Imię",
        "ph_email": "Email",
        "ph_pass": "Hasło",
        "create_user": "Utwórz Użytkownika",
        "phone": "Telefon",
        
        "security": "Bezpieczeństwo",
        "password_hint": "Zaktualizuj hasło. Min 6 znaków.",
        "new_password": "Nowe Hasło",
        "confirm_password": "Potwierdź Hasło",
        "update_password": "Zaktualizuj Hasło"
    }
};

const flagMap = { en: "🇬🇧", de: "🇩🇪", ro: "🇷🇴", it: "🇮🇹", sq: "🇦🇱", pl: "🇵🇱" };

window.setLanguage = function(lang) {
    if (!translations[lang]) lang = 'en'; // Fallback
    localStorage.setItem('appLang', lang);
    
    // Update Dropdown Flag if it exists
    const dropBtn = document.getElementById('langAdminDropdown');
    if(dropBtn) dropBtn.innerHTML = flagMap[lang] || "🌍";
    
    // Apply translations
    const dict = translations[lang];
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (dict[key]) { 
            if(el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') {
                el.placeholder = dict[key]; 
            } else {
                el.innerText = dict[key]; 
            }
        }
    });
};

// Auto-init on load
window.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('appLang') || 'en';
    window.setLanguage(savedLang);
});