<?php
    $incidentRow = $incidentRow ?? null;
    $incidentId = $incidentRow ? ($incidentRow->security_incident_id ?? '') : ($security_incident_id ?? '');
    $location = $incidentRow ? ($incidentRow->location ?? 'this incident') : 'this incident';
?>
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Remove Security Incident</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?=base_url('remove-security-incident')?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="security_incident_id" value="<?=htmlspecialchars($incidentId, ENT_QUOTES, 'UTF-8')?>">
                <p>Are you sure you want to remove the incident reported at <strong><?=htmlspecialchars($location, ENT_QUOTES, 'UTF-8')?></strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Remove</button>
            </div>
        </form>
    </div>
</div>
