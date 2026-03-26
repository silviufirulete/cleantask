<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script src='/js/translations.js'></script>

<script>
// iOS Install Banner
window.dismissIOSBanner = function() { document.getElementById('ios-install-banner').classList.add('d-none'); localStorage.setItem('ios-banner-dismissed', 'true'); }
function checkIOSInstall() {
    const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    const isStandalone = window.navigator.standalone || window.matchMedia('(display-mode: standalone)').matches;
    if (isIOS && !isStandalone && !localStorage.getItem('ios-banner-dismissed')) setTimeout(() => { document.getElementById('ios-install-banner').classList.remove('d-none'); }, 3000);
}

let lastCheck = new Date().getTime();
document.addEventListener('visibilitychange', async function() {
    if (!document.hidden && window.currentUserUid && window.db) {
        const now = new Date().getTime();
        if (now - lastCheck > 10000) {
            try {
                const { collection, query, where, getDocs } = await import("https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js");
                const q = query(collection(window.db, "tasks"), where("status", "==", "new"), where("createdAt", ">", new Date(lastCheck).toISOString()));
                const snap = await getDocs(q);
                if (!snap.empty) {
                    let missedCount = 0;
                    snap.forEach(doc => {
                        const t = doc.data();
                        if (t.assignedType === 'global' || (t.assignedType === 'specific' && t.assignedTo?.includes(window.currentUserUid))) missedCount++;
                    });
                    if (missedCount > 0) {
                        const toast = document.getElementById('task-alert-toast');
                        if(toast) {
                            document.getElementById('toast-body').innerText = `${missedCount} Aufgabe(n)!`;
                            toast.style.display = 'block';
                            if (window.playNotificationSound) window.playNotificationSound();
                        }
                    }
                }
            } catch(e) {}
        }
        lastCheck = now;
    }
});

window.currentLang = localStorage.getItem('appLang') || 'en';
document.addEventListener('DOMContentLoaded', () => {
    document.body.addEventListener('click', () => {
        if(!window.audioCtx) window.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
        if(window.audioCtx.state === 'suspended') window.audioCtx.resume();
    }, {once:true});
    if(typeof setLanguage === 'function') setLanguage(window.currentLang); 
    checkIOSInstall();
});

window.showSection = function(id) {
    ['tasks', 'history', 'calendar', 'profile', 'chat'].forEach(s => {
        const el = document.getElementById('section-'+s);
        if(el) el.classList.add('d-none');
    });
    const target = document.getElementById('section-'+id);
    if(target) target.classList.remove('d-none');
    
    document.querySelectorAll('.nav-link').forEach(btn => btn.classList.remove('active'));
    const tabBtn = document.querySelector(`button[onclick="showSection('${id}')"]`);
    if(tabBtn) tabBtn.classList.add('active');
    
    if(id==='calendar' && window.renderMyCalendar) window.renderMyCalendar();
    if(id==='profile' && window.loadProfileData) window.loadProfileData();
    if(id==='history' && window.loadHistory) window.loadHistory();
    if(id==='chat') {
        if(window.markChatAsRead) window.markChatAsRead();
        if(window.scrollChatToBottom) window.scrollChatToBottom();
    }
}

window.toggleEventFields = function() {
    const type = document.getElementById('event-type').value;
    const descDiv = document.getElementById('field-desc');
    const startTimeDiv = document.getElementById('field-start-time');
    const endTimeDiv = document.getElementById('field-end-time');
    const rowEndDate = document.getElementById('row-end-date');
    descDiv.classList.add('d-none'); startTimeDiv.classList.remove('d-none'); endTimeDiv.classList.remove('d-none'); rowEndDate.classList.remove('d-none');
    if (type === 'note') descDiv.classList.remove('d-none');
    else if (type === 'vacation') { startTimeDiv.classList.add('d-none'); endTimeDiv.classList.add('d-none'); }
}

window.toggleReportUI = function() {
    const status = document.getElementById('report-status').value;
    const commentLabel = document.getElementById('report-comment-label');
    const lang = localStorage.getItem('appLang') || 'en';
    const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
    
    if (status === 'note') { 
        commentLabel.innerText = dict['report_comment_req'] || "Begründung (Erforderlich)"; 
        commentLabel.classList.add('text-danger'); 
    } else { 
        commentLabel.innerText = dict['report_comment_opt'] || "Kommentar (Optional)"; 
        commentLabel.classList.remove('text-danger'); 
    }
}

window.viewProfileImagePopout = function() {
    document.getElementById('profile-img-popout').src = document.getElementById('profile-img-preview').src;
    new bootstrap.Modal(document.getElementById('profileImageModal')).show();
}

window.applyTheme = async function(theme, saveToDb = true) {
    const body = document.body;
    body.classList.remove('theme-dark', 'theme-blue', 'theme-green', 'theme-red', 'theme-purple');
    if (theme !== 'light') body.classList.add('theme-' + theme);
    document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.getAttribute('data-theme') === theme) btn.classList.add('active');
    });
    if (saveToDb && window.currentUserUid && window.db) {
        try { const { doc, updateDoc } = await import("https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js"); await updateDoc(doc(window.db, "users", window.currentUserUid), { theme: theme }); } catch(e) {}
    }
}
window.closeToast = function() { document.getElementById('task-alert-toast').style.display = 'none'; }
</script>

