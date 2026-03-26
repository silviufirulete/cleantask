<!-- === CHAT SECTION (ADMIN) === -->
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Folosim calc(100vh - 160px) pentru a lăsa spațiu pentru navbar și header -->
        <div class="card shadow-sm border-0" style="height: calc(100vh - 160px); max-height: 800px; display: flex; flex-direction: column;">
            
            <!-- Header Chat (Fix sus) cu dropdown de canal -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-2" style="flex: 0 0 auto;">
                <h5 class="mb-0">💬 <span data-i18n="chat">Live Chat</span></h5>
                <select id="chat-channel-select" class="form-select form-select-sm w-auto fw-bold" onchange="window.loadChatMessages()">
                    <option value="team">🌍 Team Chat (All)</option>
                    <option value="admin">🔒 Admin Only</option>
                </select>
            </div>
            
            <!-- Zona principala (Corpul) -->
            <div class="card-body p-0 d-flex flex-column" style="background-color: #f0f2f5; flex: 1 1 auto; min-height: 0;">
                
                <!-- Zona de mesaje care va da SCROLL INTERNAL -->
                <div id="chat-messages" class="p-3" style="flex: 1 1 auto; overflow-y: auto; display: flex; flex-direction: column; gap: 10px;">
                    <div class="text-center text-muted small mt-3"><span class="spinner-border spinner-border-sm"></span> <span data-i18n="loading">Loading...</span></div>
                </div>
                
                <!-- Caseta de trimitere (Fixă jos) -->
                <div class="p-3 bg-white border-top position-relative" style="flex: 0 0 auto;">
                    
                    <!-- MENTIONS DROPDOWN (Ascuns implicit) -->
                    <div id="mentions-dropdown" class="list-group position-absolute w-100 shadow-sm d-none" style="bottom: 100%; left: 0; max-height: 200px; overflow-y: auto; z-index: 1050; margin-bottom: 5px; border-radius: 0.5rem;">
                        <!-- Elementele vor fi generate dinamic prin JS -->
                    </div>

                    <form id="chat-form" class="d-flex gap-2 mb-0">
                        <input type="text" id="chat-input" class="form-control rounded-pill" placeholder="Write a message..." data-i18n="chat_placeholder" autocomplete="off" required>
                        <button type="submit" class="btn btn-primary rounded-circle" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <span style="transform: rotate(45deg); margin-left: -3px;">🚀</span>
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>