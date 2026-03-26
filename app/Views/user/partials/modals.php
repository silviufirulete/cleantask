<!-- MODALS (Report, Events, etc.) -->
<div class="modal fade" id="reportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" data-i18n="report_title">Bericht</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="report-task-id">
                <p class="fw-bold text-primary mb-3" id="report-task-title"></p>
                <div class="mb-3">
                    <label class="fw-bold small" data-i18n="report_action">Aktion</label>
                    <select id="report-status" class="form-select" onchange="toggleReportUI()">
                        <option value="done" selected>Done ✅</option>
                        <option value="note">Note / Delay 📝</option>
                    </select>
                </div>
                
                <!-- ZONA DE POZĂ REPARATĂ (Folosim Label-uri native, fără JS Click pentru funcționare 100% pe telefoane) -->
                <div class="mb-3">
                    <label class="fw-bold small mb-2" data-i18n="report_photo">Foto / Galerie</label>
                    
                    <div class="d-flex gap-2">
                        <!-- Input și Buton pentru CAMERĂ -->
                        <input type="file" id="report-file-camera" style="display:none;" accept="image/*" capture="environment" onchange="window.handleReportFileSelect(this)">
                        <label for="report-file-camera" class="btn btn-outline-primary flex-fill fw-bold py-2 mb-0 text-center" style="cursor: pointer;">📷 Kamera</label>
                        
                        <!-- Input și Buton pentru GALERIE -->
                        <input type="file" id="report-file-gallery" style="display:none;" accept="image/*" onchange="window.handleReportFileSelect(this)">
                        <label for="report-file-gallery" class="btn btn-outline-secondary flex-fill fw-bold py-2 mb-0 text-center" style="cursor: pointer;">🖼️ Galerie</label>
                    </div>

                    <!-- Container de Previzualizare -->
                    <div class="text-center mt-3 d-none" id="report-photo-preview-container">
                        <img id="report-photo-preview" src="" class="img-fluid rounded border shadow-sm" style="max-height: 200px; object-fit: cover;">
                        <br>
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="window.clearReportImage()">🗑️ Foto löschen</button>
                    </div>

                    <div class="progress mt-2 d-none" id="upload-progress" style="height:8px;">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:100%">Wird hochgeladen...</div>
                    </div>
                </div>
                <!-- FINAL ZONA POZĂ -->

                <div id="report-comment-container" class="mb-3">
                    <label class="fw-bold small" id="report-comment-label" data-i18n="report_comment">Kommentar (Optional)</label>
                    <textarea id="report-comment" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-i18n="btn_cancel">Abbrechen</button>
                <button type="button" class="btn btn-primary" id="btn-send-report" onclick="submitReport()" data-i18n="btn_send">Senden</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewImagesModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body text-center" id="images-container"></div>
            <div class="text-center mt-2"><button class="btn btn-light btn-sm" data-bs-dismiss="modal" data-i18n="close">Schließen</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" data-i18n="completed_task">Erledigte Aufgabe</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h5 id="view-h-title" class="fw-bold">Title</h5>
                <p class="text-muted small" id="view-h-date">Date</p>
                <hr>
                <div class="mb-3">
                    <strong data-i18n="comment">Kommentar:</strong>
                    <div id="view-h-comment" class="bg-light p-2 rounded border mt-1">...</div>
                </div>
                <div id="view-h-photo-container" class="text-center d-none">
                    <strong class="d-block mb-2 text-start" data-i18n="proof_photo">Beweisfoto:</strong>
                    <img id="view-h-photo" src="" class="img-fluid rounded border shadow-sm" style="max-height: 300px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-i18n="close">Schließen</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addEventModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" data-i18n="add_event">Termin hinzufügen</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="small fw-bold" data-i18n="event_type">Typ</label>
                    <select id="event-type" class="form-select" onchange="toggleEventFields()">
                        <option value="note">📝 Notiz</option>
                        <option value="appointment">🩺 Termin</option>
                        <option value="vacation">✈️ Urlaub</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold" data-i18n="title">Titel</label>
                    <input type="text" id="event-title" class="form-control" placeholder="Titel">
                </div>
                <div id="field-desc" class="mb-3">
                    <label class="small fw-bold" data-i18n="desc">Beschreibung</label>
                    <textarea id="event-desc" class="form-control" rows="2"></textarea>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label class="small fw-bold" data-i18n="start_date">Startdatum</label>
                        <input type="date" id="event-start-date" class="form-control">
                    </div>
                    <div class="col-6 mb-3" id="field-start-time">
                        <label class="small fw-bold" data-i18n="start_time">Startzeit</label>
                        <input type="time" id="event-start-time" class="form-control">
                    </div>
                </div>
                <div class="row" id="row-end-date">
                    <div class="col-6 mb-3">
                        <label class="small fw-bold" data-i18n="end_date">Enddatum</label>
                        <input type="date" id="event-end-date" class="form-control">
                    </div>
                    <div class="col-6 mb-3" id="field-end-time">
                        <label class="small fw-bold" data-i18n="end_time">Endzeit</label>
                        <input type="time" id="event-end-time" class="form-control">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary w-100" onclick="savePersonalEvent()" data-i18n="btn_save">Speichern</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eventDetailsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="det-event-title">Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="det-event-date" class="text-primary fw-bold mb-2">Date</p>
                <div id="det-event-desc" class="p-2 bg-light border rounded mb-3 text-muted"></div>
                <input type="hidden" id="det-event-id">
            </div>
            <div class="modal-footer" id="det-event-footer">
                <button type="button" class="btn btn-danger btn-sm" onclick="deletePersonalEvent()">🗑️ Löschen</button>
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" data-i18n="close">Schließen</button>
            </div>
        </div>
    </div>
</div>

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