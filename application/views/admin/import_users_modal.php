<?php
    $userTypeId = $user_type_id ?? GlobalModel::MEMBER_TYPE;
    $customerDbSettingId = $customer_db_setting_id ?? '';
    $membershipTypeId = $membership_type_id ?? '';
    $templateUrl = $template_url ?? base_url('download-user-import-template');
?>
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Import Users</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="<?=base_url('import-users')?>" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <p class="text-secondary mb-3">Download the CSV template, fill in the fields, then upload it here.</p>
                <div class="mb-3">
                    <a class="btn btn-outline-primary btn-pill" href="<?=$templateUrl?>" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5v9" /><path d="M9 8l3 3l3 -3" /><path d="M5 19h14" /></svg>
                        Download CSV Template
                    </a>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="import_file">CSV File</label>
                    <input type="file" class="form-control" id="import_file" name="import_file" accept=".csv" required>
                    <div class="form-text">Columns: user_id, full_legal_name, phone_number, street_name, email, birth, id_no, residential_address, postal_address, postal_code, town_id, city_id, password, membership_no, contact_name, contact_phone_no, sub_reference_no</div>
                </div>
                <input type="hidden" name="user_type_id" value="<?=$userTypeId?>">
                <input type="hidden" name="customer_db_setting_id" value="<?=$customerDbSettingId?>">
                <input type="hidden" name="membership_type_id" value="<?=$membershipTypeId?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Import Users</button>
            </div>
        </form>
    </div>
</div>
