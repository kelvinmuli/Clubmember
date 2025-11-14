<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">View Subscription</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php if (!empty($subscriptionRow)): ?>
            <?php
                $member = $memberRow ?? null;
                $memberName = isset($member->full_legal_name) && $member->full_legal_name !== '' ? $member->full_legal_name : 'Unknown Member';
                $memberEmail = isset($member->email) && $member->email !== '' ? $member->email : 'Not provided';
                $memberPhone = isset($member->phone_number) && $member->phone_number !== '' ? $member->phone_number : 'Not provided';
                $feeTypeLabel = isset($membershipFeeTypeName) && $membershipFeeTypeName !== '' ? $membershipFeeTypeName : 'Not specified';
                $currencySign = isset($currencySign) ? $currencySign : '';
                $currencyName = isset($currencyName) ? $currencyName : '';
                $currencyPrefix = $currencySign !== '' ? $currencySign : ($currencyName !== '' ? $currencyName : '');
                $subscriptionAmount = isset($subscriptionRow->amount) ? (float) $subscriptionRow->amount : 0.00;
                $paymentHistory = isset($paymentHistoryRow) ? $paymentHistoryRow : null;
                $billAmount = $paymentHistory && isset($paymentHistory->bill_amount) ? (float) $paymentHistory->bill_amount : $subscriptionAmount;
                $paidAmount = $paymentHistory && isset($paymentHistory->paid_amount) ? (float) $paymentHistory->paid_amount : 0.00;
                $balanceAmount = $billAmount - $paidAmount;
                $startAt = !empty($subscriptionRow->start_at) ? date('d M Y', strtotime($subscriptionRow->start_at)) : 'Not set';
                $dueAt = !empty($subscriptionRow->due_at) ? date('d M Y', strtotime($subscriptionRow->due_at)) : 'Not set';
                if (!empty($subscriptionRow->payment_at)) {
                    $paymentAt = date('d M Y', strtotime($subscriptionRow->payment_at));
                } elseif ($paymentHistory && !empty($paymentHistory->payment_at)) {
                    $paymentAt = date('d M Y', strtotime($paymentHistory->payment_at));
                } else {
                    $paymentAt = 'Not recorded';
                }
                $createdAt = !empty($subscriptionRow->created_at) ? date('d M Y H:i', strtotime($subscriptionRow->created_at)) : 'Not recorded';
                $updatedAt = !empty($subscriptionRow->updated_at) ? date('d M Y H:i', strtotime($subscriptionRow->updated_at)) : 'Never updated';
                $statusName = isset($paymentStatusName) && $paymentStatusName !== '' ? $paymentStatusName : 'Not recorded';
                $statusClass = isset($paymentStatusClass) && $paymentStatusClass !== '' ? $paymentStatusClass : 'bg-blue-lt';
                $methodName = isset($paymentMethodName) && $paymentMethodName !== '' ? $paymentMethodName : 'Not recorded';
                $transactionCode = $paymentHistory && !empty($paymentHistory->transaction_code) ? $paymentHistory->transaction_code : 'Not provided';
                $subscriptionRemark = isset($subscriptionRow->remark) ? trim($subscriptionRow->remark) : '';
                $paymentRemark = $paymentHistory && isset($paymentHistory->remark) ? trim($paymentHistory->remark) : '';
                $balanceClass = $balanceAmount <= 0 ? 'text-green' : 'text-red';
                $formatAmount = function ($value) use ($currencyPrefix) {
                    $numericValue = is_numeric($value) ? (float) $value : 0.00;
                    $formatted = number_format($numericValue, 2);
                    return $currencyPrefix !== '' ? $currencyPrefix . ' ' . $formatted : $formatted;
                };
            ?>

            <div class="modal-body">
                <div class="row g-3 align-items-start">
                    <div class="col-md-8">
                        <h3 class="mb-1"><?=$memberName?></h3>
                        <div class="text-muted small mb-2">Subscription type: <?=$feeTypeLabel?></div>
                        <div class="d-flex flex-column flex-md-row gap-2 mb-2 small text-muted">
                            <span><strong>Email:</strong> <?=$memberEmail?></span>
                            <span><strong>Phone:</strong> <?=$memberPhone?></span>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge bg-purple-lt">Amount: <?=$formatAmount($subscriptionAmount)?></span>
                            <span class="badge <?=$statusClass?>">Status: <?=$statusName?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="border rounded p-3 bg-light">
                            <div class="small text-muted">Bill Amount</div>
                            <div class="fw-semibold fs-5 mb-2"><?=$formatAmount($billAmount)?></div>
                            <div class="d-flex justify-content-between small text-muted">
                                <span>Paid</span>
                                <span><?=$formatAmount($paidAmount)?></span>
                            </div>
                            <div class="d-flex justify-content-between small">
                                <span>Outstanding</span>
                                <span class="fw-semibold <?=$balanceClass?>"><?=$formatAmount($balanceAmount)?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mt-2">
                    <div class="col-md-6">
                        <h6 class="text-secondary text-uppercase fs-11">Schedule</h6>
                        <dl class="row mb-0 small">
                            <dt class="col-5">Start Date</dt>
                            <dd class="col-7"><?=$startAt?></dd>
                            <dt class="col-5">Due Date</dt>
                            <dd class="col-7"><?=$dueAt?></dd>
                            <dt class="col-5">Payment Date</dt>
                            <dd class="col-7"><?=$paymentAt?></dd>
                            <dt class="col-5">Created</dt>
                            <dd class="col-7"><?=$createdAt?></dd>
                            <dt class="col-5">Updated</dt>
                            <dd class="col-7"><?=$updatedAt?></dd>
                        </dl>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-secondary text-uppercase fs-11">Payment Details</h6>
                        <dl class="row mb-0 small">
                            <dt class="col-5">Method</dt>
                            <dd class="col-7"><?=$methodName?></dd>
                            <dt class="col-5">Transaction Code</dt>
                            <dd class="col-7"><?=$transactionCode?></dd>
                            <?php if ($paymentHistory && isset($paymentHistory->currency_id)): ?>
                                <dt class="col-5">Currency</dt>
                                <dd class="col-7"><?=$currencyName !== '' ? $currencyName : ($currencySign !== '' ? $currencySign : 'Not recorded')?></dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>

                <?php if ($subscriptionRemark !== ''): ?>
                    <div class="mt-3">
                        <h6 class="text-secondary text-uppercase fs-11">Subscription Notes</h6>
                        <p class="text-muted small mb-0"><?=nl2br($subscriptionRemark)?></p>
                    </div>
                <?php endif; ?>

                <?php if ($paymentRemark !== ''): ?>
                    <div class="mt-3">
                        <h6 class="text-secondary text-uppercase fs-11">Payment Notes</h6>
                        <p class="text-muted small mb-0"><?=nl2br($paymentRemark)?></p>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="modal-body">
                <p class="text-secondary mb-0">The requested subscription could not be found.</p>
            </div>
        <?php endif; ?>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</div>
