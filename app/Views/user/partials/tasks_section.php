<!-- === TASKS SECTION (USER) === -->
<div id="section-tasks">
    
    <!-- Bara de Sus (Titlu + Refresh + Sortare) -->
    <div class="d-flex justify-content-between align-items-center mb-3 p-2 bg-white rounded shadow-sm border-top border-3 border-primary">
        
        <div class="d-flex align-items-center gap-2">
            <h6 class="mb-0 text-primary fw-bold">📋 <span data-i18n="active_tasks_title">Active Tasks</span></h6>
            <!-- Noul buton de REFRESH -->
            <button class="btn btn-sm btn-light border text-primary shadow-sm py-0 px-2" onclick="window.applySortFilter()" title="Refresh Tasks">
                🔄
            </button>
        </div>

        <div class="d-flex align-items-center gap-2">
            <select id="task-sort-filter" class="form-select form-select-sm bg-light" style="width: auto;" onchange="window.applySortFilter()">
                <option value="newest" data-i18n="sort_newest">Newest First</option>
                <option value="oldest" data-i18n="sort_oldest">Oldest First</option>
                <option value="deadline" data-i18n="deadline">Deadline</option>
            </select>
        </div>
    </div>

    <!-- Mesaj când nu există nicio sarcină -->
    <div id="no-tasks" class="alert alert-success text-center shadow-sm d-none">
        🎉 <span data-i18n="no_tasks_msg">Nu ai nicio sarcină. Ești la zi!</span>
    </div>

    <!-- Containerul unde JavaScript va introduce Cardurile (Chenarele) -->
    <div id="tasks-container" class="row">
        <div class="text-center w-100 p-4">
            <div class="spinner-border text-primary"></div>
            <p class="mt-2 text-muted small" data-i18n="loading">Loading tasks...</p>
        </div>
    </div>

</div>