<script type="module">
import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getAuth, onAuthStateChanged, signOut, updateProfile, updateEmail, updatePassword, reauthenticateWithCredential, EmailAuthProvider } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";
import { getFirestore, collection, getDocs, query, where, orderBy, doc, updateDoc, addDoc, getDoc, onSnapshot, deleteDoc } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-firestore.js";
import { getStorage, ref, uploadBytes, getDownloadURL } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-storage.js";
import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

const firebaseConfig = window.firebaseConfig;
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);
const db = getFirestore(app);
const storage = getStorage(app);

let messaging = null;
try {
    messaging = getMessaging(app);
} catch (e) {
    console.log("FCM nu este suportat.");
}

window.db = db;
window.currentUserUid = null;

let reportModal, viewTaskModal, addEventModal, eventDetailsModal, calendar;
let currentUserName = ""; 
let allTasksMap = new Map(); 
let userEvents = [];
const appLoadTime = new Date().getTime(); 

window.resizeImage = async function(file, maxWidth = 800, maxHeight = 800, quality = 0.8) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                let width = img.width;
                let height = img.height;
                if (width > height) {
                    if (width > maxWidth) { height *= maxWidth / width; width = maxWidth; }
                } else {
                    if (height > maxHeight) { width *= maxHeight / height; height = maxHeight; }
                }
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);
                canvas.toBlob((blob) => { resolve(blob); }, 'image/jpeg', quality);
            };
            img.onerror = reject;
            img.src = e.target.result;
        };
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}

window.requestPushPermission = async function(isSilent = false) {
    try {
        const p = await Notification.requestPermission();
        if (p === 'granted') { 
            document.getElementById('push-permission-alert')?.classList.add('d-none'); 
            
            if (messaging && window.currentUserUid) {
                try {
                    const registration = await navigator.serviceWorker.ready;
                    const vapidKey = "BBhSul_Zk66U4O4o-pjmXLR81y1bFL6fqPPzatqOaP9aQVun9ekp-CtFLudotFY_v9AL6OgR4o6kM4-tgnl6jWg"; 
                    
                    const currentToken = await getToken(messaging, { 
                        vapidKey: vapidKey,
                        serviceWorkerRegistration: registration 
                    });
                    
                    if (currentToken) {
                        await updateDoc(doc(db, "users", window.currentUserUid), { fcmToken: currentToken });
                    }
                } catch (tokenErr) {
                    console.error("Eroare la generarea token-ului:", tokenErr);
                }
            }
        }
    } catch(e){ console.error("Eroare permisiune:", e); }
}

function checkPushPermission() {
    if ('Notification' in window) {
        if (Notification.permission === 'default' && !sessionStorage.getItem('push-alert-shown')) {
            setTimeout(() => { document.getElementById('push-permission-alert')?.classList.remove('d-none'); sessionStorage.setItem('push-alert-shown', 'true'); }, 5000);
        } else if (Notification.permission === 'granted') {
            window.requestPushPermission(true);
        }
    }
}

onAuthStateChanged(auth, async (user) => {
    if (!user) { window.location.href = '/login'; return; }
    try {
        const userDoc = await getDoc(doc(db, "users", user.uid));
        if (userDoc.exists()) {
            const userData = userDoc.data();
            if (user.email === 'silviu.firulete@gmail.com') userData.role = 'super_admin';
            if (userData.role === 'admin' || userData.role === 'super_admin') {
                window.location.href = '/admin'; return; 
            }

            window.currentUserUid = user.uid;
            currentUserName = userData.name || "User";
            document.getElementById('loading-msg')?.classList.add('d-none');
            document.getElementById('user-content')?.classList.remove('d-none');
            
            if (document.getElementById('profile-name-display')) {
                document.getElementById('profile-name-display').innerText = currentUserName;
                document.getElementById('profile-name').value = currentUserName;
                document.getElementById('profile-email-display').innerText = user.email;
                document.getElementById('profile-phone').value = userData.phoneNumber || '';
            }
            if(userData.photoUrl && document.getElementById('nav-profile-img')) {
                document.getElementById('nav-profile-img').src = userData.photoUrl;
                document.getElementById('profile-img-preview').src = userData.photoUrl;
            }
            if(userData.theme) applyTheme(userData.theme, false);

            loadMyTasks(); 
            subscribeToNotifications(); 
            checkPushPermission();
            initChatSystem();
            
            const notifPref = localStorage.getItem('task_notif_pref');
            updateMuteIcon(notifPref === 'disabled');

            reportModal = new bootstrap.Modal(document.getElementById('reportModal'));
            viewTaskModal = new bootstrap.Modal(document.getElementById('viewTaskModal'));
            addEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));
            eventDetailsModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
        }
    } catch(e) { console.error("Auth Error:", e); }
});

