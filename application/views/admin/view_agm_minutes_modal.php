<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">View AGM Minutes</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<?php if (!empty($agmMinutesRow)): ?>
			<div class="modal-body">
				<div class="row g-4">
					<div class="col-md-12">
						<dl class="row mb-0">
							<dt class="col-sm-4 text-secondary">Title</dt>
							<dd class="col-sm-8 fw-medium"><?=$agmMinutesRow->name ?? 'N/A'?></dd>

							<dt class="col-sm-4 text-secondary">Description</dt>
							<dd class="col-sm-8"><?=$agmMinutesRow->description ?? 'No description provided.'?></dd>

							<dt class="col-sm-4 text-secondary">Dated At</dt>
							<dd class="col-sm-8"><?=!empty($agmMinutesRow->date_at) ? date('d M Y', strtotime($agmMinutesRow->date_at)) : 'N/A'?></dd>

							<dt class="col-sm-4 text-secondary">Status</dt>
							<dd class="col-sm-8">
								<?php
									$activeValue = (int) ($agmMinutesRow->active ?? -1);
									$statusName = get_table('m_active', 'num', $activeValue, 'name');
									$statusClass = ($activeValue === 1) ? 'bg-green-lt' : (($activeValue === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
								?>
								<span class="badge <?=$statusClass?>"><?=$statusName?></span>
							</dd>

							<dt class="col-sm-4 text-secondary">Created At</dt>
							<dd class="col-sm-8"><?=!empty($agmMinutesRow->created_at) ? date('d M Y', strtotime($agmMinutesRow->created_at)) : 'N/A'?></dd>

							<dt class="col-sm-4 text-secondary">Document</dt>
							<dd class="col-sm-8">
								<?php if (!empty($agmMinutesRow->doc_url) && check_file_exists($agmMinutesRow->doc_url)): ?>
									<a href="<?=base_url($agmMinutesRow->doc_url)?>" class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener">View Document</a>
								<?php else: ?>
									<span class="text-muted">Not uploaded</span>
								<?php endif; ?>
							</dd>
						</dl>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="modal-body">
				<p class="text-secondary mb-0">The requested AGM minutes could not be found.</p>
			</div>
		<?php endif; ?>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
