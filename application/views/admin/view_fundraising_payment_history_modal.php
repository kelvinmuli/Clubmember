<?php
$payments = $payments ?? [];
$totalPaid = isset($totalPaid) ? (float) $totalPaid : 0.0;
$currencyLabel = '';
foreach ($payments as $entry) {
    if (!empty($entry->currency_sign)) {
        $currencyLabel = (string) $entry->currency_sign;
        break;
    }
    if (!empty($entry->currency_name)) {
        $currencyLabel = (string) $entry->currency_name;
        break;
    }
}
$formatAmount = function ($value) use ($currencyLabel) {
    $numericValue = is_numeric($value) ? (float) $value : 0.0;
    $formatted = number_format($numericValue, 2);
    return $currencyLabel !== '' ? $currencyLabel . ' ' . $formatted : $formatted;
};
$formatDateTime = function ($value) {
    if (empty($value) || $value === '0000-00-00' || $value === '0000-00-00 00:00:00') {
        return 'N/A';
    }
    $timestamp = strtotime($value);
    return $timestamp ? date('d M Y', $timestamp) : (string) $value;
};
$getStatusBadge = function ($status) {
    if (empty($status)) {
        return 'bg-blue-lt';
    }
    $status = strtolower($status);
    if (strpos($status, 'paid') !== false || strpos($status, 'completed') !== false) {
        return 'bg-green-lt';
    }
    if (strpos($status, 'pending') !== false || strpos($status, 'in progress') !== false) {
        return 'bg-yellow-lt';
    }
    if (strpos($status, 'failed') !== false || strpos($status, 'declined') !== false || strpos($status, 'cancel') !== false) {
        return 'bg-red-lt';
    }
    return 'bg-blue-lt';
};
?>
<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?=$fundraisingRow->name?> Fundraising Contributions</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <?php if (!empty($payments)): ?>
                <div class="mb-3">
                    <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2">
                        <div class="fw-semibold">Total Recorded Contributions:</div>
                        <div class="badge bg-green-lt text-green fw-semibold"><?=$formatAmount($totalPaid)?></div>
                        <div class="text-muted small ms-sm-auto">Entries: <?=count($payments)?></div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
								<th>Name</th>
                                <th class="text-end">Bill</th>
                                <th class="text-end">Paid</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($payments as $payment): ?>
                                <?php
                                    $billAmount = isset($payment->bill_amount) ? $payment->bill_amount : null;
                                    $paidAmount = isset($payment->paid_amount) ? $payment->paid_amount : null;
                                    $effectiveAmount = ($paidAmount !== null && $paidAmount !== '' && (float) $paidAmount > 0)
                                        ? $paidAmount
                                        : $billAmount;
                                    $statusName = isset($payment->status_name) ? $payment->status_name : '';
                                    $badgeClass = $getStatusBadge($statusName);
                                    $methodName = isset($payment->method_name) && $payment->method_name !== ''
                                        ? $payment->method_name
                                        : 'Not recorded';
                                    $transactionRef = isset($payment->transaction_code) && $payment->transaction_code !== ''
                                        ? $payment->transaction_code
                                        : (isset($payment->reference_no) ? $payment->reference_no : '—');
                                    $remark = isset($payment->remark) ? trim($payment->remark) : '';
                                    $createdAtValue = isset($payment->created_at) ? $payment->created_at : null;
                                    $displayDate = !empty($payment->payment_at)
                                        ? $formatDateTime($payment->payment_at)
                                        : $formatDateTime($createdAtValue);
                                ?>
                                <tr>
                                    <td><?=$displayDate?></td>
									<td><?=get_table($customerDBSettingRow->database_name.'.user', 'user_id', $payment->user_id, 'full_legal_name')?></td>
                                    <td class="text-end"><?=$billAmount !== null ? $formatAmount($billAmount) : '—'?></td>
                                    <td class="text-end"><?=$effectiveAmount !== null ? $formatAmount($effectiveAmount) : '—'?></td>
                                    <td>
                                        <span class="badge <?=$badgeClass?>">
                                            <?=$statusName !== '' ? $statusName : 'Not recorded'?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center text-muted py-4">
                    <p class="mb-1">No contributions recorded for this fundraising campaign yet.</p>
                    <p class="small mb-0">Use the Add Contribution option to capture payments.</p>
                </div>
            <?php endif; ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
