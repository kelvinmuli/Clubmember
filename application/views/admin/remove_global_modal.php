	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Remove <?=$name?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form method="post" action="<?=base_url('remove-global-data')?>">
				<input type="hidden" name="table" value="<?=$table?>">
				<input type="hidden" name="table_id" value="<?=$table_id?>">
				<input type="hidden" name="unique_id" value="<?=$unique_id?>">
				<input type="hidden" name="route" value="<?=$route?>">
				<div class="modal-body">
					<h4 class="text-danger">Warning!</h4>
					<p>Are you sure you want to remove this <?=$name?></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-danger">Remove</button>
				</div>
			</form>
		</div>
	</div>