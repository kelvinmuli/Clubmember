<?php
    $petitionTitle = !empty($petitionRow->name) ? $petitionRow->name : 'Petition';
    $createdAt = !empty($petitionRow->created_at) ? date('d M Y H:i', strtotime($petitionRow->created_at)) : 'N/A';
    $closingAt = !empty($petitionRow->closing_at) ? date('d M Y H:i', strtotime($petitionRow->closing_at)) : 'Open';
    $lastSigned = !empty($latestSignedAt) ? date('d M Y H:i', strtotime($latestSignedAt)) : 'N/A';
?>

<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
        <style>
            @media print {
                body * { visibility: hidden; }
                #petition-signatures-html, #petition-signatures-html * { visibility: visible; }
                .modal-header, .modal-footer { display: none !important; }
                #petition-signatures-html { position: absolute; left: 0; top: 0; width: 100%; }
                .modal-dialog { max-width: 100% !important; margin: 0 !important; }
                .modal-content { border: 0 !important; box-shadow: none !important; }
            }
        </style>
        <div class="modal-header">
            <h5 class="modal-title">Export HTML Summary</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div id="petition-signatures-html" class="modal-body">
            <div class="mb-3">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <h3 class="mb-0 me-2"><?=$petitionTitle?></h3>
                    <?php
                        $activeValue = isset($petitionRow->active) ? (int) $petitionRow->active : -1;
                        $statusName = get_table('m_active', 'num', $activeValue, 'name');
                        $statusClass = ($activeValue === 1) ? 'bg-green-lt' : (($activeValue === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
                    ?>
                    <span class="badge <?=$statusClass?>">Status: <?=$statusName ?: 'N/A'?></span>
                </div>
				<div><?=$petitionRow->description ?? ''?></div>
                <div class="text-muted small">Created: <?=$createdAt?> · Closing: <?=$closingAt?></div>
                <div class="text-muted small mt-1">Summary of members who have signed.</div>
            </div>

            <div class="table-responsive">
                <table class="table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th class="w-1">#</th>
                            <th>Member Name</th>
                            <th>Phone Number</th>
                            <th>Signature</th>
                            <th>Signed At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($members)): ?>
                            <?php $i = 0; foreach ($members as $m): ?>
                                <tr>
                                    <td><?=++$i?>.</td>
                                    <td><?=$m['full_legal_name'] ?? ''?></td>
                                    <td><?=$m['phone_number'] ?? ''?></td>
                                    <td>
                                        <?php if (!empty($m['signature_url'])): ?>
                                            <img src="<?=htmlspecialchars($m['signature_url'], ENT_QUOTES, 'UTF-8')?>" alt="Signature of <?=htmlspecialchars($m['full_legal_name'] ?? '', ENT_QUOTES, 'UTF-8')?>" style="max-height: 100px; max-width: 200px; border: 1px solid #ccc;"/>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($m['signed_at'])): ?>
                                            <?=date('d M Y H:i', strtotime($m['signed_at']))?>
                                        <?php else: ?>
                                            <span class="text-muted">N/A</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">No members have signed this petition yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="window.print();">Print</button>
        </div>
    </div>
</div>
