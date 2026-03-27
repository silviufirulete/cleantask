<!-- Create Task Section (Centered for standalone view) -->
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-6 mb-4">
        <div class="card shadow border-success h-100">
            <div class="card-header bg-success text-white py-2">
                <h5 class="mb-0 fs-6">➕ <span data-i18n="create_task">New Task</span></h5>
            </div>
            <div class="card-body bg-light">
                <form id="create-task-form">
                    <div class="mb-2">
                        <label class="small fw-bold" data-i18n="title">Title</label>
                        <input type="text" id="task-title" class="form-control form-control-sm" required>
                    </div>
                    
                    <div class="mb-2 p-2 border rounded bg-white">
                        <label class="small fw-bold mb-1" data-i18n="req_label">Requirements:</label>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check"><input class="form-check-input req-check" type="checkbox" value="mopp" id="req-mopp"><label class="form-check-label small" for="req-mopp" data-i18n="req_mopp">Mopp</label></div>
                            <div class="form-check"><input class="form-check-input req-check" type="checkbox" value="tuch" id="req-tuch"><label class="form-check-label small" for="req-tuch" data-i18n="req_tuch">Tücher</label></div>
                            <div class="form-check"><input class="form-check-input req-check" type="checkbox" value="mittel" id="req-mittel"><label class="form-check-label small" for="req-mittel" data-i18n="req_mittel">Mittel</label></div>
                            <div class="form-check"><input class="form-check-input req-check" type="checkbox" value="other" id="req-sonstige" onchange="toggleDescRequired()"><label class="form-check-label small" for="req-sonstige" data-i18n="req_other">Sonstige</label></div>
                        </div>
                        <div id="req-other-container" class="mt-2 d-none">
                            <input type="text" id="req-other-desc" class="form-control form-control-sm" data-i18n-placeholder="req_other_placeholder" placeholder="Describe what is needed...">
                        </div>
                    </div>

                    <!-- EDITOR RICH TEXT AICI -->
                    <div class="mb-2">
                        <label class="small fw-bold" data-i18n="desc">Beschreibung</label>
                        <div id="task-desc-editor"></div>
                    </div>
                    
                    <div class="mb-2 mt-3">
                        <label class="small fw-bold" data-i18n="images">Images</label>
                        <input type="file" id="task-images" class="form-control form-control-sm" accept="image/*" multiple>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="small fw-bold" data-i18n="priority">Priority</label>
                            <select id="task-priority" class="form-select form-select-sm">
                                <option value="low">Low 🟢</option>
                                <option value="medium" selected>Medium 🟡</option>
                                <option value="high">High 🔴</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="small fw-bold" data-i18n="deadline">Deadline</label>
                            <div class="input-group input-group-sm">
                                <input type="date" id="task-date" class="form-control" required>
                                <select id="task-hour" class="form-select" style="max-width: 90px;"></select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3 p-3 bg-white rounded border">
                        <label class="small fw-bold mb-2" data-i18n="assign">Assign to:</label>
                        <div class="d-flex gap-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="assignType" value="global" id="assign-global" checked onchange="toggleUserSelect('create')"> 
                                <label class="form-check-label" for="assign-global" data-i18n="global_assign">Global</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="assignType" value="specific" id="assign-specific" onchange="toggleUserSelect('create')"> 
                                <label class="form-check-label" for="assign-specific" data-i18n="specific_assign">Specific</label>
                            </div>
                        </div>
                        <div id="create-worker-container" class="mt-2 d-none worker-select-box">
                            <div id="create-worker-checkboxes" class="ps-1 small text-muted">Loading...</div>
                        </div>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-success btn-lg fw-bold shadow-sm" id="btn-save-task" data-i18n="save_task">SAVE TASK</button>
                    </div>
                    <div id="upload-progress" class="progress mt-3 d-none" style="height:8px;">
                        <div class="progress-bar bg-warning progress-bar-striped progress-bar-animated" style="width:100%">Uploading...</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>