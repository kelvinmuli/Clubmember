<?php
    $isEdit = isset($incidentRow);
    $modalTitle = $isEdit ? 'Edit Security Incident' : 'Add Security Incident';
    $securityIncidentId = $isEdit ? ($incidentRow->security_incident_id ?? '') : ($security_incident_id ?? generate_uuid());
    $incidentTypeData = $incidentTypeData ?? [];
    $activeData = $activeData ?? [];
    $incidentAtValue = $isEdit && !empty($incidentRow->incident_at) ? date('d M Y', strtotime($incidentRow->incident_at)) : '';
    $locationValue = $isEdit ? ($incidentRow->location ?? '') : '';
    $reportedByValue = $isEdit ? ($incidentRow->reported_by ?? '') : '';
    $typeValue = $isEdit ? ($incidentRow->incident_type_id ?? '') : '';
    $statusValue = $isEdit ? ($incidentRow->incident_status_id ?? '') : '';
    $descriptionValue = $isEdit ? ($incidentRow->description ?? '') : '';
    $activeValue = $isEdit && isset($incidentRow->active) ? (string) $incidentRow->active : '';
?>

<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?=$modalTitle?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?=base_url($isEdit ? 'edit-security-incident' : 'add-security-incident')?>" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="security_incident_id" value="<?=$securityIncidentId?>">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="security_incident_location">Location</label>
                        <input type="text" class="form-control" id="security_incident_location" name="location" value="<?=$locationValue?>" placeholder="Incident location" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="security_incident_reported_by">Reported By</label>
                        <input type="text" class="form-control" id="security_incident_reported_by" name="reported_by" value="<?=$reportedByValue?>" placeholder="Reporter name or contact">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="security_incident_at">Incident Date &amp; Time</label>
                        <input type="datetime-local" class="form-control" id="security_incident_at" name="incident_at" value="<?=$incidentAtValue?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="incident_type_id">Incident Type</label>
                        <select class="form-select" id="incident_type_id" name="incident_type_id">
                            <option value="N/A" selected>Select Incident Type</option>
                            <?php foreach ($incidentTypeData as $incidentType): ?>
								<option value="<?=$incidentType->incident_type_id?>" <?=$isEdit ? ($incidentType->incident_type_id == $typeValue ? 'selected' : '') : ''?>><?=$incidentType->name?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="mb-3 mt-3">
                    <label class="form-label" for="security_incident_description">Description</label>
                    <textarea class="form-control" id="security_incident_description" name="description" rows="4" placeholder="Describe what happened..."><?=$descriptionValue?></textarea>
                </div>

                <div class="mb-0">
                    <label class="form-label" for="security_incident_active">Status</label>
                    <select class="form-select" id="security_incident_active" name="incident_status_id" required>
                        <option value="N/A" selected disabled>Select Status</option>
                        <?php foreach ($incidentStatusData as $status): ?>
                            <option value="<?=$status->incident_status_id?>" <?=$isEdit ? ($status->incident_status_id == $statusValue ? 'selected' : '') : ''?>><?=$status->name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
