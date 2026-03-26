<!-- MODALS -->

<!-- Edit Task Modal -->
<div class="modal fade" id="editTaskModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-light"><h5 class="modal-title">✏️ <span data-i18n="edit_task">Edit Task</span></h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
<div class="modal-body">
<input type="hidden" id="edit-task-id">
<div class="mb-2"><label class="small fw-bold" data-i18n="title">Title</label><input type="text" id="edit-title" class="form-control"></div>

<!-- EDITOR RICH TEXT PENTRU EDITARE -->
<div class="mb-2">
<label class="small fw-bold" data-i18n="desc">Beschreibung</label>
<div id="edit-desc-editor"></div>
</div>

<div class="mb-2 mt-3"><label class="small fw-bold text-danger" data-i18n="deadline">Deadline</label><div class="input-group"><input type="date" id="edit-date" class="form-control"><select id="edit-hour" class="form-select" style="max-width: 100px;"></select></div></div>
<div class="row">
<div class="col-6"><label class="small fw-bold" data-i18n="status">Status</label><select id="edit-status" class="form-select"><option value="new">New</option><option value="in_progress">In Progress</option><option value="note">Note/Delay</option><option value="done">Done</option><option value="blocked">Blocked</option></select></div>
<div class="col-6"><label class="small fw-bold" data-i18n="priority">Priority</label><select id="edit-priority" class="form-select"><option value="low">Low</option><option value="medium">Medium</option><option value="high">High</option></select></div>
</div>
<div class="mt-2 border p-2 rounded bg-light">
<label class="small fw-bold" data-i18n="assign">Re-Assign:</label>
<div class="form-check"><input class="form-check-input" type="radio" name="editAssignType" value="global" id="editAssignGlobal" onchange="toggleUserSelect('edit')"> <label class="form-check-label" for="editAssignGlobal" data-i18n="global_assign">Global</label></div>
<div class="form-check"><input class="form-check-input" type="radio" name="editAssignType" value="specific" id="editAssignSpecific" onchange="toggleUserSelect('edit')"> <label class="form-check-label" for="editAssignSpecific" data-i18n="specific_assign">Specific</label></div>
<div id="edit-worker-container" class="mt-2 d-none worker-select-box"><div id="edit-worker-checkboxes" class="ps-2 small"></div></div>
</div>
</div>
<div class="modal-footer d-flex justify-content-between">
<button type="button" class="btn btn-danger btn-sm" onclick="deleteTaskFromEdit()" data-i18n="delete">🗑️ Delete</button>
<div>
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-i18n="cancel">Cancel</button>
<button type="button" class="btn btn-primary btn-sm" onclick="saveTaskEdit()" data-i18n="save_changes">Save</button>
</div>
</div>
</div>
</div>
</div>

<!-- View History Modal -->
<div class="modal fade" id="viewHistoryModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-warning">
<h5 class="modal-title">📜 <span data-i18n="logs_title">Task Logs & Notes</span></h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body" id="history-modal-body">
<div class="text-center"><div class="spinner-border spinner-border-sm"></div> <span data-i18n="loading">Loading...</span></div>
</div>
</div>
</div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-light">
<h5 class="modal-title">👤 Edit User</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<input type="hidden" id="edit-user-id">
<div class="mb-2"><label class="small fw-bold" data-i18n="name">Name</label><input type="text" id="edit-user-name" class="form-control form-control-sm" required></div>
<div class="mb-2"><label class="small fw-bold">Email</label><input type="email" id="edit-user-email" class="form-control form-control-sm" required></div>
<div class="mb-3"><label class="small fw-bold text-danger">New Password</label><input type="text" id="edit-user-password" class="form-control form-control-sm" placeholder="Leave blank to keep current"></div>
<div class="row">
<div class="col-6 mb-2">
<label class="small fw-bold" data-i18n="job">Job</label>
<select id="edit-user-job" class="form-select form-select-sm">
<option value="Sonderreiniger">Sonderreiniger</option>
<option value="Springer">Springer</option>
<option value="Objektleiter">Objektleiter</option>
</select>
</div>
<div class="col-6 mb-2">
<label class="small fw-bold" data-i18n="role">Role</label>
<select id="edit-user-role" class="form-select form-select-sm">
<option value="user">Worker</option>
<option value="admin">Admin</option>
</select>
</div>
</div>
</div>
<div class="modal-footer d-flex justify-content-between">
<button type="button" class="btn btn-danger btn-sm" onclick="deleteUserAccount()" data-i18n="delete">🗑️ Delete</button>
<div>
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-i18n="cancel">Cancel</button>
<button type="button" class="btn btn-primary btn-sm" id="btn-save-user-edit" onclick="saveUserEdit()" data-i18n="save_changes">Save</button>
</div>
</div>
</div>
</div>
</div>

