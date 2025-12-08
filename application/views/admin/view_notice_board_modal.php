<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title"><?=$noticeRow->name ?? 'Notice'?></h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<?php if (empty($noticeRow)): ?>
				<div class="alert alert-warning">Notice not found.</div>
			<?php else: ?>
				<div class="mb-3 text-muted small">Posted: <?php echo !empty($noticeRow->created_at) ? date('d M Y H:i', strtotime($noticeRow->created_at)) : 'N/A'; ?></div>
				<?php $thumbnail = trim($noticeRow->thumbnail_url ?? ''); $thumbnailSrc = $thumbnail ? (filter_var($thumbnail, FILTER_VALIDATE_URL) ? $thumbnail : base_url($thumbnail)) : ''; ?>
				<?php if ($thumbnailSrc && function_exists('check_file_exists') && check_file_exists($thumbnail, true)): ?>
					<div class="mb-3 text-center">
						<img src="<?=$thumbnailSrc?>" alt="<?=$noticeRow->name ?? ''?>" class="img-fluid rounded">
					</div>
				<?php endif; ?>

				<div class="mb-3">
					<p><?php echo nl2br($noticeRow->description ?? ''); ?></p>
				</div>

				<?php if (!empty($noticeRow->attachment_url)): ?>
					<?php $attachmentSrc = filter_var($noticeRow->attachment_url, FILTER_VALIDATE_URL) ? $noticeRow->attachment_url : base_url($noticeRow->attachment_url); ?>
					<div class="mt-3">
						<a class="btn btn-sm btn-outline-primary" href="<?=$attachmentSrc?>" target="_blank" rel="noopener">Download Attachment</a>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		</div>
	</div>
</div>
