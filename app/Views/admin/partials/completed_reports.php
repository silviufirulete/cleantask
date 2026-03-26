<div class="card shadow-sm border-top border-3 border-success">
    <div class="card-header bg-white py-2 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 text-success">✅ <span data-i18n="completed_reports">Completed Reports</span></h6>
        <button class="btn btn-sm btn-outline-secondary" onclick="openArchiveModal()">🗄️ <span data-i18n="archive">Archive</span></button>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light small">
                    <tr>
                        <th style="width:30%" data-i18n="task">Task</th>
                        <th data-i18n="date">Date</th>
                        <th data-i18n="by">By</th>
                        <th class="text-end" data-i18n="actions">Actions</th>
                    </tr>
                </thead>
                <tbody id="done-tasks-body" class="small"></tbody>
            </table>
        </div>
    </div>
</div>