<!-- Report View Modal -->
<div class="modal fade" id="reportViewModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header bg-success text-white"><h5 class="modal-title">✅ <span data-i18n="report_final_title">Raport Finalizare</span></h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div>
<div class="modal-body text-center">
<img id="rep-avatar" src="" class="report-avatar mb-2">
<h6 id="rep-task-title" class="fw-bold"></h6>
<p class="small text-muted"><span data-i18n="completed_by">Finalizat de</span>: <span id="rep-user" class="fw-bold text-dark"></span></p>
<div class="card bg-light mb-2 p-2 small border text-start">
<strong class="text-secondary d-block mb-1" data-i18n="comment">Comentariu:</strong>
<span id="rep-comment" class="fs-6"></span>
</div>
<img id="rep-img" class="img-fluid rounded border shadow-sm mt-2" style="display:none; max-height: 300px; cursor: pointer;" onclick="window.open(this.src)">
</div>
<div class="modal-footer justify-content-between">
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-i18n="close_btn">Închide</button>
<button type="button" class="btn btn-success btn-sm" onclick="generateReportPDF()">
    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="me-1" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708z"/></svg>
    <span data-i18n="download_pdf">Download PDF</span>
</button>
</div>
</div>
</div>
</div>

<!-- View Images Modal -->
<div class="modal fade" id="viewImagesModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content bg-transparent border-0"><div class="modal-body text-center" id="images-container"></div></div></div></div>

<!-- Archive Modal -->
<div class="modal fade" id="archiveModal" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header bg-secondary text-white"><h5 class="modal-title">🗄️ <span data-i18n="archive">Archive</span></h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body"><table class="table table-hover table-sm small"><thead><tr><th data-i18n="task">Task</th><th data-i18n="date">Date</th><th data-i18n="by">By</th><th>Actions</th></tr></thead><tbody id="archive-table-body"></tbody></table></div></div></div></div>

<!-- Profile Image Popout Modal -->
<div class="modal fade" id="profileImageModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content bg-transparent border-0">
<div class="modal-body text-center p-0">
<button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
<img id="profile-img-popout" src="" class="img-fluid rounded shadow-lg" style="max-height: 80vh;">
</div>
</div>
</div>
</div>

<!-- Calendar Popout (Non-Bootstrap Custom Popout) -->
<div id="calendar-popout">
<span class="btn-close-custom" onclick="closeCalPopup()">✕</span>
<h5 id="pop-title"></h5>
<p class="small text-warning" id="pop-time"></p>
<div id="pop-assign" class="small text-start"></div>
<button class="btn btn-sm btn-outline-light mt-3 w-100" id="pop-action-btn">Edit</button>
</div>

<!-- View Task Details Modal (Ochiul) -->
<div class="modal fade" id="viewTaskDetailsModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content border-primary">
<div class="modal-header bg-primary text-white py-2">
<h5 class="modal-title fs-6" data-i18n="view_task_title">👁️ Vizualizare Task</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body">
<h5 id="view-task-title" class="fw-bold mb-3 text-primary"></h5>

<div class="row mb-2 small border-bottom pb-2">
<div class="col-6"><strong class="text-muted" data-i18n="status">Status</strong>:<br><span id="view-task-status"></span></div>
<div class="col-6"><strong class="text-muted" data-i18n="priority">Prioritate</strong>:<br><span id="view-task-priority" class="badge bg-secondary"></span></div>
</div>

<div class="row mb-3 small border-bottom pb-2">
<div class="col-6"><strong class="text-muted" data-i18n="deadline">Fristdatum</strong>:<br><span id="view-task-deadline" class="fw-bold"></span></div>
<div class="col-6"><strong class="text-muted" data-i18n="assigned_to">Atribuit lui</strong>:<br><span id="view-task-assigned" class="fw-bold"></span></div>
</div>

<div class="mb-3 small">
<strong class="text-muted" data-i18n="req_label">Necesar</strong>:<br>
<span id="view-task-reqs" class="text-info fw-bold"></span>
</div>

<div class="mb-3 small">
<strong class="text-muted" data-i18n="desc">Beschreibung</strong>:
<!-- Am adăugat clasa rich-text-content aici -->
<div id="view-task-desc" class="p-2 bg-light border rounded mt-1 rich-text-content" style="white-space: normal;"></div>
</div>

<div class="mb-2 small">
<strong class="text-muted" data-i18n="images">Imagini atașate inițial</strong>:
<div id="view-task-images" class="mt-2 d-flex flex-wrap gap-2"></div>
</div>
</div>
<div class="modal-footer py-1">
<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-i18n="close_btn">Închide</button>
</div>
</div>
</div>
</div>