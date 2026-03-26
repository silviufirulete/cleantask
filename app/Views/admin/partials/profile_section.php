<!-- === IMPROVED PROFILE SECTION === -->
<div class="row">
    <!-- LEFT: Profile Card -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block mb-3">
                    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" id="profile-img-preview" class="rounded-circle border border-3 border-primary shadow-sm" style="width:150px;height:150px;object-fit:cover;">
                    <label for="profile-upload" class="btn btn-primary btn-sm rounded-circle shadow position-absolute" style="bottom: 5px; right: 5px;">📷</label>
                    <input type="file" id="profile-upload" hidden accept="image/*" onchange="uploadAvatar()">
                </div>
                <h4 id="profile-name-display" class="mb-1">Admin</h4>
                <p class="text-muted small mb-0" id="profile-role-display">Role</p>
                <p class="text-muted small" id="profile-email-display">email@example.com</p>
                <hr>
                <form id="update-profile-form" class="text-start">
                    <div class="mb-3"><label class="small text-muted fw-bold" data-i18n="name">Full Name</label><input type="text" id="profile-name" class="form-control" required></div>
                    <div class="mb-3"><label class="small text-muted fw-bold" data-i18n="phone">Phone Number</label><input type="tel" id="profile-phone" class="form-control"></div>
                    <div class="d-grid"><button type="button" class="btn btn-primary" onclick="saveProfileData()"><span data-i18n="save_changes">Save Changes</span></button></div>
                </form>
            </div>
        </div>
    </div>

    <!-- MIDDLE: Security Settings -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-danger text-white"><h5 class="mb-0">🔒 <span data-i18n="security_settings">Security Settings</span></h5></div>
            <div class="card-body">
                <!-- Change Email -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3" data-i18n="change_email">Change Email</h6>
                    <form id="change-email-form">
                        <div class="mb-2"><label class="small text-muted" data-i18n="current_email">Current Email</label><input type="email" id="current-email-display" class="form-control-plaintext small" readonly></div>
                        <div class="mb-2"><label class="small text-muted" data-i18n="new_email">New Email</label><input type="email" id="new-email" class="form-control form-control-sm" required></div>
                        <div class="mb-3"><label class="small text-muted" data-i18n="confirm_password">Password</label><input type="password" id="email-change-password" class="form-control form-control-sm" required></div>
                        <button type="submit" class="btn btn-warning btn-sm w-100"><span data-i18n="update_email">Update Email</span></button>
                    </form>
                </div>
                <hr>
                <!-- Change Password -->
                <div>
                    <h6 class="fw-bold mb-3" data-i18n="change_password">Change Password</h6>
                    <form id="change-password-form">
                        <div class="mb-2"><label class="small text-muted" data-i18n="current_password">Current Password</label><input type="password" id="current-password" class="form-control form-control-sm" required></div>
                        <div class="mb-2"><label class="small text-muted" data-i18n="new_password">New Password</label><input type="password" id="new-password" class="form-control form-control-sm" minlength="6" required></div>
                        <div class="mb-3"><label class="small text-muted" data-i18n="confirm_new_password">Confirm Password</label><input type="password" id="confirm-new-password" class="form-control form-control-sm" minlength="6" required></div>
                        <button type="submit" class="btn btn-danger btn-sm w-100"><span data-i18n="update_password">Update Password</span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: Theme Customization -->
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-info text-white"><h5 class="mb-0">🎨 <span data-i18n="theme_settings">Theme Settings</span></h5></div>
            <div class="card-body">
                <p class="small text-muted mb-3" data-i18n="theme_description">Customize your dashboard appearance</p>
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-secondary theme-btn" data-theme="light" onclick="applyTheme('light')">☀️ <span data-i18n="theme_light">Light</span></button>
                    <button class="btn btn-outline-dark theme-btn" data-theme="dark" onclick="applyTheme('dark')">🌙 <span data-i18n="theme_dark">Dark</span></button>
                    <button class="btn btn-outline-primary theme-btn" data-theme="blue" onclick="applyTheme('blue')">💙 <span data-i18n="theme_blue">Ocean Blue</span></button>
                    <button class="btn btn-outline-success theme-btn" data-theme="green" onclick="applyTheme('green')">💚 <span data-i18n="theme_green">Forest Green</span></button>
                    <button class="btn btn-outline-danger theme-btn" data-theme="red" onclick="applyTheme('red')">❤️ <span data-i18n="theme_red">Vibrant Red</span></button>
                    <button class="btn btn-outline-purple theme-btn" data-theme="purple" onclick="applyTheme('purple')">💜 <span data-i18n="theme_purple">Royal Purple</span></button>
                </div>
                <hr>
                <div class="alert alert-info small mb-0"><strong data-i18n="current_theme">Current:</strong> <span id="current-theme-name" class="fw-bold">Light</span></div>
            </div>
        </div>
    </div>
</div>