let chatUnsubscribe = null;
let unreadChatCount = 0;
let allSystemUsers = []; 

window.markChatAsRead = function() {
    unreadChatCount = 0;
    const badge = document.getElementById('chat-unread-badge');
    if(badge) {
        badge.innerText = 0;
        badge.classList.add('d-none');
    }
    localStorage.setItem('lastChatReadTime', new Date().toISOString());
}

window.scrollChatToBottom = function() {
    const container = document.getElementById('chat-messages');
    if(container) container.scrollTop = container.scrollHeight;
}

function highlightMentions(text, isMe) {
    if (!text) return "";
    return text.replace(/@([a-zA-Z0-9_.-]+(\s[a-zA-Z0-9_.-]+)?)/g, function(match) {
         if (isMe) {
             return `<span class="text-warning fw-bold bg-white bg-opacity-25 px-1 rounded">${match}</span>`;
         } else {
             return `<span class="text-primary fw-bold bg-primary bg-opacity-10 px-1 rounded">${match}</span>`;
         }
    });
}

function initChatSystem() {
    if (!window.currentUserUid) return;
    
    if(allSystemUsers.length === 0) {
        getDocs(collection(window.db, "users")).then(snap => {
            snap.forEach(doc => {
                const u = doc.data();
                if(u.name) allSystemUsers.push({ id: doc.id, name: u.name });
            });
        }).catch(e => console.log("Failed to load users for mentions"));
    }
    
    const container = document.getElementById('chat-messages');
    const q = query(collection(db, "chats", "team", "messages"), orderBy("timestamp", "asc"));
    
    chatUnsubscribe = onSnapshot(q, (snap) => {
        const lastReadStr = localStorage.getItem('lastChatReadTime');
        const lastRead = lastReadStr ? new Date(lastReadStr) : new Date(0);
        let currentChatHtml = '';
        
        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
        const noMessagesText = dict['chat_no_messages'] || 'Noch keine Nachrichten. Schreib als Erster!';

        if (snap.empty) {
            if(container) container.innerHTML = `<div class="text-center text-muted small mt-4">${noMessagesText}</div>`;
            return;
        }

        unreadChatCount = 0;

        snap.forEach(doc => {
            const m = doc.data();
            const msgTime = m.timestamp ? new Date(m.timestamp) : new Date();
            const isMe = m.senderId === window.currentUserUid;
            const timeStr = msgTime.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
            
            const chatSection = document.getElementById('section-chat');
            const isChatActive = chatSection && !chatSection.classList.contains('d-none');
            
            if (!isMe && msgTime > lastRead) {
                if (isChatActive) {
                    localStorage.setItem('lastChatReadTime', new Date().toISOString());
                } else {
                    unreadChatCount++;
                }
            }

            const photoUrl = m.senderPhoto || 'https://cdn-icons-png.flaticon.com/512/149/149071.png';
            
            let safeText = m.text.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            let formattedText = highlightMentions(safeText, isMe);

            if (isMe) {
                currentChatHtml += `
                    <div class="align-self-end d-flex flex-column mb-1" style="max-width: 85%;">
                        <div class="p-2 shadow-sm bg-primary text-white rounded-3 rounded-bottom-0" style="word-wrap: break-word;">
                            ${formattedText}
                        </div>
                        <div class="text-muted text-end mt-1" style="font-size: 0.65rem;">${timeStr}</div>
                    </div>
                `;
            } else {
                currentChatHtml += `
                    <div class="align-self-start d-flex mb-1" style="max-width: 85%; gap: 8px;">
                        <img src="${photoUrl}" class="rounded-circle mt-1 shadow-sm" style="width: 28px; height: 28px; object-fit: cover; flex-shrink: 0;">
                        <div class="d-flex flex-column">
                            <div class="small text-muted mb-1" style="font-size: 0.7rem; font-weight: bold; margin-left: 2px;">${m.senderName}</div>
                            <div class="p-2 shadow-sm bg-white border text-dark rounded-3 rounded-top-0" style="word-wrap: break-word;">
                                ${formattedText}
                            </div>
                            <div class="text-muted text-start mt-1" style="font-size: 0.65rem;">${timeStr}</div>
                        </div>
                    </div>
                `;
            }
        });

        if(container) {
            container.innerHTML = currentChatHtml;
            const chatSection = document.getElementById('section-chat');
            if (chatSection && !chatSection.classList.contains('d-none')) {
                container.scrollTop = container.scrollHeight;
            }
        }

        const badge = document.getElementById('chat-unread-badge');
        if(badge) {
            if(unreadChatCount > 0) {
                badge.innerText = unreadChatCount > 9 ? '9+' : unreadChatCount;
                badge.classList.remove('d-none');
                if("vibrate" in navigator && localStorage.getItem('task_notif_pref') !== 'disabled') navigator.vibrate([200]);
            } else {
                badge.classList.add('d-none');
            }
        }
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
    if(mentionsDropdown) {
        mentionsDropdown.classList.add('d-none');
        mentionsDropdown.innerHTML = '';
        currentMentionSearch = '';
    }
}

document.getElementById('chat-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const input = document.getElementById('chat-input');
    const text = input.value.trim();
    if (!text || !window.currentUserUid) return;
    
    input.value = '';
    hideMentionsDropdown(); 
    const profileImgSrc = document.getElementById('nav-profile-img')?.src || 'https://cdn-icons-png.flaticon.com/512/149/149071.png';

    try {
        await addDoc(collection(db, "chats", "team", "messages"), {
            text: text,
            senderId: window.currentUserUid,
            senderName: currentUserName,
            senderPhoto: profileImgSrc, 
            timestamp: new Date().toISOString()
        });
        window.markChatAsRead(); 
    } catch(e) {
        const lang = localStorage.getItem('appLang') || 'en';
        const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
        alert(dict['chat_send_error'] || 'Nachricht konnte nicht gesendet werden.');
    }
});

window.toggleNotificationPreference = function() {
    const current = localStorage.getItem('task_notif_pref');
    if (current === 'disabled') { localStorage.setItem('task_notif_pref', 'enabled'); updateMuteIcon(false); }
    else { localStorage.setItem('task_notif_pref', 'disabled'); updateMuteIcon(true); }
}
function updateMuteIcon(isMuted) {
    if(document.getElementById('btn-mute-toggle')) document.getElementById('btn-mute-toggle').innerHTML = isMuted ? '🔇' : '🔊';
}
window.playNotificationSound = function() {
    if (localStorage.getItem('task_notif_pref') === 'disabled') return;
    if(!window.audioCtx) return; 
    if(window.audioCtx.state === 'suspended') window.audioCtx.resume();
    const o = window.audioCtx.createOscillator(); const g = window.audioCtx.createGain();
    o.connect(g); g.connect(window.audioCtx.destination);
    o.type = 'square'; o.frequency.setValueAtTime(400, window.audioCtx.currentTime);
    o.frequency.exponentialRampToValueAtTime(600, window.audioCtx.currentTime + 0.1);
    g.gain.setValueAtTime(0.3, window.audioCtx.currentTime);
    o.start(); o.stop(window.audioCtx.currentTime + 0.5);
}

let unreadCount = 0;
function addNotificationToCenter(title, body) {
    unreadCount++;
    if(document.getElementById('notif-counter')) {
        document.getElementById('notif-counter').innerText = unreadCount;
        document.getElementById('notif-counter').classList.remove('d-none');
        document.getElementById('no-notifs')?.remove();
        const list = document.getElementById('notif-list');
        list.insertAdjacentHTML('afterbegin', `<div class="notif-item unread border-bottom p-2"><div class="fw-bold small">${title}</div><div class="small text-dark">${body}</div></div>`);
    }
}
window.clearNotifications = function() {
    unreadCount = 0;
    if(document.getElementById('notif-counter')) {
        document.getElementById('notif-counter').classList.add('d-none');
        document.getElementById('notif-list').innerHTML = '<li class="text-center p-3 text-muted small" id="no-notifs">Keine neuen Benachrichtigungen</li>';
    }
}

function subscribeToNotifications() {
    const q = query(collection(db, "tasks"), where("status", "==", "new"));
    onSnapshot(q, (snapshot) => {
        snapshot.docChanges().forEach((change) => {
            if (change.type === "added") {
                const task = change.doc.data();
                if (new Date(task.createdAt).getTime() > appLoadTime) {
                    let shouldNotify = (task.assignedType === 'global') || (task.assignedType === 'specific' && task.assignedTo?.includes(window.currentUserUid));
                    if (shouldNotify) {
                        playNotificationSound();
                        const title = task.assignedType === 'global' ? "Neue globale Aufgabe!" : "Aufgabe zugewiesen!";
                        addNotificationToCenter(title, task.title);
                        const toast = document.getElementById('task-alert-toast');
                        if(toast) {
                            document.getElementById('toast-body').innerText = task.title;
                            toast.style.display = 'block';
                        }
                        if("vibrate" in navigator && localStorage.getItem('task_notif_pref') !== 'disabled') navigator.vibrate([300, 100, 300]);
                    }
                }
            }
        });
    });
}

let globalUnsubscribe, specificUnsubscribe;
window.loadMyTasks = async function() {
    if(!window.currentUserUid) return;
    
    if(globalUnsubscribe) globalUnsubscribe();
    if(specificUnsubscribe) specificUnsubscribe();

    const container = document.getElementById('tasks-container');
    if(container) container.innerHTML = '<div class="text-center w-100 p-4"><div class="spinner-border text-primary"></div><p class="mt-2 text-muted small">Aufgaben werden geladen...</p></div>';

    const updateAndRender = (id, data, isRemoved = false) => {
        if (isRemoved) allTasksMap.delete(id);
        else allTasksMap.set(id, {id, ...data});
    };

    let globalLoaded = false;
    let specificLoaded = false;

    const checkAndRender = () => {
        if (globalLoaded && specificLoaded) {
            window.applySortFilter();
        }
    };

    try {
        globalUnsubscribe = onSnapshot(query(collection(db, "tasks"), where("assignedType", "==", "global")), (snap) => {
            snap.docChanges().forEach(c => updateAndRender(c.doc.id, c.doc.data(), c.type === 'removed'));
            globalLoaded = true;
            checkAndRender();
            if (globalLoaded && specificLoaded) window.applySortFilter(); 
        }, (err) => {
            console.error("Global tasks error:", err);
            globalLoaded = true; checkAndRender();
        });

        specificUnsubscribe = onSnapshot(query(collection(db, "tasks"), where("assignedTo", "array-contains", window.currentUserUid)), (snap) => {
            snap.docChanges().forEach(c => updateAndRender(c.doc.id, c.doc.data(), c.type === 'removed'));
            specificLoaded = true;
            checkAndRender();
            if (globalLoaded && specificLoaded) window.applySortFilter(); 
        }, (err) => {
            console.error("Specific tasks error:", err);
            specificLoaded = true; checkAndRender();
        });
    } catch(err) {
        if(container) container.innerHTML = `<div class="alert alert-danger w-100 text-center">Fehler beim Laden der Aufgaben: ${err.message}</div>`;
    }
}

window.applySortFilter = function() {
    const container = document.getElementById('tasks-container');
    if(!container) return;
    
    const filterEl = document.getElementById('task-sort-filter');
    const sortVal = filterEl ? filterEl.value : 'newest';
    
    const tasks = Array.from(allTasksMap.values()).filter(t => t.status !== 'done' && t.status !== 'archive');
    
    tasks.sort((a, b) => {
        if (sortVal === 'newest') return new Date(b.createdAt || 0) - new Date(a.createdAt || 0); 
        if (sortVal === 'oldest') return new Date(a.createdAt || 0) - new Date(b.createdAt || 0); 
        if (sortVal === 'name') return (a.title || '').localeCompare(b.title || ''); 
        if (sortVal === 'deadline') return new Date(a.deadline || 0) - new Date(b.deadline || 0); 
        return 0;
    });

    if (tasks.length === 0) { 
        container.innerHTML = '';
        const noTasksEl = document.getElementById('no-tasks');
        if(noTasksEl) noTasksEl.classList.remove('d-none'); 
        return; 
    } else {
        const noTasksEl = document.getElementById('no-tasks');
        if(noTasksEl) noTasksEl.classList.add('d-none');
    }

    const now = new Date();
    const lang = localStorage.getItem('appLang') || 'en';
    const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};

    let finalHtml = '';

    tasks.forEach(t => {
        try {
            const deadline = t.deadline ? new Date(t.deadline) : new Date();
            const isOverdue = deadline < now;
            let cardClass = isOverdue ? 'card-overdue' : '';
            
            const priority = t.priority || 'low';
            const status = t.status || 'new';
            
            const rawTitle = t.title || 'Kein Titel';
            const displayTitle = rawTitle.replace(/</g, "&lt;").replace(/>/g, "&gt;");
            const safeTitleForJS = rawTitle.replace(/'/g, "\\'").replace(/"/g, '&quot;');
            
            // MODIFICAT: Aici nu mai tăiem tagurile de HTML, le lăsăm intacte ca să le citească browserul!
            const desc = t.description ? t.description : '-';
            
            let badgeClass = priority === 'high' ? 'bg-danger' : (priority === 'medium' ? 'bg-warning text-dark' : 'bg-success');
            let overdueAlert = isOverdue ? `<div class="badge-overdue text-white text-center fw-bold p-1 rounded mb-2 w-100">⚠️ ${dict['task_overdue'] || 'ÜBERFÄLLIG'}</div>` : '';
            
            let imgBtn = '';
            if(t.descriptionImages && Array.isArray(t.descriptionImages) && t.descriptionImages.length > 0) {
                const safeImgs = JSON.stringify(t.descriptionImages).replace(/"/g, '&quot;').replace(/'/g, "\\'");
                imgBtn = `<button class="btn btn-sm btn-outline-info w-100 mb-2" onclick="viewImages(${safeImgs})">📷 ${dict['view_images'] || 'Bilder'}</button>`;
            }
            
            let reqHtml = '';
            if (t.requirements && Array.isArray(t.requirements) && t.requirements.length > 0) {
                const reqList = t.requirements.map(r => dict[`req_${r}`] || r).join(', ');
                reqHtml = `<div class="small text-info mb-2"><strong>🧰 ${dict['req_label'] || 'Erforderlich'}:</strong> ${reqList}</div>`;
            }

            let actionBtn = '';
            if (t.assignedType === 'global') {
                if (!t.claimedBy) {
                    actionBtn = `<button class="btn btn-warning w-100 fw-bold shadow-sm" onclick="claimTask('${t.id}')">🙋‍♂️ ${dict['btn_claim'] || 'Übernehmen'}</button>`;
                } else if (t.claimedBy === window.currentUserUid) {
                    actionBtn = `<button class="btn btn-primary w-100" onclick="openReport('${t.id}', '${safeTitleForJS}')">📝 ${dict['btn_report'] || 'Bericht'}</button>`;
                } else {
                    actionBtn = `<div class="claimed-badge text-center small text-muted border p-1 rounded">🔒 ${dict['claimed_by'] || 'Übernommen'} <strong>${t.claimedByName || 'Unbekannt'}</strong></div>`;
                }
            } else {
                actionBtn = `<button class="btn btn-primary w-100" onclick="openReport('${t.id}', '${safeTitleForJS}')">📝 ${dict['btn_report'] || 'Bericht'}</button>`;
            }

            finalHtml += `
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card shadow-sm h-100 ${cardClass}">
                        <div class="card-header bg-white d-flex justify-content-between">
                            <span class="badge ${badgeClass}">${priority.toUpperCase()}</span>
                            <small class="text-muted fw-bold">${deadline.toLocaleDateString()}</small>
                        </div>
                        <div class="card-body d-flex flex-column">
                            ${overdueAlert}
                            <h5 class="card-title">${displayTitle}</h5>
                            ${reqHtml}
                            
                            <!-- MODIFICAT: Schimbat din tag-ul <p> într-un <div> și lăsat conținutul să respire -->
                            <div class="card-text text-muted small mb-3 flex-grow-1 rich-text-content">${desc}</div>
                            
                            ${imgBtn}
                            <div class="mt-auto">${actionBtn}</div>
                        </div>
                        <div class="card-footer bg-light text-muted small text-center">
                            Status: <strong>${status.toUpperCase()}</strong>
                        </div>
                    </div>
                </div>`;
        } catch(err) {
            console.error("Eroare la randarea unui task specific:", t, err);
        }
    });
    
    container.innerHTML = finalHtml;
}

window.claimTask = async function(taskId) {
    const lang = localStorage.getItem('appLang') || 'en';
    const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
    if(!confirm(dict['confirm_claim'] || "Diese Aufgabe übernehmen?")) return;
    try { await updateDoc(doc(db, "tasks", taskId), { claimedBy: window.currentUserUid, claimedByName: currentUserName, status: 'in_progress' }); } catch(e) { alert(e.message); }
}

// ---------------------------------------------------------
// FUNCȚII NOI POZE (FĂRĂ BUTOANE JS, DOAR PRELUARE DATĂ)
// ---------------------------------------------------------
window.currentReportFile = null;

window.handleReportFileSelect = function(input) {
    const file = input.files[0];
    if (file) {
        window.currentReportFile = file;
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('report-photo-preview').src = e.target.result;
            document.getElementById('report-photo-preview-container').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
    // Golește celălalt input ca să nu se încalece dacă utilizatorul se răzgândește
    if (input.id === 'report-file-camera') {
        document.getElementById('report-file-gallery').value = '';
    } else {
        document.getElementById('report-file-camera').value = '';
    }
}

window.clearReportImage = function() {
    document.getElementById('report-file-camera').value = "";
    document.getElementById('report-file-gallery').value = "";
    window.currentReportFile = null;
    document.getElementById('report-photo-preview').src = "";
    document.getElementById('report-photo-preview-container').classList.add('d-none');
}

window.openReport = function(id, t) {
    document.getElementById('report-task-id').value = id;
    document.getElementById('report-task-title').innerText = t;
    document.getElementById('report-comment').value = "";
    document.getElementById('report-status').value = "done"; 
    toggleReportUI();
    document.getElementById('upload-progress').classList.add('d-none');
    window.clearReportImage(); // Resetare poze vechi
    reportModal.show();
}

window.submitReport = async function() {
    const id = document.getElementById('report-task-id').value;
    const com = document.getElementById('report-comment').value;
    const reportStatus = document.getElementById('report-status').value;
    
    // Luăm fișierul din variabila globală, indiferent din care buton a venit
    const f = window.currentReportFile; 
    
    const btn = document.getElementById('btn-send-report');
    
    if (reportStatus === 'note' && !com.trim()) { 
        alert("Kommentar ist für Notizen erforderlich!"); 
        return; 
    }
    
    btn.disabled = true; btn.innerText = "Wird gesendet...";
    
    try {
        let u = null;
        if(f) {
            document.getElementById('upload-progress').classList.remove('d-none');
            const b = await window.resizeImage(f);
            const r = ref(storage, `updates/${id}_${window.currentUserUid}_${Date.now()}.jpg`);
            await uploadBytes(r, b);
            u = await getDownloadURL(r);
        }
        await addDoc(collection(db, "task_updates"), {
            taskId: id, userId: window.currentUserUid, userName: currentUserName, comment: com,
            newStatus: (reportStatus === 'done' ? 'done' : 'note'), photoUrl: u, createdAt: new Date().toISOString()
        });
        if (reportStatus === 'done') { 
            await updateDoc(doc(db, "tasks", id), {
                status: 'done',
                completedAt: new Date().toISOString()
            }); 
            alert("✅ Aufgabe erledigt!"); 
        } 
        else { alert("✅ Notiz hinzugefügt!"); }
        reportModal.hide();
    } catch(e) { 
        alert("❌ " + e.message); 
    } finally { 
        btn.disabled = false; 
        btn.innerText = "Senden"; 
    }
}

window.loadHistory = async function() {
    const lang = localStorage.getItem('appLang') || 'en';
    const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};
    
    const b = document.getElementById('history-table-body'); 
    if(!b) return;
    b.innerHTML = `<tr><td colspan="3">Wird geladen...</td></tr>`;
    const [sG, sS] = await Promise.all([
        getDocs(query(collection(db, "tasks"), where("assignedType", "==", "global"), where("status", "==", "done"))),
        getDocs(query(collection(db, "tasks"), where("assignedTo", "array-contains", window.currentUserUid), where("status", "==", "done")))
    ]);
    let ts = []; sG.forEach(d => ts.push({id: d.id, ...d.data()})); sS.forEach(d => ts.push({id: d.id, ...d.data()}));
    const unique = Array.from(new Set(ts.map(JSON.stringify))).map(JSON.parse); 
    
    unique.sort((a, b) => {
        const dateA = a.completedAt ? new Date(a.completedAt) : new Date(a.deadline);
        const dateB = b.completedAt ? new Date(b.completedAt) : new Date(b.deadline);
        return dateB - dateA;
    });

    b.innerHTML = unique.length === 0 ? '<tr><td colspan="3">Leer.</td></tr>' : '';
    unique.forEach(t => { 
        const doneDate = t.completedAt ? new Date(t.completedAt).toLocaleString([], {day:'2-digit', month:'2-digit', year:'numeric', hour:'2-digit', minute:'2-digit'}) : new Date(t.deadline).toLocaleDateString();
        b.innerHTML += `<tr class="history-row" onclick="viewHistoryDetails('${t.id}', '${t.title}', '${t.deadline}')"><td>${t.title}</td><td>${doneDate}</td><td><span class="badge bg-success">Done</span></td></tr>`; 
    });
}

window.viewHistoryDetails = async function(taskId, title, date) {
    document.getElementById('view-h-title').innerText = title;
    document.getElementById('view-h-date').innerText = "Datum: " + new Date(date).toLocaleString();
    document.getElementById('view-h-comment').innerText = "Wird geladen...";
    document.getElementById('view-h-photo-container').classList.add('d-none');
    viewTaskModal.show();
    try {
        const q = query(collection(db, "task_updates"), where("taskId", "==", taskId));
        const snap = await getDocs(q);
        if (!snap.empty) {
            let updates = []; snap.forEach(d => updates.push(d.data()));
            updates.sort((a,b) => new Date(b.createdAt) - new Date(a.createdAt));
            const d = updates.find(u => u.newStatus === 'done') || updates[0];
            document.getElementById('view-h-comment').innerText = d.comment || "Kein Kommentar.";
            if (d.photoUrl) { document.getElementById('view-h-photo').src = d.photoUrl; document.getElementById('view-h-photo-container').classList.remove('d-none'); }
        } else { document.getElementById('view-h-comment').innerText = "Keine Details."; }
    } catch(e) { console.error(e); }
}

window.openAddEventModal = function() {
    document.getElementById('event-title').value = ''; document.getElementById('event-desc').value = '';
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('event-start-date').value = today; document.getElementById('event-end-date').value = today;
    toggleEventFields(); addEventModal.show();
}

window.savePersonalEvent = async function() {
    const type = document.getElementById('event-type').value;
    const title = document.getElementById('event-title').value;
    const sDate = document.getElementById('event-start-date').value;
    if(!title || !sDate) return alert("Titel und Startdatum sind erforderlich");
    let startIso = sDate, endIso = document.getElementById('event-end-date').value;
    if (type !== 'vacation') {
        if (document.getElementById('event-start-time').value) startIso += 'T' + document.getElementById('event-start-time').value;
        if (document.getElementById('event-end-time').value) endIso += 'T' + document.getElementById('event-end-time').value;
    }
    try {
        await addDoc(collection(db, "user_events"), { userId: window.currentUserUid, userName: currentUserName, type, title, description: (type === 'note') ? document.getElementById('event-desc').value : '', start: startIso, end: endIso || startIso, createdAt: new Date().toISOString() });
        addEventModal.hide(); renderMyCalendar();
    } catch(e) { alert(e.message); }
}

window.deletePersonalEvent = async function() {
    if(confirm("Möchten Sie dieses Ereignis löschen?")) { try { await deleteDoc(doc(db, "user_events", document.getElementById('det-event-id').value)); eventDetailsModal.hide(); renderMyCalendar(); } catch(e) { alert(e.message); } }
}

window.renderMyCalendar = async function() {
    if(!window.currentUserUid) return;
    try { const snap = await getDocs(query(collection(db, "user_events"), where("userId", "==", window.currentUserUid))); userEvents = []; snap.forEach(d => userEvents.push({id: d.id, ...d.data()})); } catch(e){}
    const events = [];
    allTasksMap.forEach((t) => {
        if(t.status !== 'done') events.push({ title: t.title, start: t.deadline, backgroundColor: (new Date(t.deadline) < new Date()) ? '#dc3545' : '#ffc107', borderColor: '#ffc107', extendedProps: { isTask: true, status: t.status, assignedType: t.assignedType, assignedTo: t.assignedNames, claimedBy: t.claimedBy, claimedByName: t.claimedByName } });
    });
    userEvents.forEach(e => {
        let color = '#17a2b8'; if(e.type === 'vacation') color = '#6f42c1'; if(e.type === 'appointment') color = '#fd7e14';
        events.push({ id: e.id, title: (e.type === 'vacation' ? '✈️ ' : '📅 ') + e.title, start: e.start, end: e.end, backgroundColor: color, borderColor: color, extendedProps: { isPersonal: true, desc: e.description, type: e.type } });
    });
    if(!calendar) {
        const calendarEl = document.getElementById('calendar');
        const currentLang = localStorage.getItem('appLang') || 'en';
        
        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth', 
            height: 450, 
            locale: currentLang, 
            headerToolbar: {left:'title', right:'prev,next'}, 
            events: events,
            eventClick: function(info) {
                const props = info.event.extendedProps;
                
                const lang = localStorage.getItem('appLang') || 'en';
                const dict = (typeof translations !== 'undefined' && translations[lang]) ? translations[lang] : {};

                document.getElementById('det-event-title').innerText = info.event.title;
                const dateStr = info.event.start.toLocaleDateString() + (info.event.start.getHours() ? ' ' + info.event.start.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'}) : '');
                document.getElementById('det-event-date').innerText = dateStr;
                document.getElementById('det-event-id').value = info.event.id;
                const footer = document.getElementById('det-event-footer');
                const descBox = document.getElementById('det-event-desc');
                
                if(props.isTask) {
                    descBox.innerText = `Status: ${props.status.toUpperCase()}\nTyp: ${props.assignedType}`;
                    footer.children[0].style.display = 'none'; 
                } else if (props.isPersonal) {
                    descBox.innerText = props.type.toUpperCase() + (props.desc ? `\n\n${props.desc}` : '');
                    footer.children[0].style.display = 'block';
                }
                eventDetailsModal.show();
            }
        });
        calendar.render();
    } else { 
        calendar.removeAllEvents(); 
        calendar.addEventSource(events); 
        calendar.render(); 
    }
}

