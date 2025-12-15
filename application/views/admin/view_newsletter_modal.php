<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">View Newsletter</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<?php if (!empty($newsletterRow)): ?>
			<div class="modal-body">
				<div class="row g-4 align-items-start">
					<div class="col-md-4 text-center">
						<?php
							$thumbnailSrc = base_url('assets/admin/images/no-image.png');
							if (!empty($newsletterRow->thumbnail_url) && check_file_exists($newsletterRow->thumbnail_url)) {
								$thumbnailSrc = base_url($newsletterRow->thumbnail_url);
							}

							$fileSrc = base_url('assets/admin/images/no-file.png');
							if (!empty($newsletterRow->file_url) && check_file_exists($newsletterRow->file_url)) {
								$fileSrc = base_url($newsletterRow->file_url);
							}
						?>
						<img src="<?=$thumbnailSrc?>" alt="Newsletter thumbnail" class="img-fluid rounded border">
						<?php if (!empty($newsletterRow->file_url)): ?>
							<div class="mt-3">
								<a class="btn btn-sm btn-outline-primary" href="<?=$fileSrc?>" target="_blank" rel="noopener">Download File</a>
							</div>
						<?php endif; ?>
					</div>
					<div class="col-md-8">
						<dl class="row mb-0">
							<dt class="col-sm-4 text-secondary">Title</dt>
							<dd class="col-sm-8 fw-medium"><?=$newsletterRow->name ?? 'N/A'?></dd>

							<dt class="col-sm-4 text-secondary">Description</dt>
							<dd class="col-sm-8"><?=$newsletterRow->description ?? 'No description provided.'?></dd>

							<dt class="col-sm-4 text-secondary">Status</dt>
							<dd class="col-sm-8">
								<?php
									$statusName = get_table('m_active', 'num', $newsletterRow->active, 'name');
									$activeValue = (int) ($newsletterRow->active ?? -1);
									$statusClass = ($activeValue === 1) ? 'bg-green-lt' : (($activeValue === 0) ? 'bg-red-lt' : 'bg-yellow-lt');
								?>
								<span class="badge <?=$statusClass?>"><?=$statusName?></span>
							</dd>

							<dt class="col-sm-4 text-secondary">Created At</dt>
							<dd class="col-sm-8"><?=!empty($newsletterRow->created_at) ? date('d M Y H:i', strtotime($newsletterRow->created_at)) : 'N/A'?></dd>
						</dl>
					</div>
				</div>
			</div>
		<?php else: ?>
			<div class="modal-body">
				<p class="text-secondary mb-0">The requested newsletter could not be found.</p>
			</div>
		<?php endif; ?>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
