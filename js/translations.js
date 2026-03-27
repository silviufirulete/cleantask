/**
 * SISTEM CENTRALIZAT DE TRADUCERI (ADMIN + USER)
 * Include absolut toate cheile pentru Dashboard, Calendar, Chat, Teme și Pop-up-uri
 */

const translations = {
    en: { 
        admin_panel: "Admin Panel", welcome: "Welcome", team: "Team", tasks: "Tasks", 
        create_task: "New Task", title: "Title", desc: "Description", images: "Images", 
        priority: "Priority", deadline: "Deadline", assign: "Assign", 
        global_assign: "Global (All Workers)", specific_assign: "Specific Workers", 
        save_task: "SAVE TASK", active_tasks: "Active Tasks", completed_reports: "Completed Reports", 
        task: "Task", assigned_to: "Assigned To", status: "Status", actions: "Actions", 
        date: "Date", by: "By", calendar_title: "Calendar Overview", archive: "Archive", 
        team_mgmt: "Team Management", name: "Name", job: "Job Title", role: "Role", 
        action: "Action", add_employee: "Add Employee", ph_fullname: "Full Name", 
        ph_email: "Email Address", email: "Email", ph_pass: "Password (min 6 chars)", create_user: "Create User", 
        my_profile: "My Profile", logout: "Logout", phone: "Phone Number", 
        save_changes: "Save Changes", edit_task: "Edit Task", cancel: "Cancel", 
        delete: "Delete", check_perms: "Connecting to system...", req_label: "Requirements", 
        req_mopp: "Mopp", req_tuch: "Cloths", req_mittel: "Detergents", req_other: "Other", req_other_placeholder: "Describe what is needed...",
        theme_settings: "Theme Settings", theme_description: "Customize appearance", 
        select_theme: "Select Theme", theme_light: "Light", theme_dark: "Dark", 
        theme_blue: "Ocean Blue", theme_green: "Forest Green", theme_red: "Vibrant Red", theme_purple: "Royal Purple",
        current_theme: "Current:", security_settings: "Security Settings", change_email: "Change Email", 
        current_email: "Current Email", new_email: "New Email", confirm_password: "Confirm Password", 
        update_email: "Update Email", change_password: "Change Password", 
        current_password: "Current Password", new_password: "New Password", 
        confirm_new_password: "Confirm New Password", update_password: "Update Password", 
        sort_by: "Sort", sort_newest: "Newest First", sort_oldest: "Oldest First", 
        sort_name: "By Name (A-Z)", created_by_date: "Created By / Date",

        // NEW: Dashboard 3 Columns
        menu_title: "Navigation Menu", stats_title: "Live Statistics", stat_active: "Active:", 
        stat_completed: "Completed:", stat_archived: "Archived:", team_quick: "Team (Online)",
        
        // Report & Logs
        report_final_title: "Completion Report", completed_by: "Completed by",
        comment: "Comment", no_comment: "No comment provided.", loading: "Loading...",
        logs_title: "Task Logs & Notes", no_logs: "No history logs found.",
        unknown_user: "Unknown User", system: "System", download_pdf: "Download PDF",

        // User Specific
        worker_db: "Worker Dashboard", tab_tasks: "My Tasks", tab_done: "History", 
        tab_calendar: "Calendar", active_tasks_title: "Active Tasks", no_tasks_msg: "No tasks.", 
        history_title: "History", btn_report: "Report / Start", report_title: "Report", 
        report_comment: "Comment (Optional)", report_photo: "Photo / Gallery", btn_send: "Send", btn_save: "Save", 
        task_overdue: "OVERDUE", btn_claim: "Claim Task", claimed_by: "Taken by", 
        confirm_claim: "Take this task?", view_images: "View Images", notifications: "Notifications", 
        clear: "Clear", no_notifs: "No new notifications", new_task_alert: "New Task!", 
        add_event: "Add Event", event_type: "Type", start_date: "Start Date", end_date: "End Date",
        completed_task: "Completed Task", proof_photo: "Proof Photo", report_action: "Action",
        report_comment_req: "Reason (Required)", report_comment_opt: "Comment (Optional)",
        pref_lang: "Language", btn_cancel: "Cancel", close: "Close", start_time: "Start Time", end_time: "End Time",
        col_task: "Task", col_date: "Date", col_name: "Name", col_phone: "Phone", my_calendar: "My Calendar",
        enable_push_msg: "Enable push notifications?", enable: "Enable",

        // CALENDAR DYNAMIC KEYS
        cal_from: "From", cal_to: "To", cal_deadline: "Deadline", 
        cal_event: "Event", cal_desc: "Description", cal_status: "Status",
        cal_assigned: "Assigned", cal_taken: "Taken by", cal_global: "Global (Open)",
        cal_type: "Type",

        // CHAT SYSTEM KEYS
        chat: "Live Chat", chat_placeholder: "Write a message...", 
        chat_no_messages: "No messages yet. Be the first to write!", 
        chat_send_error: "Could not send message.",

        // VIEW TASK DETAILS (OCHIUL)
        view_task_title: "👁️ View Task", close_btn: "Close", no_title: "No title", 
        taken_by: "Taken by", no_images_attached: "No images attached at creation.",
        confirm_archive: "Are you sure you want to move this task to the Archive?"
    },
    ro: { 
        admin_panel: "Panou Admin", welcome: "Bine ai venit", team: "Echipă", tasks: "Sarcini", 
        create_task: "Task Nou", title: "Titlu", desc: "Descriere", images: "Imagini", 
        priority: "Prioritate", deadline: "Termen limită", assign: "Asignează", 
        global_assign: "Global (Toți)", specific_assign: "Angajați Specifici", 
        save_task: "SALVEAZĂ TASK", active_tasks: "Task-uri Active", 
        completed_reports: "Rapoarte Finalizate", task: "Task", assigned_to: "Asignat lui", 
        status: "Status", actions: "Acțiuni", date: "Dată", by: "De", calendar_title: "Calendar", 
        archive: "Arhivă", team_mgmt: "Managementul Echipei", name: "Nume", job: "Funcție", 
        role: "Rol", action: "Acțiune", add_employee: "Adaugă Angajat", ph_fullname: "Nume Complet", 
        ph_email: "Adresă Email", email: "Email", ph_pass: "Parolă (min 6 caractere)", create_user: "Creează Utilizator", 
        my_profile: "Profilul Meu", logout: "Deconectare", phone: "Telefon", 
        save_changes: "Salvează Modificări", edit_task: "Editează Task", cancel: "Anulează", 
        delete: "Șterge", check_perms: "Conectare la sistem...", req_label: "Necesar", 
        req_mopp: "Mop", req_tuch: "Lavete", req_mittel: "Detergenți", req_other: "Altele", req_other_placeholder: "Descrieți ce este necesar...",
        theme_settings: "Setări Temă", theme_description: "Personalizează aspectul", 
        select_theme: "Alege Tema", theme_light: "Luminos", theme_dark: "Întunecat", 
        theme_blue: "Albastru", theme_green: "Verde", theme_red: "Roșu", theme_purple: "Mov",
        current_theme: "Curent:", security_settings: "Setări Securitate", change_email: "Schimbă Email", 
        current_email: "Email Actual", new_email: "Email Nou", confirm_password: "Confirmă Parola", 
        update_email: "Actualizează Email", change_password: "Schimbă Parola", 
        current_password: "Parola Actuală", new_password: "Parolă Nouă", 
        confirm_new_password: "Confirmă Parola Nouă", update_password: "Actualizează Parola", 
        sort_by: "Sortare", sort_newest: "Cele mai noi", sort_oldest: "Cele mai vechi", 
        sort_name: "După nume (A-Z)", created_by_date: "Creat de / Data",

        // NEW: Dashboard 3 Columns
        menu_title: "Meniu Navigare", stats_title: "Statistici Live", stat_active: "Active:", 
        stat_completed: "Închise:", stat_archived: "Arhivate:", team_quick: "Echipa (Online)",
        
        // Report & Logs
        report_final_title: "Raport Finalizare", completed_by: "Finalizat de",
        comment: "Comentariu", no_comment: "Fără comentariu.", loading: "Se încarcă...",
        logs_title: "Jurnal & Notițe", no_logs: "Nu există istoric.",
        unknown_user: "Utilizator Necunoscut", system: "Sistem", download_pdf: "Descarcă PDF",

        // User Specific
        worker_db: "Panou Muncitor", tab_tasks: "Sarcini", tab_done: "Istoric", 
        tab_calendar: "Calendar", active_tasks_title: "Sarcini Active", no_tasks_msg: "Nu ai sarcini.", 
        history_title: "Istoric", btn_report: "Raportează", report_title: "Raportare", 
        report_comment: "Comentariu (Opțional)", report_photo: "Poză / Galerie", btn_send: "Trimite", btn_save: "Salvează", 
        task_overdue: "ÎNTÂRZIAT", btn_claim: "Preia", claimed_by: "Preluat de", 
        confirm_claim: "Vrei să preiei?", view_images: "Vezi Poze", notifications: "Notificări", 
        clear: "Șterge", no_notifs: "Nu sunt notificări", new_task_alert: "Sarcină Nouă!", 
        add_event: "Adaugă Eveniment", event_type: "Tip", start_date: "Dată Început", end_date: "Dată Sfârșit",
        completed_task: "Sarcină Finalizată", proof_photo: "Poză dovadă", report_action: "Acțiune",
        report_comment_req: "Motiv (Obligatoriu)", report_comment_opt: "Comentariu (Opțional)",
        pref_lang: "Limbă", btn_cancel: "Anulează", close: "Închide", start_time: "Oră Început", end_time: "Oră Sfârșit",
        col_task: "Sarcină", col_date: "Dată", col_name: "Nume", col_phone: "Telefon", my_calendar: "Calendarul Meu",
        enable_push_msg: "Activezi notificările?", enable: "Activează",

        // CALENDAR DYNAMIC KEYS
        cal_from: "De la", cal_to: "Până la", cal_deadline: "Termen limită", 
        cal_event: "Eveniment", cal_desc: "Descriere", cal_status: "Status",
        cal_assigned: "Alocat", cal_taken: "Preluat de", cal_global: "Global (Deschis)",
        cal_type: "Tip",

        // CHAT SYSTEM KEYS
        chat: "Chat Live", chat_placeholder: "Scrie un mesaj...", 
        chat_no_messages: "Niciun mesaj încă. Fii primul care scrie!", 
        chat_send_error: "Nu s-a putut trimite mesajul.",

        // VIEW TASK DETAILS (OCHIUL)
        view_task_title: "👁️ Vizualizare Task", close_btn: "Închide", no_title: "Fără titlu", 
        taken_by: "Preluat de", no_images_attached: "Nicio imagine atașată la creare.",
        confirm_archive: "Sunteți sigur că doriți să mutați acest task în Arhivă?"
    },
    de: { 
        admin_panel: "Admin Panel", welcome: "Willkommen", team: "Team", tasks: "Aufgaben", 
        create_task: "Neue Aufgabe", title: "Titel", desc: "Beschreibung", images: "Bilder", 
        priority: "Priorität", deadline: "Frist", assign: "Zuweisen", 
        global_assign: "Global (Alle)", specific_assign: "Spezifische Mitarbeiter", 
        save_task: "AUFGABE SPEICHERN", active_tasks: "Aktive Aufgaben", 
        completed_reports: "Abgeschlossene Berichte", task: "Aufgabe", assigned_to: "Zugewiesen an", 
        status: "Status", actions: "Aktionen", date: "Datum", by: "Von", calendar_title: "Kalenderübersicht", 
        archive: "Archiv", team_mgmt: "Teamverwaltung", name: "Name", job: "Berufsbezeichnung", 
        role: "Rolle", action: "Aktion", add_employee: "Mitarbeiter hinzufügen", 
        ph_fullname: "Vollständiger Name", ph_email: "E-Mail-Adresse", email: "E-Mail", ph_pass: "Passwort (mind. 6 Zeichen)", 
        create_user: "Benutzer erstellen", my_profile: "Mein Profil", logout: "Abmelden", 
        phone: "Telefonnummer", save_changes: "Änderungen speichern", edit_task: "Aufgabe bearbeiten", 
        cancel: "Abbrechen", delete: "Löschen", check_perms: "Verbindung wird hergestellt...", 
        req_label: "Erforderlich", req_mopp: "Mopp", req_tuch: "Tücher", req_mittel: "Mittel", 
        req_other: "Sonstige", req_other_placeholder: "Beschreiben Sie was benötigt wird...", theme_settings: "Theme-Einstellungen",
        theme_description: "Passen Sie das Aussehen an", select_theme: "Theme auswählen", 
        theme_light: "Helles", theme_dark: "Dunkles", theme_blue: "Ozeanblau", theme_green: "Waldgrün", 
        theme_red: "Leuchtendes Rot", theme_purple: "Königliches Lila", current_theme: "Aktuell:", 
        security_settings: "Sicherheitseinstellungen", change_email: "E-Mail ändern", 
        current_email: "Aktuelle E-Mail", new_email: "Neue E-Mail", confirm_password: "Passwort bestätigen", 
        update_email: "E-Mail aktualisieren", change_password: "Passwort ändern", current_password: "Aktuelles Passwort", 
        new_password: "Neues Passwort", confirm_new_password: "Neues Passwort bestätigen", 
        update_password: "Passwort aktualisieren", sort_by: "Sortieren", 
        sort_newest: "Neueste zuerst", sort_oldest: "Älteste zuerst", 
        sort_name: "Nach Name (A-Z)", created_by_date: "Erstellt von / Datum",

        // NEW: Dashboard 3 Columns
        menu_title: "Navigationsmenü", stats_title: "Live-Statistiken", stat_active: "Aktiv:", 
        stat_completed: "Abgeschlossen:", stat_archived: "Archiviert:", team_quick: "Team (Online)",
        
        // Report & Logs
        report_final_title: "Abschlussbericht", completed_by: "Abgeschlossen von",
        comment: "Kommentar", no_comment: "Kein Kommentar.", loading: "Laden...",
        logs_title: "Protokolle & Notizen", no_logs: "Keine Protokolle gefunden.",
        unknown_user: "Unbekannter Benutzer", system: "System", download_pdf: "PDF herunterladen",

        // User Specific
        worker_db: "Mitarbeiter", tab_tasks: "Aufgaben", tab_done: "Verlauf", 
        tab_calendar: "Kalender", active_tasks_title: "Aktive Aufgaben", no_tasks_msg: "Keine Aufgaben.", 
        history_title: "Verlauf", btn_report: "Berichten", report_title: "Bericht", 
        report_comment: "Kommentar (Optional)", report_photo: "Foto / Galerie", btn_send: "Senden", btn_save: "Speichern", 
        task_overdue: "VERSPÄTET", btn_claim: "Übernehmen", claimed_by: "Übernommen von", 
        confirm_claim: "Aufgabe übernehmen?", view_images: "Bilder", notifications: "Benachrichtigungen", 
        clear: "Löschen", no_notifs: "Keine Benachrichtigungen", new_task_alert: "Neue Aufgabe!", 
        add_event: "Termin hinzufügen", event_type: "Typ", start_date: "Startdatum", end_date: "Enddatum",
        completed_task: "Erledigte Aufgabe", proof_photo: "Beweisfoto", report_action: "Aktion",
        report_comment_req: "Grund (Erforderlich)", report_comment_opt: "Kommentar (Optional)",
        pref_lang: "Sprache", btn_cancel: "Abbrechen", close: "Schließen", start_time: "Startzeit", end_time: "Endzeit",
        col_task: "Aufgabe", col_date: "Datum", col_name: "Name", col_phone: "Telefon", my_calendar: "Mein Kalender",
        enable_push_msg: "Push-Benachrichtigungen aktivieren?", enable: "Aktivieren",

        // CALENDAR DYNAMIC KEYS
        cal_from: "Von", cal_to: "Bis", cal_deadline: "Frist", 
        cal_event: "Ereignis", cal_desc: "Beschreibung", cal_status: "Status",
        cal_assigned: "Zugewiesen", cal_taken: "Übernommen von", cal_global: "Global (Offen)",
        cal_type: "Typ",

        // CHAT SYSTEM KEYS
        chat: "Live-Chat", chat_placeholder: "Schreibe eine Nachricht...", 
        chat_no_messages: "Noch keine Nachrichten. Sei der Erste, der schreibt!", 
        chat_send_error: "Nachricht konnte nicht gesendet werden.",

        // VIEW TASK DETAILS (OCHIUL)
        view_task_title: "👁️ Aufgabe ansehen", close_btn: "Schließen", no_title: "Kein Titel", 
        taken_by: "Übernommen von", no_images_attached: "Keine Bilder beim Erstellen angehängt.",
        confirm_archive: "Sind Sie sicher, dass Sie diese Aufgabe ins Archiv verschieben möchten?"
    },
    it: {
        admin_panel: "Pannello Admin", welcome: "Benvenuto", team: "Team", tasks: "Compiti",
        create_task: "Nuovo Compito", title: "Titolo", desc: "Descrizione", images: "Immagini",
        priority: "Priorità", deadline: "Scadenza", assign: "Assegna", 
        global_assign: "Globale (Tutti)", specific_assign: "Lavoratori Specifici", 
        save_task: "SALVA COMPITO", active_tasks: "Compiti Attivi", completed_reports: "Rapporti Completati", 
        task: "Compito", assigned_to: "Assegnato a", status: "Stato", actions: "Azioni", date: "Data", 
        by: "Da", calendar_title: "Calendario", archive: "Archivio", team_mgmt: "Gestione Team", 
        name: "Nome", job: "Ruolo", role: "Ruolo", action: "Azione", add_employee: "Aggiungi Dipendente", 
        ph_fullname: "Nome Completo", ph_email: "Indirizzo Email", email: "Email", ph_pass: "Password (min 6 car.)", 
        create_user: "Crea Utente", my_profile: "Il mio Profilo", logout: "Esci", phone: "Telefono", 
        save_changes: "Salva Modifiche", edit_task: "Modifica Compito", cancel: "Annulla", 
        delete: "Elimina", check_perms: "Connessione al sistema...", req_label: "Requisiti", 
        req_mopp: "Mocio", req_tuch: "Panni", req_mittel: "Detergenti", req_other: "Altro", req_other_placeholder: "Descrivi cosa è necessario...",
        theme_settings: "Impostazioni Tema", theme_description: "Personalizza l'aspetto", select_theme: "Scegli Tema", 
        theme_light: "Chiaro", theme_dark: "Scuro", theme_blue: "Blu Oceano", theme_green: "Verde Foresta", 
        theme_red: "Rosso Vivace", theme_purple: "Viola Reale", current_theme: "Attuale:", 
        security_settings: "Impostazioni Sicurezza", change_email: "Cambia Email", current_email: "Email Attuale", 
        new_email: "Nuova Email", confirm_password: "Conferma Password", update_email: "Aggiorna Email", 
        change_password: "Cambia Password", current_password: "Password Attuale", new_password: "Nuova Password", 
        confirm_new_password: "Conferma Nuova Password", update_password: "Aggiorna Password", 
        sort_by: "Ordina per", sort_newest: "I più recenti", sort_oldest: "I più vecchi", sort_name: "Per nome (A-Z)", 
        created_by_date: "Creato Da / Data",

        // NEW: Dashboard 3 Columns
        menu_title: "Menu di Navigazione", stats_title: "Statistiche Live", stat_active: "Attivi:", 
        stat_completed: "Completati:", stat_archived: "Archiviati:", team_quick: "Team (Online)",

        // Report & Logs
        report_final_title: "Rapporto Finale", completed_by: "Completato da", comment: "Commento",
        no_comment: "Nessun commento.", loading: "Caricamento...", logs_title: "Registri e Note",
        no_logs: "Nessun registro trovato.", unknown_user: "Utente Sconosciuto", system: "Sistema", download_pdf: "Scarica PDF",

        // User Specific
        worker_db: "Pannello Lavoratore", tab_tasks: "I miei Compiti", tab_done: "Cronologia", 
        tab_calendar: "Calendario", active_tasks_title: "Compiti Attivi", no_tasks_msg: "Nessun compito.", 
        history_title: "Cronologia", btn_report: "Rapporto", report_title: "Segnala", 
        report_comment: "Commento (Opzionale)", report_photo: "Foto / Galleria", btn_send: "Invia", btn_save: "Salva", 
        task_overdue: "IN RITARDO", btn_claim: "Prendi", claimed_by: "Preso da", confirm_claim: "Prendere questo compito?", 
        view_images: "Vedi Immagini", notifications: "Notifiche", clear: "Cancella", no_notifs: "Nessuna notifica", 
        new_task_alert: "Nuovo Compito!", add_event: "Aggiungi Evento", event_type: "Tipo", start_date: "Data Inizio", 
        end_date: "Data Fine", completed_task: "Compito Completato", proof_photo: "Foto Prova", report_action: "Azione",
        report_comment_req: "Motivo (Obbligatorio)", report_comment_opt: "Commento (Opzionale)", pref_lang: "Lingua", 
        btn_cancel: "Annulla", close: "Chiudi", start_time: "Ora Inizio", end_time: "Ora Fine",
        col_task: "Compito", col_date: "Data", col_name: "Nome", col_phone: "Telefono", my_calendar: "Il Mio Calendario",
        enable_push_msg: "Abilitare le notifiche push?", enable: "Abilita",

        // CALENDAR DYNAMIC KEYS
        cal_from: "Da", cal_to: "A", cal_deadline: "Scadenza", cal_event: "Evento", cal_desc: "Descrizione", 
        cal_status: "Stato", cal_assigned: "Assegnato", cal_taken: "Preso da", cal_global: "Globale (Aperto)", cal_type: "Tipo",

        // CHAT SYSTEM KEYS
        chat: "Chat dal vivo", chat_placeholder: "Scrivi un messaggio...", 
        chat_no_messages: "Nessun messaggio ancora. Scrivi per primo!", chat_send_error: "Impossibile inviare il messaggio.",

        // VIEW TASK DETAILS
        view_task_title: "👁️ Visualizza Compito", close_btn: "Chiudi", no_title: "Nessun titolo", 
        taken_by: "Preso da", no_images_attached: "Nessuna immagine allegata alla creazione.",
        confirm_archive: "Sei sicuro di voler spostare questo compito nell'Archivio?"
    },
    sq: {
        admin_panel: "Paneli Admin", welcome: "Mirësevini", team: "Ekipi", tasks: "Detyrat",
        create_task: "Detyrë e Re", title: "Titulli", desc: "Përshkrimi", images: "Imazhe",
        priority: "Prioriteti", deadline: "Afati", assign: "Cakto", global_assign: "Global (Të Gjithë)", 
        specific_assign: "Punëtorë Specifikë", save_task: "RUAJ DETYRËN", active_tasks: "Detyra Aktive", 
        completed_reports: "Raporte të Përfunduara", task: "Detyrë", assigned_to: "Caktuar për", 
        status: "Statusi", actions: "Veprimet", date: "Data", by: "Nga", calendar_title: "Kalendari", 
        archive: "Arkivi", team_mgmt: "Menaxhimi i Ekipit", name: "Emri", job: "Pozicioni", role: "Roli", 
        action: "Veprim", add_employee: "Shto Punëtor", ph_fullname: "Emri i Plotë", ph_email: "Email Adresa", 
        email: "Email", ph_pass: "Fjalëkalimi (min 6 karaktere)", create_user: "Krijo Përdorues", 
        my_profile: "Profili Im", logout: "Dil", phone: "Telefoni", save_changes: "Ruaj Ndryshimet", 
        edit_task: "Ndrysho Detyrën", cancel: "Anulo", delete: "Fshi", check_perms: "Po lidhet...", 
        req_label: "Kërkohet", req_mopp: "Leckë", req_tuch: "Lecka", req_mittel: "Detergjent", req_other: "Tjetër", req_other_placeholder: "Përshkruani çfarë nevojitet...",
        theme_settings: "Cilësimet e Temës", theme_description: "Personalizo pamjen", select_theme: "Zgjidh Temën", 
        theme_light: "E Hapur", theme_dark: "E Errët", theme_blue: "Blu Oqeani", theme_green: "E Gjelbër Pylli", 
        theme_red: "E Kuqe e Ndritshme", theme_purple: "Vjollcë Mbretërore", current_theme: "Aktuale:", 
        security_settings: "Cilësimet e Sigurisë", change_email: "Ndrysho Emailin", current_email: "Emaili Aktual", 
        new_email: "Email i Ri", confirm_password: "Konfirmo Fjalëkalimin", update_email: "Përditëso Emailin", 
        change_password: "Ndrysho Fjalëkalimin", current_password: "Fjalëkalimi Aktual", new_password: "Fjalëkalimi i Ri", 
        confirm_new_password: "Konfirmo Fjalëkalimin e Ri", update_password: "Përditëso Fjalëkalimin", 
        sort_by: "Rendit", sort_newest: "Më të rejat", sort_oldest: "Më të vjetrat", sort_name: "Nga emri (A-Z)", 
        created_by_date: "Krijuar Nga / Data",

        // NEW: Dashboard 3 Columns
        menu_title: "Menyja e Navigimit", stats_title: "Statistikat Live", stat_active: "Aktive:", 
        stat_completed: "Të Përfunduara:", stat_archived: "Të Arkivuara:", team_quick: "Ekipi (Online)",

        // Report & Logs
        report_final_title: "Raporti i Përfundimit", completed_by: "Përfunduar nga", comment: "Komenti",
        no_comment: "S'ka koment.", loading: "Duke ngarkuar...", logs_title: "Regjistrat e Detyrës",
        no_logs: "Nuk u gjetën regjistra.", unknown_user: "Përdorues i Panjohur", system: "Sistemi", download_pdf: "Shkarko PDF",

        // User Specific
        worker_db: "Paneli i Punëtorit", tab_tasks: "Detyrat e Mia", tab_done: "Historia", tab_calendar: "Kalendari", 
        active_tasks_title: "Detyra Aktive", no_tasks_msg: "S'ka detyra.", history_title: "Historia", 
        btn_report: "Raporto", report_title: "Raport", report_comment: "Komenti (Opsional)", 
        report_photo: "Foto / Galeri", btn_send: "Dërgo", btn_save: "Ruaj", task_overdue: "I VONUAR", 
        btn_claim: "Merr", claimed_by: "Marrë nga", confirm_claim: "Të marrësh këtë detyrë?", 
        view_images: "Shiko Imazhet", notifications: "Njoftimet", clear: "Pastro", no_notifs: "S'ka njoftime", 
        new_task_alert: "Detyrë e Re!", add_event: "Shto Ngjarje", event_type: "Lloji", start_date: "Data e Fillimit", 
        end_date: "Data e Përfundimit", completed_task: "Detyrë e Përfunduar", proof_photo: "Foto Dëshmi", 
        report_action: "Veprim", report_comment_req: "Arsyeja (Detyrueshme)", report_comment_opt: "Komenti (Opsional)", 
        pref_lang: "Gjuha", btn_cancel: "Anulo", close: "Mbyll", start_time: "Ora e Fillimit", end_time: "Ora e Përfundimit",
        col_task: "Detyrë", col_date: "Data", col_name: "Emri", col_phone: "Telefoni", my_calendar: "Kalendari Im",
        enable_push_msg: "Aktivizo njoftimet?", enable: "Aktivizo",

        // CALENDAR DYNAMIC KEYS
        cal_from: "Nga", cal_to: "Deri", cal_deadline: "Afati", cal_event: "Ngjarje", cal_desc: "Përshkrimi", 
        cal_status: "Statusi", cal_assigned: "Caktuar", cal_taken: "Marrë nga", cal_global: "Global (Hapur)", cal_type: "Lloji",

        // CHAT SYSTEM KEYS
        chat: "Bisedë Live", chat_placeholder: "Shkruaj një mesazh...", 
        chat_no_messages: "Asnjë mesazh ende. Bëhuni i pari që shkruani!", chat_send_error: "Nuk mund të dërgohej mesazhi.",

        // VIEW TASK DETAILS
        view_task_title: "👁️ Shiko Detyrën", close_btn: "Mbyll", no_title: "Pa titull", 
        taken_by: "Marrë nga", no_images_attached: "Asnjë imazh i bashkangjitur në krijim.",
        confirm_archive: "A jeni i sigurt që dëshironi ta zhvendosni këtë detyrë në Arkiv?"
    },
    pl: {
        admin_panel: "Panel Admina", welcome: "Witamy", team: "Zespół", tasks: "Zadania",
        create_task: "Nowe Zadanie", title: "Tytuł", desc: "Opis", images: "Zdjęcia",
        priority: "Priorytet", deadline: "Termin", assign: "Przypisz", global_assign: "Globalne (Wszyscy)", 
        specific_assign: "Wybrani Pracownicy", save_task: "ZAPISZ ZADANIE", active_tasks: "Aktywne Zadania", 
        completed_reports: "Zakończone Raporty", task: "Zadanie", assigned_to: "Przypisane do", 
        status: "Status", actions: "Akcje", date: "Data", by: "Przez", calendar_title: "Kalendarz", 
        archive: "Archiwum", team_mgmt: "Zarządzanie Zespołem", name: "Imię", job: "Stanowisko", role: "Rola", 
        action: "Akcja", add_employee: "Dodaj Pracownika", ph_fullname: "Pełne Imię", ph_email: "Adres Email", 
        email: "Email", ph_pass: "Hasło (min. 6 znaków)", create_user: "Utwórz Użytkownika", 
        my_profile: "Mój Profil", logout: "Wyloguj", phone: "Telefon", save_changes: "Zapisz Zmiany", 
        edit_task: "Edytuj Zadanie", cancel: "Anuluj", delete: "Usuń", check_perms: "Łączenie z systemem...", 
        req_label: "Wymagania", req_mopp: "Mop", req_tuch: "Ścierki", req_mittel: "Środki", req_other: "Inne", req_other_placeholder: "Opisz co jest potrzebne...",
        theme_settings: "Ustawienia Motywu", theme_description: "Dostosuj wygląd", select_theme: "Wybierz Motyw", 
        theme_light: "Jasny", theme_dark: "Ciemny", theme_blue: "Błękit Oceanu", theme_green: "Leśna Zieleń", 
        theme_red: "Żywa Czerwień", theme_purple: "Królewski Fiolet", current_theme: "Obecny:", 
        security_settings: "Ustawienia Bezpieczeństwa", change_email: "Zmień Email", current_email: "Obecny Email", 
        new_email: "Nowy Email", confirm_password: "Potwierdź Hasło", update_email: "Aktualizuj Email", 
        change_password: "Zmień Hasło", current_password: "Obecne Hasło", new_password: "Nowe Hasło", 
        confirm_new_password: "Potwierdź Nowe Hasło", update_password: "Aktualizuj Hasło", 
        sort_by: "Sortuj", sort_newest: "Najnowsze", sort_oldest: "Najstarsze", sort_name: "Po nazwie (A-Z)", 
        created_by_date: "Utworzone przez / Data",

        // NEW: Dashboard 3 Columns
        menu_title: "Menu Nawigacji", stats_title: "Statystyki na żywo", stat_active: "Aktywne:", 
        stat_completed: "Zakończone:", stat_archived: "Zarchiwizowane:", team_quick: "Zespół (Online)",

        // Report & Logs
        report_final_title: "Raport Końcowy", completed_by: "Ukończone przez", comment: "Komentarz",
        no_comment: "Brak komentarza.", loading: "Ładowanie...", logs_title: "Dzienniki i Notatki",
        no_logs: "Brak historii.", unknown_user: "Nieznany Użytkownik", system: "System", download_pdf: "Pobierz PDF",

        // User Specific
        worker_db: "Panel Pracownika", tab_tasks: "Moje Zadania", tab_done: "Historia", tab_calendar: "Kalendarz", 
        active_tasks_title: "Aktywne Zadania", no_tasks_msg: "Brak zadań.", history_title: "Historia", 
        btn_report: "Raport", report_title: "Zgłoś", report_comment: "Komentarz (Opcjonalny)", 
        report_photo: "Zdjęcie / Galeria", btn_send: "Wyślij", btn_save: "Zapisz", task_overdue: "OPÓŹNIONE", 
        btn_claim: "Zgłoś się", claimed_by: "Przyjęte przez", confirm_claim: "Przyjąć to zadanie?", 
        view_images: "Zobacz Zdjęcia", notifications: "Powiadomienia", clear: "Wyczyść", no_notifs: "Brak nowych powiadomień", 
        new_task_alert: "Nowe Zadanie!", add_event: "Dodaj Wydarzenie", event_type: "Typ", start_date: "Data Początkowa", 
        end_date: "Data Końcowa", completed_task: "Ukończone Zadanie", proof_photo: "Zdjęcie Dowodowe", 
        report_action: "Akcja", report_comment_req: "Powód (Wymagany)", report_comment_opt: "Komentarz (Opcjonalny)", 
        pref_lang: "Język", btn_cancel: "Anuluj", close: "Zamknij", start_time: "Czas Rozpoczęcia", end_time: "Czas Zakończenia",
        col_task: "Zadanie", col_date: "Data", col_name: "Imię", col_phone: "Telefon", my_calendar: "Mój Kalendarz",
        enable_push_msg: "Włączyć powiadomienia?", enable: "Włącz",

        // CALENDAR DYNAMIC KEYS
        cal_from: "Od", cal_to: "Do", cal_deadline: "Termin", cal_event: "Wydarzenie", cal_desc: "Opis", 
        cal_status: "Status", cal_assigned: "Przypisane", cal_taken: "Przyjęte przez", cal_global: "Globalne (Otwarte)", cal_type: "Typ",

        // CHAT SYSTEM KEYS
        chat: "Czat na żywo", chat_placeholder: "Napisz wiadomość...", 
        chat_no_messages: "Brak wiadomości. Bądź pierwszym, który napisze!", chat_send_error: "Nie udało się wysłać wiadomości.",

        // VIEW TASK DETAILS
        view_task_title: "👁️ Zobacz Zadanie", close_btn: "Zamknij", no_title: "Brak tytułu", 
        taken_by: "Przyjęte przez", no_images_attached: "Brak zdjęć dołączonych przy tworzeniu.",
        confirm_archive: "Czy na pewno chcesz przenieść to zadanie do Archiwum?"
    }
};

