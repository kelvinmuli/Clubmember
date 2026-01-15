<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">View Newsletter</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<?php if (!empty($newsletterRow)): ?>
			<div class="modal-body">
				<div class="row g-4">
					<div class="col-md-12">						
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
						<label class="form-label">Title</label>
						<p class="fw-medium"><?=$newsletterRow->name ?? 'N/A'?></p>
						<img src="<?=$thumbnailSrc?>" alt="Newsletter thumbnail" class="img-fluid rounded border">
						<label class="form-label">Summary</label>
						<p class="fw-medium"><?=$newsletterRow->summary ?? 'N/A'?></p>
						<label class="form-label">Description</label>
						<p class="fw-medium"><?=$newsletterRow->description ?? 'N/A'?></p>
						<label class="form-label">File</label>
						<p class="fw-medium">
							<?php if (!empty($newsletterRow->file_url) && check_file_exists($newsletterRow->file_url)): ?>
								<a href="<?=base_url($newsletterRow->file_url)?>" target="_blank" rel="noopener"><?=basename($newsletterRow->file_url)?></a>
							<?php else: ?>
								No Attached File
							<?php endif; ?>
						</p>
						<dl class="row mb-0">
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
