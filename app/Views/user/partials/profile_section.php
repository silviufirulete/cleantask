<!-- PROFILE SECTION -->
<div id="section-profile" class="d-none">
    <div class="row">
        <!-- Profile -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" id="profile-img-preview" class="profile-header-img" onclick="viewProfileImagePopout()">
                        <label for="profile-upload" class="btn btn-primary btn-sm rounded-circle shadow position-absolute" style="bottom: 5px; right: 5px;">📷</label>
                        <input type="file" id="profile-upload" hidden accept="image/*" onchange="uploadAvatar()">
                    </div>
                    <h4 id="profile-name-display" class="mb-1">User</h4>
                    <p class="text-muted small" id="profile-email-display">email@example.com</p>
                    <hr>
                    <form id="update-profile-form" class="text-start">
                        <div class="mb-3">
                            <label class="small text-muted fw-bold" data-i18n="col_name">Name</label>
                            <input type="text" id="profile-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted fw-bold" data-i18n="col_phone">Phone</label>
                            <input type="tel" id="profile-phone" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="small text-muted fw-bold" data-i18n="pref_lang">Language</label>
                            <select id="profile-language" class="form-select">
                                <option value="en">English</option>
                                <option value="de">Deutsch</option>
                                <option value="ro">Română</option>
                                <option value="it">Italiano</option>
                                <option value="sq">Shqip</option>
                                <option value="pl">Polski</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="button" class="btn btn-primary" onclick="saveProfileData()"><span data-i18n="btn_save">Save</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Security -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-danger text-white"><h5 class="mb-0">🔒 <span data-i18n="security_settings">Security</span></h5></div>
                <div class="card-body">
                    <h6 class="fw-bold mb-2" data-i18n="change_password">Change Password</h6>
                    <form id="change-password-form">
                        <div class="mb-2"><input type="password" id="current-password" class="form-control form-control-sm" placeholder="Current Password" required></div>
                        <div class="mb-2"><input type="password" id="new-password" class="form-control form-control-sm" placeholder="New Password" minlength="6" required></div>
                        <div class="mb-2"><input type="password" id="confirm-new-password" class="form-control form-control-sm" placeholder="Confirm" minlength="6" required></div>
                        <button type="submit" class="btn btn-danger btn-sm w-100" data-i18n="update_password">Update</button>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Theme -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-info text-white"><h5 class="mb-0">🎨 <span data-i18n="theme_settings">Theme</span></h5></div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary theme-btn" data-theme="light" onclick="applyTheme('light')">☀️ <span data-i18n="theme_light">Light</span></button>
                        <button class="btn btn-outline-dark theme-btn" data-theme="dark" onclick="applyTheme('dark')">🌙 <span data-i18n="theme_dark">Dark</span></button>
                        <button class="btn btn-outline-primary theme-btn" data-theme="blue" onclick="applyTheme('blue')">💙 <span data-i18n="theme_blue">Blue</span></button>
                        <button class="btn btn-outline-success theme-btn" data-theme="green" onclick="applyTheme('green')">💚 <span data-i18n="theme_green">Green</span></button>
                        <button class="btn btn-outline-danger theme-btn" data-theme="red" onclick="applyTheme('red')">❤️ <span data-i18n="theme_red">Red</span></button>
                        <button class="btn btn-outline-purple theme-btn" data-theme="purple" onclick="applyTheme('purple')">💜 <span data-i18n="theme_purple">Purple</span></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>