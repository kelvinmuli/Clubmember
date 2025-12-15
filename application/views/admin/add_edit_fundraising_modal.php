<?php
    $isEdit = isset($fundraisingRow) && is_object($fundraisingRow);
    $existingRow = $isEdit ? $fundraisingRow : null;
    $existingName = ($existingRow && isset($existingRow->name)) ? $existingRow->name : '';
    $modalTitle = $isEdit ? 'Edit ' . (!empty($existingName) ? $existingName : 'Fundraising Campaign') : 'Add Fundraising Campaign';
    $fundraisingId = !empty($fundraising_id) ? $fundraising_id : (($existingRow && isset($existingRow->fundraising_id)) ? $existingRow->fundraising_id : generate_uuid());
    $goalAmount = ($existingRow && isset($existingRow->total_amount)) ? (float) $existingRow->total_amount : 0;
    $receivedAmount = ($existingRow && isset($existingRow->total_received)) ? (float) $existingRow->total_received : 0;
    $contributors = ($existingRow && isset($existingRow->number_of_contributor)) ? (int) $existingRow->number_of_contributor : 0;
    $startDateValue = ($existingRow && !empty($existingRow->start_date)) ? date('d M Y', strtotime($existingRow->start_date)) : '';
    $endDateValue = ($existingRow && !empty($existingRow->end_date)) ? date('d M Y', strtotime($existingRow->end_date)) : '';
    $reasonValue = ($existingRow && isset($existingRow->reason)) ? $existingRow->reason : '';
    $descriptionValue = ($existingRow && isset($existingRow->description)) ? $existingRow->description : '';
    $topContributorValue = ($existingRow && isset($existingRow->top_contributor)) ? $existingRow->top_contributor : '';
    $updatedAtDisplay = ($existingRow && !empty($existingRow->updated_at)) ? date('d M Y', strtotime($existingRow->updated_at)) : '';
?>

<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?=htmlspecialchars($modalTitle, ENT_QUOTES, 'UTF-8')?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?=base_url('add-fundraising')?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="fundraising_id" value="<?=htmlspecialchars($fundraisingId, ENT_QUOTES, 'UTF-8')?>">
                <input type="hidden" name="is_edit" value="<?=$isEdit ? '1' : '0'?>">

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="fundraising_name">Campaign Name</label>
                        <input type="text" class="form-control" id="fundraising_name" name="name" value="<?=$isEdit ? htmlspecialchars($existingName, ENT_QUOTES, 'UTF-8') : ''?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="fundraising_reason">Reason</label>
                        <input type="text" class="form-control" id="fundraising_reason" name="reason" value="<?=$isEdit ? htmlspecialchars($reasonValue, ENT_QUOTES, 'UTF-8') : ''?>" placeholder="Why are we raising funds?">
                    </div>
                    <div class="col-12">
                        <label class="form-label" for="fundraising_description">Description</label>
                        <textarea class="form-control" id="fundraising_description" name="description" rows="3" placeholder="Provide additional context..."><?=$isEdit ? htmlspecialchars($descriptionValue, ENT_QUOTES, 'UTF-8') : ''?></textarea>
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label" for="fundraising_total_amount">Goal Amount</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="fundraising_total_amount" name="total_amount" value="<?=number_format($goalAmount, 2, '.', '')?>" placeholder="0.00">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="fundraising_total_received">Amount Received</label>
                        <input type="number" step="0.01" min="0" class="form-control" id="fundraising_total_received" name="total_received" value="<?=number_format($receivedAmount, 2, '.', '')?>" placeholder="0.00">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label" for="fundraising_contributors"># Contributors</label>
                        <input type="number" min="0" class="form-control" id="fundraising_contributors" name="number_of_contributor" value="<?=max(0, $contributors)?>" placeholder="0">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label" for="fundraising_start_date">Start Date</label>
                        <input type="date" class="form-control" id="fundraising_start_date" name="start_date" value="<?=$startDateValue?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="fundraising_end_date">End Date</label>
                        <input type="date" class="form-control" id="fundraising_end_date" name="end_date" value="<?=$endDateValue?>">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-md-6">
                        <label class="form-label" for="fundraising_top_contributor">Top Contributor</label>
                        <input type="text" class="form-control" id="fundraising_top_contributor" name="top_contributor" value="<?=$isEdit ? htmlspecialchars($topContributorValue, ENT_QUOTES, 'UTF-8') : ''?>" placeholder="Name of lead supporter">
                    </div>
                    <?php if ($isEdit && !empty($updatedAtDisplay)): ?>
                        <div class="col-md-6">
                            <label class="form-label">Last Updated</label>
                            <div class="form-control-plaintext"><?=$updatedAtDisplay?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Campaign</button>
            </div>
        </form>
    </div>
</div>
