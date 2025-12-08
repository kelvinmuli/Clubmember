<?php
    $campaignRow = $fundraisingRow ?? null;
    $campaignName = $campaignRow && !empty($campaignRow->name) ? $campaignRow->name : 'this fundraising campaign';
?>

<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Delete Fundraising</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?=base_url('delete-fundraising')?>" method="POST">
            <div class="modal-body">
                <input type="hidden" name="fundraising_id" value="<?=$fundraising_id ?? ''?>">
                <p class="mb-0">Are you sure you want to delete <strong><?=$campaignName?></strong>? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>
