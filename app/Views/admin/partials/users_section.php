<!-- === USERS SECTION === -->
<div class="row">
    <!-- Lista Angajați -->
    <div class="col-md-8" id="user-list-col">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white d-flex justify-content-between">
                <h5 class="mb-0" data-i18n="team_mgmt">Team</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th data-i18n="name">Name</th>
                                <th data-i18n="job">Job</th>
                                <th>Email</th>
                                <th data-i18n="role">Role</th>
                                <th data-i18n="action">Action</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Formular Adăugare Angajat (vizibil doar pt super_admin) -->
    <div class="col-md-4" id="user-create-col">
        <div class="card shadow-sm border-primary">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">➕ <span data-i18n="add_employee">Add</span></h5>
            </div>
            <div class="card-body">
                <form id="create-user-form">
                    <div class="mb-3">
                        <input type="text" id="new-name" class="form-control" required placeholder="Full Name" data-i18n="ph_fullname">
                    </div>
                    <div class="mb-3">
                        <select id="new-jobTitle" class="form-select">
                            <option value="Sonderreiniger">Sonderreiniger</option>
                            <option value="Springer">Springer</option>
                            <option value="Objektleiter">Objektleiter</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="email" id="new-email" class="form-control" required placeholder="Email Address" data-i18n="ph_email">
                    </div>
                    <div class="mb-3">
                        <input type="text" id="new-password" class="form-control" required minlength="6" placeholder="Password" data-i18n="ph_pass">
                    </div>
                    <div class="mb-3">
                        <select id="new-role" class="form-select">
                            <option value="user">Worker</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100" id="btn-create-user" data-i18n="create_user">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>