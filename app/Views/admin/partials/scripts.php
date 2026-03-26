<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    .ql-toolbar.ql-snow { background-color: #f8f9fa; border-top-left-radius: 6px; border-top-right-radius: 6px; border-color: #dee2e6; }
    .ql-container.ql-snow { background-color: #ffffff; border-bottom-left-radius: 6px; border-bottom-right-radius: 6px; border-color: #dee2e6; font-family: inherit; font-size: 0.875rem; }
    .ql-editor { min-height: 120px; max-height: 250px; overflow-y: auto; }
    .ql-editor p { margin-bottom: 0.5rem; }
</style>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='/js/translations.js'></script>
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, onAuthStateChanged, signOut, updateProfile, createUserWithEmailAndPassword, updateEmail, updatePassword, reauthenticateWithCredential, EmailAuthProvider } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
    import { getFirestore, doc, getDoc, setDoc, updateDoc, deleteDoc, addDoc, collection, getDocs, onSnapshot, query, where, orderBy, limit } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
    import { getStorage, ref, uploadBytes, getDownloadURL } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";
    import { getFunctions, httpsCallable } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-functions.js";

    const firebaseConfig = window.firebaseConfig;
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    const db = getFirestore(app);
    const storage = getStorage(app);
    const secondaryApp = initializeApp(firebaseConfig, "SecondaryApp");
    const secondaryAuth = getAuth(secondaryApp);
    const cloudFunctions = getFunctions(app);

    let calendar, editModal, editUserModal, reportModal, archiveModal, viewHistoryModal, viewTaskDetailsModal;
    let currentUserRole = '';
    
    // Variabile pentru Editorele de Text
    let quillCreateEditor, quillEditEditor;
    
    window.workersCache = []; 
    window.usersCache = []; 
    window.tasksCache = {}; 
    window.activeTasks = []; 
    window.calendarEvents = { tasks: [], personal: [] };

    window._currentReport = {};

    window.viewReport = async function(taskId, title) {
        window._currentReport = { taskId, title, userName: '', comment: '', photoUrl: '', completedAt: '', avatarUrl: '' };

        if(document.getElementById('rep-task-title')) document.getElementById('rep-task-title').innerText = title;

        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};

        if(document.getElementById('rep-user')) document.getElementById('rep-user').innerText = dict['loading'] || "Loading...";
        if(document.getElementById('rep-comment')) document.getElementById('rep-comment').innerText = dict['loading'] || "Loading...";
        if(document.getElementById('rep-img')) document.getElementById('rep-img').style.display = 'none';
        if(document.getElementById('rep-avatar')) document.getElementById('rep-avatar').src = "https://cdn-icons-png.flaticon.com/512/149/149071.png";

        if(reportModal) reportModal.show();

        try {
            const q = query(collection(db, "task_updates"), where("taskId", "==", taskId));
            const s = await getDocs(q);

            if(!s.empty) {
                let updates = [];
                s.forEach(doc => updates.push(doc.data()));
                updates.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
                const doneUpdate = updates.find(u => u.newStatus === 'done') || updates[0];

                const comment = doneUpdate.comment || (dict['no_comment'] || "No comment.");
                const userName = doneUpdate.userName || (dict['unknown_user'] || "Unknown");
                const completedAt = doneUpdate.createdAt ? new Date(doneUpdate.createdAt).toLocaleString([], {day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit'}) : new Date().toLocaleString();

                if(document.getElementById('rep-comment')) document.getElementById('rep-comment').innerText = comment;
                if(document.getElementById('rep-user')) document.getElementById('rep-user').innerText = userName;

                window._currentReport.userName = userName;
                window._currentReport.comment = comment;
                window._currentReport.completedAt = completedAt;

                if(doneUpdate.photoUrl && document.getElementById('rep-img')) {
                    document.getElementById('rep-img').src = doneUpdate.photoUrl;
                    document.getElementById('rep-img').style.display = 'block';
                    window._currentReport.photoUrl = doneUpdate.photoUrl;
                }

                if(doneUpdate.userId) {
                    const u = window.usersCache.find(x => x.id === doneUpdate.userId);
                    if(u && u.photoUrl && document.getElementById('rep-avatar')) {
                        document.getElementById('rep-avatar').src = u.photoUrl;
                        window._currentReport.avatarUrl = u.photoUrl;
                    }
                    if(u && u.jobTitle) window._currentReport.jobTitle = u.jobTitle;
                }
            } else {
                if(document.getElementById('rep-comment')) document.getElementById('rep-comment').innerText = "Task marked manually.";
                if(document.getElementById('rep-user')) document.getElementById('rep-user').innerText = "-";
                window._currentReport.comment = "Task marked manually.";
                window._currentReport.completedAt = new Date().toLocaleString();
            }
        } catch(e) {
            console.error("Eroare la încărcarea raportului:", e);
            if(document.getElementById('rep-comment')) document.getElementById('rep-comment').innerText = "Error loading data.";
        }
    }

    window.generateReportPDF = async function() {
        const r = window._currentReport;
        if(!r || !r.title) return;

        const { jsPDF } = window.jspdf;
        const doc = new jsPDF({ unit: 'mm', format: 'a4' });
        const pageW = doc.internal.pageSize.getWidth();
        const margin = 18;
        let y = 0;

        // ── Header bar ──────────────────────────────────────────────────
        doc.setFillColor(34, 197, 94); // green-500
        doc.rect(0, 0, pageW, 22, 'F');
        doc.setTextColor(255, 255, 255);
        doc.setFontSize(16);
        doc.setFont('helvetica', 'bold');
        doc.text('CleanTask', margin, 14);
        doc.setFontSize(9);
        doc.setFont('helvetica', 'normal');
        doc.text('Completion Report', margin, 19.5);

        // Date top-right
        doc.setFontSize(8);
        const now = new Date().toLocaleString([], {day:'2-digit',month:'2-digit',year:'numeric',hour:'2-digit',minute:'2-digit'});
        doc.text(now, pageW - margin, 14, { align: 'right' });

        y = 32;

        // ── Task title ───────────────────────────────────────────────────
        doc.setTextColor(15, 23, 42);
        doc.setFontSize(14);
        doc.setFont('helvetica', 'bold');
        const titleLines = doc.splitTextToSize(r.title, pageW - margin * 2);
        doc.text(titleLines, margin, y);
        y += titleLines.length * 7 + 3;

        // Thin separator line
        doc.setDrawColor(226, 232, 240);
        doc.setLineWidth(0.3);
        doc.line(margin, y, pageW - margin, y);
        y += 7;

        // ── Completed by / date row ──────────────────────────────────────
        doc.setFontSize(9);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(100, 116, 139);
        doc.text('Completed by:', margin, y);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(15, 23, 42);
        doc.text(r.userName || '-', margin + 28, y);

        doc.setFont('helvetica', 'bold');
        doc.setTextColor(100, 116, 139);
        doc.text('Date:', pageW / 2, y);
        doc.setFont('helvetica', 'normal');
        doc.setTextColor(15, 23, 42);
        doc.text(r.completedAt || '-', pageW / 2 + 10, y);

        y += 5;
        if(r.jobTitle) {
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(100, 116, 139);
            doc.text('Job:', margin, y);
            doc.setFont('helvetica', 'normal');
            doc.setTextColor(15, 23, 42);
            doc.text(r.jobTitle, margin + 28, y);
            y += 5;
        }

        y += 4;
        doc.setDrawColor(226, 232, 240);
        doc.line(margin, y, pageW - margin, y);
        y += 7;

        // ── Comment section ──────────────────────────────────────────────
        doc.setFontSize(9);
        doc.setFont('helvetica', 'bold');
        doc.setTextColor(100, 116, 139);
        doc.text('Worker Comment:', margin, y);
        y += 5;

        doc.setFillColor(248, 250, 252);
        const commentText = r.comment || 'No comment.';
        const commentLines = doc.splitTextToSize(commentText, pageW - margin * 2 - 8);
        const boxH = commentLines.length * 5 + 8;
        doc.roundedRect(margin, y, pageW - margin * 2, boxH, 2, 2, 'F');
        doc.setTextColor(30, 41, 59);
        doc.setFont('helvetica', 'normal');
        doc.text(commentLines, margin + 4, y + 5);
        y += boxH + 8;

        // ── Photo proof ──────────────────────────────────────────────────
        if(r.photoUrl) {
            doc.setFont('helvetica', 'bold');
            doc.setTextColor(100, 116, 139);
            doc.setFontSize(9);
            doc.text('Photo Proof:', margin, y);
            y += 5;

            try {
                // Load image via canvas to avoid CORS issues (image already in DOM)
                const imgEl = document.getElementById('rep-img');
                let imgData = null;

                if(imgEl && imgEl.complete && imgEl.naturalWidth > 0) {
                    const canvas = document.createElement('canvas');
                    canvas.width = imgEl.naturalWidth;
                    canvas.height = imgEl.naturalHeight;
                    canvas.getContext('2d').drawImage(imgEl, 0, 0);
                    imgData = canvas.toDataURL('image/jpeg', 0.85);
                } else {
                    // fallback: fetch as blob
                    const resp = await fetch(r.photoUrl);
                    const blob = await resp.blob();
                    imgData = await new Promise(res => { const fr = new FileReader(); fr.onload = e => res(e.target.result); fr.readAsDataURL(blob); });
                }

                if(imgData) {
                    const maxW = pageW - margin * 2;
                    const maxH = 90;
                    const props = doc.getImageProperties(imgData);
                    let iW = props.width, iH = props.height;
                    const ratio = Math.min(maxW / iW, maxH / iH);
                    iW = iW * ratio; iH = iH * ratio;

                    // New page if not enough space
                    if(y + iH + 10 > doc.internal.pageSize.getHeight() - 20) {
                        doc.addPage();
                        y = 20;
                    }

                    doc.addImage(imgData, 'JPEG', margin, y, iW, iH);
                    y += iH + 6;
                }
            } catch(imgErr) {
                console.warn('PDF: could not embed photo', imgErr);
                doc.setFont('helvetica', 'italic');
                doc.setTextColor(150, 150, 150);
                doc.text('[Photo could not be embedded — see original URL]', margin, y);
                y += 6;
            }
        }

        // ── Footer ───────────────────────────────────────────────────────
        const pageH = doc.internal.pageSize.getHeight();
        doc.setDrawColor(34, 197, 94);
        doc.setLineWidth(0.5);
        doc.line(margin, pageH - 14, pageW - margin, pageH - 14);
        doc.setFontSize(7);
        doc.setTextColor(148, 163, 184);
        doc.setFont('helvetica', 'normal');
        doc.text('Generated by CleanTask Manager', margin, pageH - 9);
        doc.text(now, pageW - margin, pageH - 9, { align: 'right' });

        // ── Save ─────────────────────────────────────────────────────────
        const safeTitle = (r.title || 'report').replace(/[^a-z0-9]/gi, '_').substring(0, 40);
        doc.save(`CleanTask_Report_${safeTitle}.pdf`);
    }

    window.openHistoryLogs = async function(taskId, title) {
        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};

        const titleEl = document.querySelector('#viewHistoryModal .modal-title');
        if(titleEl) titleEl.innerText = "Logs: " + title;
        
        const body = document.getElementById('history-modal-body');
        if(body) body.innerHTML = `<div class="text-center"><div class="spinner-border spinner-border-sm"></div> ${dict['loading'] || 'Loading...'}</div>`;
        
        if(viewHistoryModal) viewHistoryModal.show();
        
        try {
            const q = query(collection(db, "task_updates"), where("taskId", "==", taskId));
            const snap = await getDocs(q);
            
            if (snap.empty) { 
                if(body) body.innerHTML = `<p class="text-center text-muted">${dict['no_logs'] || 'No logs.'}</p>`; 
                return; 
            }
            
            let updates = [];
            snap.forEach(doc => updates.push(doc.data()));
            updates.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));
            
            let html = '';
            updates.forEach(d => {
                let photoHtml = d.photoUrl ? `<br><img src="${d.photoUrl}" class="img-fluid rounded mt-2 border shadow-sm" style="max-height:150px; cursor:zoom-in;" onclick="window.open('${d.photoUrl}')">` : '';
                html += `<div class="history-item">
                            <div class="fw-bold small">
                                ${d.userName || (dict['system'] || 'System')} 
                                <span class="badge bg-light text-dark border ms-1">${(d.newStatus || 'UPDATE').toUpperCase()}</span>
                            </div>
                            <div class="history-date">${new Date(d.createdAt).toLocaleString()}</div>
                            <div class="mt-1 small bg-light p-2 rounded border-start border-3 border-primary">${d.comment || (dict['no_comment'] || 'No comment.')}</div>
                            ${photoHtml}
                        </div>`;
            });
            if(body) body.innerHTML = html;
        } catch(e) { 
            console.error("Eroare la încărcarea log-urilor:", e);
            if(body) body.innerHTML = '<p class="text-danger">Error loading logs.</p>'; 
        }
    }

    window.viewTaskDetails = function(taskId) {
        const t = window.tasksCache[taskId];
        if(!t) return;

        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};

        if(document.getElementById('view-task-title')) document.getElementById('view-task-title').innerText = t.title || (dict['no_title'] || 'Fără titlu');
        if(document.getElementById('view-task-desc')) document.getElementById('view-task-desc').innerHTML = t.description || '-';
        
        let displayStatus = t.status.toUpperCase();
        let statusBadge = `<span class="badge bg-${t.priority==='high'?'danger':'warning'}">${displayStatus}</span>`;
        if (t.status === 'note') statusBadge = `<span class="badge bg-info text-dark">📝 Note</span>`;
        
        if(document.getElementById('view-task-status')) document.getElementById('view-task-status').innerHTML = statusBadge;
        if(document.getElementById('view-task-priority')) document.getElementById('view-task-priority').innerText = (t.priority || 'low').toUpperCase();
        
        if (t.deadline && document.getElementById('view-task-deadline')) {
            const d = new Date(t.deadline);
            document.getElementById('view-task-deadline').innerText = d.toLocaleDateString() + ' ' + d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });
        } else if(document.getElementById('view-task-deadline')) {
            document.getElementById('view-task-deadline').innerText = '-';
        }

        let assignInfo = (t.assignedType === 'global') ? `🌍 ${dict['cal_global'] || 'Global'}` : `👤 ${(t.assignedNames || []).join(', ')}`;
        if (t.assignedType === 'global' && t.claimedBy) {
            assignInfo = `🔒 ${dict['taken_by'] || 'Taken by'}: ${t.claimedByName || 'Unknown'}`;
        }
        if(document.getElementById('view-task-assigned')) document.getElementById('view-task-assigned').innerText = assignInfo;

        let reqs = '-';
        if(t.requirements && t.requirements.length > 0) {
            reqs = t.requirements.map(r => dict[`req_${r}`] || r).join(', ');
        }
        if(document.getElementById('view-task-reqs')) document.getElementById('view-task-reqs').innerText = reqs;

        const imgContainer = document.getElementById('view-task-images');
        if(imgContainer) {
            imgContainer.innerHTML = '';
            if(t.descriptionImages && t.descriptionImages.length > 0) {
                t.descriptionImages.forEach(img => {
                    imgContainer.innerHTML += `<img src="${img}" class="img-fluid rounded border shadow-sm m-1" style="height: 100px; width: 100px; object-fit: cover; cursor: zoom-in;" onclick="window.open('${img}')">`;
                });
            } else {
                imgContainer.innerHTML = `<span class="text-muted small">${dict['no_images_attached'] || 'Nicio imagine atașată la creare.'}</span>`;
            }
        }

        if(viewTaskDetailsModal) viewTaskDetailsModal.show();
    }

    window.resizeImage = async function(file, maxWidth = 800, maxHeight = 800, quality = 0.8) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width; let height = img.height;
                    if (width > height) { if (width > maxWidth) { height *= maxWidth / width; width = maxWidth; } } 
                    else { if (height > maxHeight) { width *= maxHeight / height; height = maxHeight; } }
                    canvas.width = width; canvas.height = height;
                    const ctx = canvas.getContext('2d'); ctx.drawImage(img, 0, 0, width, height);
                    canvas.toBlob((blob) => { resolve(blob); }, 'image/jpeg', quality);
                };
                img.onerror = reject; img.src = e.target.result;
            };
            reader.onerror = reject; reader.readAsDataURL(file);
        });
    }

    window.closeCalPopup = function() { 
        if(document.getElementById('calendar-popout')) document.getElementById('calendar-popout').style.display = 'none'; 
    }
    window.toggleDescRequired = function() { }

    function populateHourSelects() {
        const opts = [];
        for(let i=0; i<24; i++) {
            const val = i.toString().padStart(2, '0');
            const sel = (i === 12) ? 'selected' : ''; 
            opts.push(`<option value="${val}" ${sel}>${val}:00</option>`);
        }
        if(document.getElementById('task-hour')) document.getElementById('task-hour').innerHTML = opts.join('');
        if(document.getElementById('edit-hour')) document.getElementById('edit-hour').innerHTML = opts.join('');
    }

    function getUserNameById(uid) {
        if(!uid) return null;
        const u = window.usersCache.find(user => user.id === uid);
        return u ? u.name : null;
    }

    onAuthStateChanged(auth, async (user) => {
        if (!user) { 
            if(document.getElementById('auth-error')) document.getElementById('auth-error').classList.remove('d-none'); 
            return; 
        }
        try {
            const userDoc = await getDoc(doc(db, "users", user.uid));
            if (userDoc.exists()) {
                const userData = userDoc.data();
                if (user.email === 'silviu.firulete@gmail.com') userData.role = 'super_admin';
                currentUserRole = userData.role;

                if (currentUserRole === 'admin' || currentUserRole === 'super_admin') {
                    
                    if(document.getElementById('loading-msg')) document.getElementById('loading-msg').classList.add('d-none');
                    if(document.getElementById('admin-content')) document.getElementById('admin-content').classList.remove('d-none');
                    
                    // ==============================================================
                    // PROTECȚIE 100%: Actualizăm DOM-ul doar dacă elementele există
                    // ==============================================================
                    try {
                        if(document.getElementById('admin-name')) document.getElementById('admin-name').innerText = userData.name || "Admin";
                        if(document.getElementById('nav-profile-name')) document.getElementById('nav-profile-name').innerText = userData.name || "Admin";
                        if(document.getElementById('role-badge')) document.getElementById('role-badge').innerText = (currentUserRole==='super_admin')?'| Administrator':'| Objektleiter';
                        if(userData.photoUrl && document.getElementById('nav-profile-img')) document.getElementById('nav-profile-img').src = userData.photoUrl;

                        const userCreateCol = document.getElementById('user-create-col');
                        const userListCol = document.getElementById('user-list-col');
                        if(currentUserRole === 'super_admin') {
                            if(userCreateCol) userCreateCol.classList.remove('d-none');
                            if(userListCol) userListCol.className = 'col-md-8';
                        } else {
                            if(userCreateCol) userCreateCol.classList.add('d-none');
                            if(userListCol) userListCol.className = 'col-12';
                        }

                        // Inițializăm Modalele doar dacă există codul lor HTML
                        if(document.getElementById('editTaskModal')) editModal = new bootstrap.Modal(document.getElementById('editTaskModal'));
                        if(document.getElementById('reportViewModal')) reportModal = new bootstrap.Modal(document.getElementById('reportViewModal'));
                        if(document.getElementById('editUserModal')) editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
                        if(document.getElementById('archiveModal')) archiveModal = new bootstrap.Modal(document.getElementById('archiveModal'));
                        if(document.getElementById('viewHistoryModal')) viewHistoryModal = new bootstrap.Modal(document.getElementById('viewHistoryModal'));
                        if(document.getElementById('viewTaskDetailsModal')) viewTaskDetailsModal = new bootstrap.Modal(document.getElementById('viewTaskDetailsModal'));

                        populateHourSelects();
                        initCalendar();
                        
                        const quillOptions = {
                            theme: 'snow',
                            modules: { toolbar: [ ['bold', 'italic', 'underline', 'strike'], [{ 'list': 'ordered'}, { 'list': 'bullet' }], [{ 'color': [] }, { 'background': [] }], ['clean'] ] },
                            placeholder: 'Schreibe eine Beschreibung...'
                        };
                        
                        if(document.getElementById('task-desc-editor')) quillCreateEditor = new Quill('#task-desc-editor', quillOptions);
                        if(document.getElementById('edit-desc-editor')) quillEditEditor = new Quill('#edit-desc-editor', quillOptions);
                        
                    } catch (domError) {
                        console.warn("Eroare minoră la interfață (ignorată):", domError);
                    }
                    // ==============================================================

                    // Ne asigurăm că abonamentele pornesc FĂRĂ nicio scuză!
                    subscribeToTasksArchive(); 
                    subscribeToUsers(); 
                    subscribeToTasks(); 
                    subscribeToUserEvents(); 
                    checkAutoArchive();
                    loadWorkersIntoCache();
                    
                    if (typeof setLanguage === 'function') {
                        setLanguage(localStorage.getItem('appLang') || 'en');
                    }
                } else { window.location.href = '/dashboard'; }
            }
        } catch(e) { console.error("Auth Error:", e); alert("System Error la autentificare."); }
    });

    async function loadWorkersIntoCache() {
        try {
            const q = query(collection(db, "users"), where("role", "==", "user"));
            const snap = await getDocs(q);
            window.workersCache = [];
            snap.forEach(doc => { window.workersCache.push({ id: doc.id, ...doc.data() }); });
        } catch(e) { console.log(e); }
    }

    function renderCheckboxes(containerId, selectedIds = []) {
        const container = document.getElementById(containerId);
        if(!container) return;
        container.innerHTML = '';
        if (window.workersCache.length === 0) {
            container.innerHTML = '<div class="text-muted small">Loading...</div>';
            return;
        }
        window.workersCache.forEach(w => {
            const isChecked = selectedIds.includes(w.id) ? 'checked' : '';
            container.insertAdjacentHTML('beforeend', `<div class="form-check"><input class="form-check-input worker-check" type="checkbox" value="${w.id}" id="chk_${w.id}_${containerId}" ${isChecked}><label class="form-check-label small" for="chk_${w.id}_${containerId}">${w.name || w.email}</label></div>`);
        });
    }

    window.toggleUserSelect = function(mode) {
        const radioName = (mode === 'create') ? 'assignType' : 'editAssignType';
        const containerId = (mode === 'create') ? 'create-worker-container' : 'edit-worker-container';
        const checkboxContainerId = (mode === 'create') ? 'create-worker-checkboxes' : 'edit-worker-checkboxes';
        
        const radioElement = document.querySelector(`input[name="${radioName}"]:checked`);
        if(!radioElement) return;
        
        const isSpecific = radioElement.value === 'specific';
        const container = document.getElementById(containerId);
        if(!container) return;
        
        if (isSpecific) {
            container.classList.remove('d-none');
            const checkboxContainer = document.getElementById(checkboxContainerId);
            if(checkboxContainer && (mode === 'create' || checkboxContainer.innerHTML === '')) renderCheckboxes(checkboxContainerId);
        } else {
            container.classList.add('d-none');
        }
    }

    function subscribeToTasksArchive() {
        try {
            onSnapshot(collection(db, "tasks_archive"), (snapshot) => {
                const statArchived = document.getElementById('stat-archived');
                if(statArchived) statArchived.innerText = snapshot.size;
            });
        } catch (e) { console.log(e); }
    }

    function subscribeToUsers() {
        try {
            onSnapshot(query(collection(db, "users")), (snapshot) => {
                const tbody = document.getElementById('users-table-body');
                if (tbody) tbody.innerHTML = '';
                window.usersCache = []; 
                let miniUsersHtml = ''; 

                snapshot.forEach(doc => {
                    const u = doc.data();
                    window.usersCache.push({id: doc.id, ...u}); 
                    let btn = (currentUserRole === 'super_admin') ? `<button class="btn btn-sm btn-primary" onclick="openEditUser('${doc.id}')">✏️</button>` : '<span class="text-muted small">View Only</span>';
                    
                    if (tbody) {
                        tbody.innerHTML += `<tr><td>${u.name}</td><td>${u.jobTitle||'-'}</td><td>${u.email}</td><td>${u.role}</td><td>${btn}</td></tr>`;
                    }

                    let roleBadge = (u.role === 'admin' || u.role === 'super_admin') ? '🛡️' : '👷';
                    let photo = u.photoUrl || 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                    miniUsersHtml += `<div class="d-flex align-items-center mb-2 pb-2 border-bottom"><img src="${photo}" class="rounded-circle border" style="width:28px;height:28px;object-fit:cover;margin-right:10px;"><span class="small text-truncate fw-bold text-muted">${roleBadge} ${u.name || u.email}</span></div>`;
                });
                
                const rightSidebarUsers = document.getElementById('right-sidebar-users');
                if(rightSidebarUsers) rightSidebarUsers.innerHTML = miniUsersHtml;

                loadWorkersIntoCache();
            });
        } catch(e) { console.log(e); }
    }

    function updateCalendarSource() {
        if(!calendar) return;
        calendar.removeAllEvents();
        calendar.addEventSource([ ...window.calendarEvents.tasks, ...window.calendarEvents.personal ]);
        calendar.render();
    }

    function subscribeToTasks() {
        try {
            const q = query(collection(db, "tasks"), orderBy("createdAt", "desc"));
            onSnapshot(q, (snapshot) => {
                const doneBody = document.getElementById('done-tasks-body');
                const taskEvents = [];
                const now = new Date();
                window.tasksCache = {}; 
                window.activeTasks = []; 
                
                let doneTasksTemp = []; 

                snapshot.forEach(doc => {
                    const t = doc.data();
                    window.tasksCache[doc.id] = t; 

                    if (t.status !== 'done') {
                        const color = (t.priority === 'high') ? '#dc3545' : '#ffc107';
                        const d = new Date(t.deadline);
                        const timeStr = d.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
                        const calTitle = `${t.title} | ${timeStr}`;

                        taskEvents.push({ 
                            id: doc.id, title: calTitle, start: t.deadline, backgroundColor: color, borderColor: color,
                            extendedProps: { type: 'task', originalTitle: t.title, status: t.status, priority: t.priority, assignedTo: t.assignedNames, assignedType: t.assignedType, claimedBy: t.claimedBy, claimedByName: t.claimedByName || 'Unknown' }
                        });
                    }

                    let realClaimedName = t.claimedByName || 'Unknown';
                    if(t.claimedBy) {
                        const foundName = getUserNameById(t.claimedBy);
                        if(foundName) realClaimedName = foundName;
                    }
                    if ((realClaimedName === 'Unknown' || !realClaimedName) && t.assignedType === 'specific' && t.assignedNames && t.assignedNames.length > 0) {
                        realClaimedName = t.assignedNames.join(', ');
                    }

                    let creatorName = 'Unknown';
                    if (t.createdBy) {
                        const creator = window.usersCache.find(u => u.id === t.createdBy);
                        if (creator) creatorName = creator.name || creator.email;
                    }

                    if (t.status === 'done') {
                        doneTasksTemp.push({ id: doc.id, data: t, realClaimedName: realClaimedName });
                    } else {
                        window.activeTasks.push({ id: doc.id, data: t, creatorName: creatorName, realClaimedName: realClaimedName });
                    }
                });
                
                // Actualizăm Statisticile Live
                const statActive = document.getElementById('stat-active');
                const statCompleted = document.getElementById('stat-completed');
                if (statActive) statActive.innerText = window.activeTasks.length;
                if (statCompleted) statCompleted.innerText = doneTasksTemp.length;

                doneTasksTemp.sort((a, b) => {
                    const dateA = a.data.completedAt ? new Date(a.data.completedAt) : new Date(a.data.deadline || a.data.createdAt);
                    const dateB = b.data.completedAt ? new Date(b.data.completedAt) : new Date(b.data.deadline || b.data.createdAt);
                    return dateB - dateA; 
                });

                if(doneBody) {
                    let doneHtml = '';
                    doneTasksTemp.forEach(taskObj => {
                        const t = taskObj.data; const docId = taskObj.id; const realClaimedName = taskObj.realClaimedName;
                        const doneDateStr = t.completedAt ? new Date(t.completedAt).toLocaleString([], {day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'}) : new Date(t.deadline).toLocaleDateString();
                        const safeTitle = (t.title || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');

                        doneHtml += `<tr class="table-success">
                            <td><strong>${t.title}</strong></td>
                            <td>${doneDateStr}</td>
                            <td class="small text-muted">${realClaimedName}</td>
                            <td class="text-end text-nowrap">
                                <button class="btn btn-sm btn-success" onclick="viewReport('${docId}', '${safeTitle}')" title="Vizualizare Raport">📄</button>
                                <button class="btn btn-sm btn-warning text-dark mx-1" onclick="archiveSingleTask('${docId}')" title="Arhivează manual">🗄️</button>
                                <button class="btn btn-sm btn-outline-secondary" onclick="prepareEditTask('${docId}')" title="Editare">✏️</button>
                            </td>
                        </tr>`;
                    });
                    doneBody.innerHTML = doneHtml;
                }
                
                window.calendarEvents.tasks = taskEvents;
                updateCalendarSource();
                renderActiveTasks();
            });
        } catch(e) { console.log(e); }
    }

    window.renderActiveTasks = function() {
        const activeBody = document.getElementById('active-tasks-body');
        if(!activeBody) return;
        const sortFilter = document.getElementById('task-sort-filter')?.value || 'newest';
        const now = new Date();
        
        let sortedTasks = [...window.activeTasks];
        if (sortFilter === 'newest') sortedTasks.sort((a, b) => new Date(b.data.createdAt) - new Date(a.data.createdAt));
        else if (sortFilter === 'oldest') sortedTasks.sort((a, b) => new Date(a.data.createdAt) - new Date(b.data.createdAt));
        else if (sortFilter === 'name') sortedTasks.sort((a, b) => a.data.title.localeCompare(b.data.title));
        
        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
        const wordDeadline = dict['deadline'] || 'Deadline';
        const wordBy = dict['by'] || 'By';

        let html = '';
        sortedTasks.forEach(task => {
            const t = task.data; const docId = task.id; const deadlineDateObj = new Date(t.deadline); const isLate = deadlineDateObj < now;
            
            let warning = isLate ? '<span class="text-overdue">⚠️ LATE</span> ' : '';
            let rowClass = isLate ? 'row-overdue' : '';
            let assignInfo = (t.assignedType === 'global') ? (t.claimedBy ? `🔒 ${dict['cal_taken'] || 'Taken'}: ${task.realClaimedName}` : `🌍 ${dict['cal_global'] || 'Global'}`) : `👤 ${(t.assignedNames || []).join(', ')}`;
            
            let reqBadge = '';
            if(t.requirements && t.requirements.length > 0) {
                const reqList = t.requirements.map(r => dict[`req_${r}`] || r).join(', ');
                reqBadge = `<br><small class="text-info">🔹 ${reqList}</small>`;
            }

            let statusBadge = `<span class="badge bg-${t.priority==='high'?'danger':'warning'}">${t.status.toUpperCase()}</span>`;
            if (t.status === 'note') statusBadge = `<span class="badge bg-info text-dark">📝 Note</span>`;
            
            const createdDate = new Date(t.createdAt);
            const formattedDate = createdDate.toLocaleDateString() + ' ' + createdDate.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });

            const formattedDeadline = deadlineDateObj.toLocaleDateString() + ' ' + deadlineDateObj.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit' });

            const deadlineStyle = isLate ? 'text-danger fw-bold' : 'text-dark fw-bold';
            const safeTitle = (t.title || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
            
            const plainTextDesc = t.description ? t.description.replace(/<[^>]+>/g, '').trim() : '';

            html += `<tr class="${rowClass}">
                <td><div>${warning}<strong>${t.title}</strong>${reqBadge}<br><small class="text-muted">${plainTextDesc.substring(0,35)}...</small></div></td>
                <td><small>${t.requirements ? t.requirements.map(r => dict[`req_${r}`] || r).join(', ') : '-'}</small></td>
                <td class="small">${assignInfo}</td>
                <td class="small">
                    <span class="${deadlineStyle}">⏰ ${wordDeadline}: ${formattedDeadline}</span><br>
                    <span class="text-muted" style="font-size:0.7rem;">👤 ${wordBy}: ${task.creatorName} (${formattedDate})</span>
                </td>
                <td>${statusBadge}</td>
                <td class="text-end text-nowrap">
                    <button class="btn btn-sm btn-primary text-white" onclick="viewTaskDetails('${docId}')" title="Vizualizare">👁️</button>
                    <button class="btn btn-sm btn-info text-white mx-1" onclick="openHistoryLogs('${docId}', '${safeTitle}')" title="Logs">📜</button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="prepareEditTask('${docId}')" title="Editare">✏️</button>
                </td>
            </tr>`;
        });
        activeBody.innerHTML = html;
    }

    window.applySortFilter = function() { renderActiveTasks(); }

    function subscribeToUserEvents() {
        try {
            onSnapshot(collection(db, "user_events"), (snapshot) => {
                const personalEvents = [];
                snapshot.forEach(doc => {
                    const d = doc.data();
                    let color = '#17a2b8'; 
                    if(d.type === 'vacation') color = '#6f42c1'; 
                    if(d.type === 'appointment') color = '#fd7e14';
                    
                    personalEvents.push({ 
                        title: `${d.userName || 'User'}: ${d.title}`, start: d.start, end: d.end,
                        backgroundColor: color, borderColor: color, 
                        extendedProps: { type: 'personal', desc: d.title, user: d.userName, startDate: d.start, endDate: d.end } 
                    });
                });
                window.calendarEvents.personal = personalEvents;
                updateCalendarSource();
            });
        } catch(e) { console.log(e); }
    }

    const formCreateTask = document.getElementById('create-task-form');
    if(formCreateTask) {
        formCreateTask.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn=document.getElementById('btn-save-task'); 
            if(!btn) return;
            
            let desc = quillCreateEditor ? quillCreateEditor.root.innerHTML : '';
            if(desc === '<p><br></p>') desc = ''; 
            const plainDesc = quillCreateEditor ? quillCreateEditor.getText().trim() : '';

            const isOther = document.getElementById('req-sonstige') && document.getElementById('req-sonstige').checked;
            if(isOther && plainDesc.length === 0) {
                alert("Vă rugăm să introduceți detalii în descriere pentru opțiunea 'Sonstige'.");
                return;
            }

            btn.disabled=true; btn.innerText="Saving...";
            const title=document.getElementById('task-title').value;
            const priority=document.getElementById('task-priority').value;
            const radioAssign = document.querySelector('input[name="assignType"]:checked');
            const assignType= radioAssign ? radioAssign.value : 'global';
            const dateVal = document.getElementById('task-date').value;
            const hourVal = document.getElementById('task-hour').value;
            const deadline = new Date(dateVal + 'T' + hourVal + ':00:00').toISOString();

            const requirements = [];
            document.querySelectorAll('.req-check:checked').forEach(cb => requirements.push(cb.value));

            let assignedTo=[], assignedNames=[];
            if(assignType==='specific'){
                document.querySelectorAll('#create-worker-checkboxes .worker-check:checked').forEach(c=>{ assignedTo.push(c.value); assignedNames.push(c.nextElementSibling.innerText); });
                if(assignedTo.length===0){ alert("Select worker!"); btn.disabled=false; btn.innerText="SAVE TASK"; return;}
            } else { assignedNames.push("Global"); }

            try {
                const taskImagesEl = document.getElementById('task-images');
                const imgs= taskImagesEl ? taskImagesEl.files : [];
                let urls=[];
                if(imgs.length>0) {
                    if(document.getElementById('upload-progress')) document.getElementById('upload-progress').classList.remove('d-none');
                    for(let i=0; i<Math.min(imgs.length,3); i++) {
                        const blob=await window.resizeImage(imgs[i]);
                        const refS=ref(storage, `tasks/${Date.now()}_${i}.jpg`);
                        await uploadBytes(refS,blob);
                        urls.push(await getDownloadURL(refS));
                    }
                }
                await addDoc(collection(db,"tasks"),{ title, description:desc, priority, deadline, requirements, assignedType: assignType, assignedTo, assignedNames, status:'new', createdBy:auth.currentUser.uid, createdAt:new Date().toISOString(), descriptionImages:urls });
                alert("Task created successfully!"); 
                
                document.getElementById('create-task-form').reset();
                if(quillCreateEditor) quillCreateEditor.setText('');
                
                const rGlobal = document.querySelector('input[name="assignType"][value="global"]');
                if(rGlobal) rGlobal.checked = true;
                if(document.getElementById('task-hour')) document.getElementById('task-hour').value = "12"; 
                window.toggleUserSelect('create');
                document.querySelectorAll('.req-check').forEach(c => c.checked = false);
            } catch(e){
                console.error("Error creating task:", e);
                alert("Error: " + e.message);
            } finally{
                btn.disabled=false;
                btn.innerText="SAVE TASK";
                if(document.getElementById('upload-progress')) document.getElementById('upload-progress').classList.add('d-none');
            }
        });
    }

    window.prepareEditTask = function(id) {
        window.closeCalPopup();
        const t = window.tasksCache[id];
        if(!t) return alert("Task error");
        if(document.getElementById('edit-task-id')) document.getElementById('edit-task-id').value = id;
        if(document.getElementById('edit-title')) document.getElementById('edit-title').value = t.title;
        
        if(quillEditEditor) quillEditEditor.root.innerHTML = t.description || '';
        
        if(document.getElementById('edit-status')) document.getElementById('edit-status').value = t.status;
        if(document.getElementById('edit-priority')) document.getElementById('edit-priority').value = t.priority;
        if(t.deadline && document.getElementById('edit-date')) {
            const d = new Date(t.deadline);
            document.getElementById('edit-date').value = d.toISOString().split('T')[0];
            if(document.getElementById('edit-hour')) document.getElementById('edit-hour').value = String(d.getHours()).padStart(2,'0');
        }
        if (t.assignedType === 'global') {
            if(document.getElementById('editAssignGlobal')) document.getElementById('editAssignGlobal').checked = true;
            if(document.getElementById('edit-worker-container')) document.getElementById('edit-worker-container').classList.add('d-none');
        } else {
            if(document.getElementById('editAssignSpecific')) document.getElementById('editAssignSpecific').checked = true;
            if(document.getElementById('edit-worker-container')) document.getElementById('edit-worker-container').classList.remove('d-none');
        }
        renderCheckboxes('edit-worker-checkboxes', t.assignedTo || []);
        if(editModal) editModal.show();
    }

    window.saveTaskEdit = async function(){
        const elId = document.getElementById('edit-task-id');
        if(!elId) return;
        const id = elId.value;
        const assignRadio = document.querySelector('input[name="editAssignType"]:checked');
        const assignType = assignRadio ? assignRadio.value : 'global';
        const dateVal = document.getElementById('edit-date') ? document.getElementById('edit-date').value : '';
        const hourVal = document.getElementById('edit-hour') ? document.getElementById('edit-hour').value : '12';
        const deadline = new Date(dateVal + 'T' + hourVal + ':00:00').toISOString();
        
        let desc = quillEditEditor ? quillEditEditor.root.innerHTML : '';
        if(desc === '<p><br></p>') desc = '';

        let assignedTo = [], assignedNames = [];
        if (assignType === 'specific') {
            document.querySelectorAll('#edit-worker-checkboxes .worker-check:checked').forEach(c => { assignedTo.push(c.value); assignedNames.push(c.nextElementSibling.innerText); });
        } else { assignedNames.push("Global"); }
        try{ 
            await updateDoc(doc(db,"tasks",id),{ 
                title: document.getElementById('edit-title') ? document.getElementById('edit-title').value : '', 
                description:desc,
                status: document.getElementById('edit-status') ? document.getElementById('edit-status').value : 'new', 
                priority: document.getElementById('edit-priority') ? document.getElementById('edit-priority').value : 'low', 
                deadline, assignedType: assignType, assignedTo, assignedNames 
            }); 
            if(editModal) editModal.hide(); 
            alert("Task updated!");
        }catch(e){ alert(e.message); }
    }

    window.deleteTaskFromEdit = async function() { 
        if(confirm("Delete permanently?")) { 
            await deleteDoc(doc(db,"tasks",document.getElementById('edit-task-id').value)); 
            if(editModal) editModal.hide(); 
            alert("Task deleted!");
        } 
    }

    async function checkAutoArchive() { 
        const old = new Date(); old.setDate(old.getDate()-30); 
        try { 
            const s = await getDocs(query(collection(db,"tasks"),where("status","==","done"))); 
            s.forEach(async d=>{ 
                if(new Date(d.data().deadline) < old) { 
                    await setDoc(doc(db,"tasks_archive",d.id),d.data()); 
                    await deleteDoc(doc(db,"tasks",d.id)); 
                } 
            }); 
        } catch(e){} 
    }

    window.openArchiveModal = async function() { 
        if(archiveModal) archiveModal.show(); 
        const b = document.getElementById('archive-table-body'); 
        if(b) b.innerHTML = '<tr><td>Loading...</td></tr>'; 
        const s = await getDocs(query(collection(db, "tasks_archive"), orderBy("deadline", "desc"), limit(20))); 
        if(b) b.innerHTML = ''; 
        s.forEach(d => { 
            const t = d.data(); 
            if(b) b.innerHTML += `<tr><td>${t.title}</td><td>${t.deadline}</td><td>${t.claimedByName||'-'}</td><td><button class="btn btn-sm btn-danger" onclick="delArch('${d.id}')">X</button></td></tr>`; 
        }); 
    }

    window.delArch = async(id) => { 
        if(confirm("Delete from archive?")) { await deleteDoc(doc(db,"tasks_archive",id)); window.openArchiveModal(); } 
    }
    
    window.archiveSingleTask = async function(id) {
        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
        const confirmMsg = dict['confirm_archive'] || "Are you sure you want to move this task to the Archive?";

        if(confirm(confirmMsg)) {
            try {
                const t = window.tasksCache[id];
                if(!t) return;
                await setDoc(doc(db, "tasks_archive", id), t);
                await deleteDoc(doc(db, "tasks", id));
            } catch(e) {
                alert("Error: " + e.message);
            }
        }
    }

    window.openEditUser = function(id) { 
        const u = window.usersCache.find(x => x.id === id); 
        if(!u) return; 
        if(document.getElementById('edit-user-id')) document.getElementById('edit-user-id').value = id; 
        if(document.getElementById('edit-user-name')) document.getElementById('edit-user-name').value = u.name || ''; 
        if(document.getElementById('edit-user-email')) document.getElementById('edit-user-email').value = u.email || ''; 
        if(document.getElementById('edit-user-password')) document.getElementById('edit-user-password').value = ''; 
        if(document.getElementById('edit-user-job')) document.getElementById('edit-user-job').value = u.jobTitle || 'Sonderreiniger'; 
        if(document.getElementById('edit-user-role')) document.getElementById('edit-user-role').value = u.role || 'user'; 
        if(editUserModal) editUserModal.show();
    }

    window.saveUserEdit = async function(){ 
        const elId = document.getElementById('edit-user-id');
        if(!elId) return;
        const id = elId.value; 
        const newEmail = document.getElementById('edit-user-email').value;
        const newPass = document.getElementById('edit-user-password').value;
        const btn = document.getElementById('btn-save-user-edit');
        
        if(btn) { btn.disabled = true; btn.innerText = "Saving..."; }
        
        try { 
            await updateDoc(doc(db, "users", id), { 
                name: document.getElementById('edit-user-name').value, 
                email: newEmail,
                jobTitle: document.getElementById('edit-user-job').value, 
                role: document.getElementById('edit-user-role').value 
            }); 
            
            if (newPass.trim() !== '') {
                if (newPass.length < 6) {
                    alert("Parola trebuie să aibă minim 6 caractere!");
                    if(btn){ btn.disabled = false; btn.innerText = "Save"; } return;
                }
                const updateCredentialsFn = httpsCallable(cloudFunctions, 'updateUserCredentials');
                await updateCredentialsFn({ uid: id, newPassword: newPass });
                alert("✅ Profil actualizat și parolă schimbată cu succes via Cloud Functions!");
            } else {
                alert("✅ Profil actualizat cu succes!");
            }
            
            if(editUserModal) editUserModal.hide(); 
        } catch(e) { 
            console.error(e);
            alert("❌ Eroare: " + (e.message || "A apărut o eroare necunoscută.")); 
        } finally {
            if(btn){ btn.disabled = false; btn.innerText = "Save"; }
        }
    }
    
    window.deleteUserAccount = async function() {
        const id = document.getElementById('edit-user-id').value;
        if(confirm("⚠️ Ești sigur că vrei să ștergi acest utilizator complet?\nSe va șterge automat și din sistemul de logare.")) {
            try {
                await deleteDoc(doc(db, "users", id));
                if(editUserModal) editUserModal.hide();
                alert("✅ Utilizator șters cu succes!");
            } catch (e) { alert("❌ Eroare la ștergere: " + e.message); }
        }
    }

    const formCreateUser = document.getElementById('create-user-form');
    if(formCreateUser) {
        formCreateUser.addEventListener('submit', async(e)=>{ 
            e.preventDefault(); 
            const btn=document.getElementById('btn-create-user'); if(btn) btn.disabled=true; 
            const name=document.getElementById('new-name').value; 
            const email=document.getElementById('new-email').value; 
            const pass=document.getElementById('new-password').value; 
            const role=document.getElementById('new-role').value; 
            const job=document.getElementById('new-jobTitle').value; 
            try { 
                const cred = await createUserWithEmailAndPassword(secondaryAuth, email, pass); 
                await setDoc(doc(db,"users",cred.user.uid), { uid:cred.user.uid, name:name, email:email, role:role, jobTitle:job, language:'en', createdAt:new Date().toISOString() }); 
                alert("User created successfully!"); 
                formCreateUser.reset(); 
                await signOut(secondaryAuth); 
            } catch(e){ alert(e.message); } finally{ if(btn) btn.disabled=false; } 
        });
    }

    let currentChatChannel = 'team';
    let chatUnsubscribe = null;
    let allSystemUsers = []; 

    function highlightMentions(text, isMe) {
        if (!text) return "";
        return text.replace(/@([a-zA-Z0-9_.-]+(\s[a-zA-Z0-9_.-]+)?)/g, function(match) {
             return isMe ? `<span class="text-warning fw-bold bg-white bg-opacity-25 px-1 rounded">${match}</span>` : `<span class="text-primary fw-bold bg-primary bg-opacity-10 px-1 rounded">${match}</span>`;
        });
    }

    window.loadChatMessages = function() {
        if (!auth.currentUser) return;
        const channelSelect = document.getElementById('chat-channel-select');
        currentChatChannel = channelSelect ? channelSelect.value : 'team';
        
        if (chatUnsubscribe) chatUnsubscribe(); 
        
        if(allSystemUsers.length === 0) {
            getDocs(collection(db, "users")).then(snap => {
                snap.forEach(doc => { const u = doc.data(); if(u.name) allSystemUsers.push({ id: doc.id, name: u.name }); });
            }).catch(e => console.log("Failed to load users for mentions"));
        }
        
        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
        const loadingText = dict['loading'] || 'Loading...';
        const noMessagesText = dict['chat_no_messages'] || 'No messages yet. Be the first to write!';

        const container = document.getElementById('chat-messages');
        if(container) container.innerHTML = `<div class="text-center text-muted small mt-3"><span class="spinner-border spinner-border-sm"></span> ${loadingText}</div>`;

        const q = query(collection(db, "chats", currentChatChannel, "messages"), orderBy("timestamp", "asc"));
        
        chatUnsubscribe = onSnapshot(q, (snap) => {
            let currentChatHtml = '';
            
            if (snap.empty) {
                if(container) container.innerHTML = `<div class="text-center text-muted small mt-4">${noMessagesText}</div>`;
                return;
            }

            snap.forEach(doc => {
                const m = doc.data();
                const isMe = m.senderId === auth.currentUser.uid;
                const timeStr = m.timestamp ? new Date(m.timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : '';
                const photoUrl = m.senderPhoto || 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
                let safeText = m.text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
                let formattedText = highlightMentions(safeText, isMe);

                if (isMe) {
                    currentChatHtml += `<div class="align-self-end d-flex flex-column mb-1" style="max-width: 85%;"><div class="p-2 shadow-sm bg-primary text-white rounded-3 rounded-bottom-0" style="word-wrap: break-word;">${formattedText}</div><div class="text-muted text-end mt-1" style="font-size: 0.65rem;">${timeStr}</div></div>`;
                } else {
                    currentChatHtml += `<div class="align-self-start d-flex mb-1" style="max-width: 85%; gap: 8px;"><img src="${photoUrl}" class="rounded-circle mt-1 shadow-sm" style="width: 28px; height: 28px; object-fit: cover; flex-shrink: 0;"><div class="d-flex flex-column"><div class="small text-muted mb-1" style="font-size: 0.7rem; font-weight: bold; margin-left: 2px;">${m.senderName}</div><div class="p-2 shadow-sm bg-white border text-dark rounded-3 rounded-top-0" style="word-wrap: break-word;">${formattedText}</div><div class="text-muted text-start mt-1" style="font-size: 0.65rem;">${timeStr}</div></div></div>`;
                }
            });
            if(container) { container.innerHTML = currentChatHtml; container.scrollTop = container.scrollHeight; }
        });
    }

    const chatInput = document.getElementById('chat-input');
    const mentionsDropdown = document.getElementById('mentions-dropdown');
    let currentMentionSearch = '';

    if (chatInput && mentionsDropdown) {
        chatInput.addEventListener('input', function(e) {
            const text = e.target.value;
            const cursorPos = e.target.selectionStart;
            const textBeforeCursor = text.substring(0, cursorPos);
            const lastAtSignIndex = textBeforeCursor.lastIndexOf('@');

            if (lastAtSignIndex !== -1) {
                const queryStr = textBeforeCursor.substring(lastAtSignIndex + 1);
                if (!queryStr.includes('  ')) { 
                    currentMentionSearch = queryStr.toLowerCase();
                    const filteredUsers = allSystemUsers.filter(u => u.name.toLowerCase().includes(currentMentionSearch));
                    if (filteredUsers.length > 0) {
                        renderMentionsDropdown(filteredUsers);
                        mentionsDropdown.classList.remove('d-none');
                        return; 
                    }
                }
            }
            hideMentionsDropdown();
        });
        chatInput.addEventListener('blur', () => { setTimeout(hideMentionsDropdown, 200); });
    }

    function renderMentionsDropdown(users) {
        if(!mentionsDropdown) return;
        mentionsDropdown.innerHTML = '';
        users.slice(0, 5).forEach((user, index) => {
            const item = document.createElement('button');
            item.type = 'button';
            item.className = 'list-group-item list-group-item-action py-2 px-3 small fw-bold text-primary border-bottom-0';
            if (index === 0) item.style.borderTopLeftRadius = '0.5rem';
            item.innerHTML = `@${user.name}`;
            item.onclick = function() { insertMention(user.name); };
            mentionsDropdown.appendChild(item);
        });
    }

    function insertMention(userName) {
        if(!chatInput) return;
        const text = chatInput.value;
        const cursorPos = chatInput.selectionStart;
        const textBeforeCursor = text.substring(0, cursorPos);
        const textAfterCursor = text.substring(cursorPos);
        const lastAtSignIndex = textBeforeCursor.lastIndexOf('@');
        const newTextBeforeCursor = textBeforeCursor.substring(0, lastAtSignIndex) + `@${userName} `;
        chatInput.value = newTextBeforeCursor + textAfterCursor;
        hideMentionsDropdown();
        chatInput.focus();
        chatInput.selectionStart = chatInput.selectionEnd = newTextBeforeCursor.length;
    }

    function hideMentionsDropdown() {
        if(mentionsDropdown) { mentionsDropdown.classList.add('d-none'); mentionsDropdown.innerHTML = ''; currentMentionSearch = ''; }
    }

    const formChat = document.getElementById('chat-form');
    if(formChat) {
        formChat.addEventListener('submit', async (e) => {
            e.preventDefault();
            const input = document.getElementById('chat-input');
            if(!input) return;
            const text = input.value.trim();
            if (!text || !auth.currentUser) return;
            
            input.value = ''; 
            hideMentionsDropdown();

            // Preluăm corect numele, indiferent unde s-ar afla în meniul vechi sau nou
            const elNavProfile = document.getElementById('nav-profile-name');
            const elAdminName = document.getElementById('admin-name');
            let senderName = 'User';
            if(elNavProfile && elNavProfile.innerText) senderName = elNavProfile.innerText;
            else if(elAdminName && elAdminName.innerText) senderName = elAdminName.innerText;
            
            const elImg = document.getElementById('nav-profile-img');
            const profileImgSrc = (elImg && elImg.src) ? elImg.src : 'https://cdn-icons-png.flaticon.com/512/149/149071.png';

            try {
                await addDoc(collection(db, "chats", currentChatChannel, "messages"), {
                    text: text, senderId: auth.currentUser.uid, senderName: senderName, senderPhoto: profileImgSrc, timestamp: new Date().toISOString()
                });
            } catch(e) {
                console.error("Eroare la trimiterea mesajului:", e);
                const lang = localStorage.getItem('appLang') || 'en';
                const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
                alert(dict['chat_send_error'] || 'Could not send message.');
            }
        });
    }

    window.showSection = function(id) { 
        ['users', 'create', 'active', 'completed', 'calendar', 'profile', 'chat'].forEach(s => {
            const sec = document.getElementById('section-' + s);
            const btn = document.getElementById('btn-section-' + s);
            if (sec) sec.classList.add('d-none');
            if (btn) btn.classList.remove('active');
        });
        
        const targetSec = document.getElementById('section-' + id);
        const targetBtn = document.getElementById('btn-section-' + id);
        if (targetSec) targetSec.classList.remove('d-none');
        if (targetBtn) targetBtn.classList.add('active');
        
        if(id === 'chat') { window.loadChatMessages(); }
        if (id === 'profile') { window.loadProfileData(); }
        if (id === 'calendar' && calendar) { setTimeout(() => calendar.updateSize(), 200); }
    }

    window.toggleNavbarTheme = async function() {
        const isDark = document.body.classList.contains('theme-dark');
        const newTheme = isDark ? 'light' : 'dark';
        
        const iconSpan = document.getElementById('nav-theme-icon');
        if (iconSpan) {
            if (newTheme === 'dark') {
                iconSpan.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/></svg>`;
            } else {
                iconSpan.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16"><path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z"/></svg>`;
            }
        }
        await window.applyTheme(newTheme, true);
    }

    function initCalendar() {
        const calendarEl = document.getElementById('calendar');
        if(!calendarEl) return;
        const currentLang = localStorage.getItem('appLang') || 'en';
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', height: 500, locale: currentLang, headerToolbar: {left:'title', right:'prev,next'}, events: [],
            eventClick: function(info) {
                const props = info.event.extendedProps;
                let detailHtml = "";
                const lang = localStorage.getItem('appLang') || 'en';
                const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
                
                if (props.type === 'personal') {
                    if(document.getElementById('pop-title')) document.getElementById('pop-title').innerText = "👤 " + props.user;
                    const startD = new Date(props.startDate).toLocaleDateString() + " " + new Date(props.startDate).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
                    const endD = props.endDate ? new Date(props.endDate).toLocaleDateString() + " " + new Date(props.endDate).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'}) : '...';
                    
                    if(document.getElementById('pop-time')) document.getElementById('pop-time').innerText = `⏳ ${dict['cal_from'] || 'From'}: ${startD}\n⌛ ${dict['cal_to'] || 'To'}: ${endD}`;
                    detailHtml = `<div class="pop-info-row"><strong>${dict['cal_event'] || 'Event'}:</strong> ${info.event.title}<br><strong>${dict['cal_desc'] || 'Desc'}:</strong> ${props.desc || '-'}</div>`;
                    if(document.getElementById('pop-action-btn')) document.getElementById('pop-action-btn').style.display = 'none'; 
                } 
                else if (props.type === 'task') {
                    if(document.getElementById('pop-title')) document.getElementById('pop-title').innerText = "📋 " + props.originalTitle;
                    const dead = new Date(info.event.start).toLocaleDateString() + " " + new Date(info.event.start).toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});
                    if(document.getElementById('pop-time')) document.getElementById('pop-time').innerText = `⏰ ${dict['cal_deadline'] || 'Deadline'}: ${dead}`;
                    
                    let workerInfo = "";
                    if(props.assignedType === 'specific') workerInfo = `👷‍♂️ <strong>${dict['cal_assigned'] || 'Assigned'}:</strong> ${props.assignedTo.join(', ')}`;
                    else if(props.assignedType === 'global') {
                        if(props.claimedBy) workerInfo = `🔒 <strong>${dict['cal_taken'] || 'Taken'}:</strong> ${props.claimedByName}`;
                        else workerInfo = `🌍 <strong>${dict['cal_global'] || 'Global'}</strong>`;
                    }
                    detailHtml = `<div class="pop-info-row">${workerInfo}<br><strong>${dict['cal_status'] || 'Status'}:</strong> ${props.status.toUpperCase()}</div>`;
                    const popBtn = document.getElementById('pop-action-btn');
                    if(popBtn) {
                        popBtn.style.display = 'block';
                        popBtn.onclick = function() { window.prepareEditTask(info.event.id); };
                    }
                } 
                if(document.getElementById('pop-assign')) document.getElementById('pop-assign').innerHTML = detailHtml;
                if(document.getElementById('calendar-popout')) document.getElementById('calendar-popout').style.display = 'block';
            }
        });
        calendar.render();
    }

    window.addEventListener('languageChanged', (e) => { if(calendar) { calendar.setOption('locale', e.detail.lang); } });
    
    window.viewProfileImagePopout = function() {
        const elPreview = document.getElementById('profile-img-preview');
        const elPopout = document.getElementById('profile-img-popout');
        if(elPreview && elPopout) {
            elPopout.src = elPreview.src;
            const modalEl = document.getElementById('profileImageModal');
            if(modalEl) new bootstrap.Modal(modalEl).show();
        }
    }

    window.loadProfileData=async function(){
        const u=auth.currentUser; if (!u) return;
        try {
            const d=await getDoc(doc(db,"users",u.uid)); 
            if(d.exists()){
                const da=d.data(); 
                if(document.getElementById('profile-name')) document.getElementById('profile-name').value=da.name || ''; 
                if(document.getElementById('profile-phone')) document.getElementById('profile-phone').value=da.phoneNumber || '';
                if(document.getElementById('profile-name-display')) document.getElementById('profile-name-display').innerText = da.name || 'Admin';
                if(document.getElementById('profile-role-display')) document.getElementById('profile-role-display').innerText = da.role === 'super_admin' ? 'Administrator' : 'Objektleiter';
                if(document.getElementById('profile-email-display')) document.getElementById('profile-email-display').innerText = u.email;
                if (da.photoUrl && document.getElementById('profile-img-preview')) document.getElementById('profile-img-preview').src = da.photoUrl;
                if(document.getElementById('current-email-display')) document.getElementById('current-email-display').value = u.email;
                const savedTheme = da.theme || 'light';
                window.applyTheme(savedTheme, false); 
            }
        } catch (e) { console.error("Error loading profile:", e); }
    }

    window.saveProfileData=async function(){
        const u=auth.currentUser; if (!u) return;
        try{
            const elName = document.getElementById('profile-name');
            const elPhone = document.getElementById('profile-phone');
            const name = elName ? elName.value : '';
            const phone = elPhone ? elPhone.value : '';
            
            await updateDoc(doc(db,"users",u.uid),{ name: name, phoneNumber: phone }); 
            await updateProfile(u,{displayName: name}); 
            
            if(document.getElementById('profile-name-display')) document.getElementById('profile-name-display').innerText = name;
            if(document.getElementById('nav-profile-name')) document.getElementById('nav-profile-name').innerText = name;
            if(document.getElementById('admin-name')) document.getElementById('admin-name').innerText = name;
            alert("✅ Profile updated successfully!"); 
        }catch(e){ alert("❌ Error: " + e.message); }
    }

    window.applyTheme = async function(theme, saveToDb = true) {
        const body = document.body;
        body.classList.remove('theme-dark', 'theme-blue', 'theme-green', 'theme-red', 'theme-purple');
        if (theme !== 'light') body.classList.add('theme-' + theme);
        document.querySelectorAll('.theme-btn').forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('data-theme') === theme) btn.classList.add('active');
        });
        const themeNames = { light: 'Light', dark: 'Dark', blue: 'Ocean Blue', green: 'Forest Green', red: 'Vibrant Red', purple: 'Royal Purple' };
        if(document.getElementById('current-theme-name')) document.getElementById('current-theme-name').innerText = themeNames[theme] || theme;
        if (saveToDb && auth.currentUser) { try { await updateDoc(doc(db, "users", auth.currentUser.uid), { theme: theme }); } catch (e) {} }
    }

    window.uploadAvatar=async function(){
        const fileInput = document.getElementById('profile-upload');
        if(!fileInput || !fileInput.files[0]) return;
        const f = fileInput.files[0];
        try{
            const b=await window.resizeImage(f);
            const r=ref(storage,`avatars/${auth.currentUser.uid}.jpg`);
            await uploadBytes(r,b);
            const u=await getDownloadURL(r);
            await updateDoc(doc(db,"users",auth.currentUser.uid),{photoUrl:u});
            if(document.getElementById('nav-profile-img')) document.getElementById('nav-profile-img').src=u;
            if(document.getElementById('profile-img-preview')) document.getElementById('profile-img-preview').src=u;
            alert("Avatar uploaded!");
        }catch(e){ alert(e.message); }
    }

    const formChangeEmail = document.getElementById('change-email-form');
    if(formChangeEmail) {
        formChangeEmail.addEventListener('submit', async (e) => {
            e.preventDefault();
            const newEmailVal = document.getElementById('new-email').value;
            const password = document.getElementById('email-change-password').value;
            try {
                const credential = EmailAuthProvider.credential(auth.currentUser.email, password);
                await reauthenticateWithCredential(auth.currentUser, credential);
                await updateEmail(auth.currentUser, newEmailVal);
                await updateDoc(doc(db, "users", auth.currentUser.uid), { email: newEmailVal });
                alert("✅ Email updated successfully!");
                formChangeEmail.reset();
                window.loadProfileData();
            } catch(e) {
                if (e.code === 'auth/wrong-password') alert("❌ Incorrect password!");
                else alert("❌ Error: " + e.message);
            }
        });
    }

    const formChangePassword = document.getElementById('change-password-form');
    if(formChangePassword) {
        formChangePassword.addEventListener('submit', async (e) => {
            e.preventDefault();
            const currentPwd = document.getElementById('current-password').value;
            const newPwd = document.getElementById('new-password').value;
            const confirmPwd = document.getElementById('confirm-new-password').value;
            if (newPwd !== confirmPwd) { alert("❌ Passwords don't match!"); return; }
            if (newPwd.length < 6) { alert("❌ Password must be at least 6 characters!"); return; }
            try {
                const credential = EmailAuthProvider.credential(auth.currentUser.email, currentPwd);
                await reauthenticateWithCredential(auth.currentUser, credential);
                await updatePassword(auth.currentUser, newPwd);
                alert("✅ Password updated successfully!");
                formChangePassword.reset();
            } catch(e) {
                if (e.code === 'auth/wrong-password') alert("❌ Current password is incorrect!");
                else alert("❌ Error: " + e.message);
            }
        });
    }

    const btnLogout = document.getElementById('btn-logout');
    if(btnLogout) {
        btnLogout.addEventListener('click', () => { signOut(auth).then(() => window.location.href = '/login'); });
    }
    
    window.viewImages = function(arr){ 
        const c=document.getElementById('images-container'); 
        if(!c) return;
        c.innerHTML=''; 
        arr.forEach(u=>{ c.innerHTML+=`<img src="${u}" class="img-fluid mb-2 border rounded">` }); 
        const vModal = document.getElementById('viewImagesModal');
        if(vModal) new bootstrap.Modal(vModal).show(); 
    }
</script>

<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/firebase-messaging-sw.js')
      .then(function(registration) {
        console.log('ServiceWorker PWA activat cu scope: ', registration.scope);
      }).catch(function(err) {
        console.error('ServiceWorker a eșuat: ', err);
      });
  });
}
</script>