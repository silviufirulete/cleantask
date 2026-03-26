<div class="card shadow-sm mb-4">
    <div class="card-header bg-white py-2 border-top border-3 border-primary d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-primary">📋 <span data-i18n="active_tasks">Active Tasks</span></h6>
        <div class="d-flex align-items-center gap-2">
            <label class="small mb-0 text-muted" data-i18n="sort_by">Sort:</label>
            <select id="task-sort-filter" class="form-select form-select-sm" style="width: auto;" onchange="applySortFilter()">
                <option value="newest" data-i18n="sort_newest">Newest First</option>
                <option value="oldest" data-i18n="sort_oldest">Oldest First</option>
                <option value="name" data-i18n="sort_name">By Name (A-Z)</option>
            </select>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light small">
                    <tr>
                        <th style="width:25%" data-i18n="task">Task</th>
                        <th data-i18n="req_label">Necesar</th>
                        <th data-i18n="assigned_to">Assigned</th>
                        <th data-i18n="created_by_date">Created By/Date</th>
                        <th data-i18n="status">Status</th>
                        <th class="text-end" data-i18n="actions">Actions</th>
                    </tr>
                </thead>
                <tbody id="active-tasks-body" class="small"></tbody>
            </table>
        </div>
    </div>
</div>