const langNames = { en: "🇬🇧 EN", ro: "🇷🇴 RO", de: "🇩🇪 DE", sq: "🇦🇱 SQ", pl: "🇵🇱 PL", it: "🇮🇹 IT" };

function setLanguage(lang) {
    if (!translations[lang]) lang = 'en'; 
    localStorage.setItem('appLang', lang);
    const dropBtn = document.getElementById('langAdminDropdown') || document.getElementById('langUserDropdown') || document.getElementById('languageDropdown');
    
    // Setăm steagul în Navbar, în funcție de unde se află utilizatorul
    if(dropBtn) {
        if(dropBtn.id === 'languageDropdown') {
            dropBtn.innerHTML = '🌍 Language'; // Pe pagina de Login păstrăm textul globului
        } else {
            dropBtn.innerHTML = langNames[lang] ? langNames[lang].split(' ')[0] : '🌍';
        }
    }

    const dict = translations[lang];
    document.querySelectorAll('[data-i18n]').forEach(el => {
        const key = el.getAttribute('data-i18n');
        if (dict[key]) {
            if (el.tagName === 'INPUT' || el.tagName === 'TEXTAREA') el.placeholder = dict[key];
            else el.textContent = dict[key];
        }
    });
    // Trigger event so Calendar knows to re-render
    window.dispatchEvent(new CustomEvent('languageChanged', { detail: { lang: lang } }));
}

document.addEventListener('DOMContentLoaded', () => {
    const savedLang = localStorage.getItem('appLang') || 'en';
    setLanguage(savedLang);
});