window.addEventListener('languageChanged', (e) => {
    if(calendar) {
        calendar.setOption('locale', e.detail.lang);
    }
});

window.loadProfileData = async function() {}

window.saveProfileData = async function() {
    if(!window.currentUserUid) return;
    const newName = document.getElementById('profile-name').value;
    const newPhone = document.getElementById('profile-phone').value;
    const newLang = document.getElementById('profile-language').value;

    try {
        await updateDoc(doc(db, "users", window.currentUserUid), {
            name: newName,
            phoneNumber: newPhone,
            language: newLang
        });
        
        document.getElementById('profile-name-display').innerText = newName;
        
        if(newLang !== window.currentLang) {
            setLanguage(newLang);
        }
        alert("✅ Profil erfolgreich aktualisiert!");
    } catch(e) { console.error(e); alert("❌ Fehler beim Aktualisieren des Profils."); }
}

window.uploadAvatar = async function() {
    const file = document.getElementById('profile-upload').files[0];
    if(!file || !window.currentUserUid) return;

    try {
        const b = await window.resizeImage(file);
        const r = ref(storage, `avatars/${window.currentUserUid}.jpg`);
        await uploadBytes(r, b);
        const url = await getDownloadURL(r);
        
        await updateDoc(doc(db, "users", window.currentUserUid), { photoUrl: url });
        
        document.getElementById('nav-profile-img').src = url;
        document.getElementById('profile-img-preview').src = url;
        
        alert("✅ Avatar aktualisiert!");
    } catch(e) { console.error(e); alert("❌ Fehler beim Hochladen des Avatars."); }
}

document.getElementById('change-password-form')?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const currentPwd = document.getElementById('current-password').value;
    const newPwd = document.getElementById('new-password').value;
    const confirmPwd = document.getElementById('confirm-new-password').value;
    if (newPwd !== confirmPwd) { alert("❌ Passwörter stimmen nicht überein!"); return; }
    if (newPwd.length < 6) { alert("❌ Passwort muss mindestens 6 Zeichen lang sein!"); return; }
    try {
        const credential = EmailAuthProvider.credential(auth.currentUser.email, currentPwd);
        await reauthenticateWithCredential(auth.currentUser, credential);
        await updatePassword(auth.currentUser, newPwd);
        alert("✅ Passwort aktualisiert!"); document.getElementById('change-password-form').reset();
    } catch(e) { alert("❌ Fehler: " + e.message); }
});

document.getElementById('btn-logout')?.addEventListener('click', () => { signOut(auth).then(() => window.location.href = '/login'); });
window.viewImages = function(arr){ const c=document.getElementById('images-container'); c.innerHTML=''; arr.forEach(u=>{ c.innerHTML+=`<img src="${u}" class="img-fluid mb-2 border rounded">` }); new bootstrap.Modal(document.getElementById('viewImagesModal')).show(); }
</script>