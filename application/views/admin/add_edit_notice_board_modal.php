<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?=isset($noticeRow->name) ? 'Edit '.htmlspecialchars($noticeRow->name, ENT_QUOTES, 'UTF-8') : 'Create Notice'?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="<?=isset($noticeRow->name) ? 'edit-notice-board' : 'add-notice-board'?>" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="notice_board_id" id="notice_board_id" value="<?=$notice_board_id?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Title</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?=isset($noticeRow->name) ? htmlspecialchars($noticeRow->name, ENT_QUOTES, 'UTF-8') : ''?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="thumbnail_url" class="form-label">Thumbnail</label>
                            <input type="file" class="form-control" id="thumbnail_url" name="thumbnail_url">
                            <?php if (isset($noticeRow->thumbnail_url) && !empty($noticeRow->thumbnail_url)): ?>
                                <p class="mt-2">Current Thumbnail: <a href="<?=base_url($noticeRow->thumbnail_url)?>" target="_blank" rel="noopener"><?=basename($noticeRow->thumbnail_url)?></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required><?=isset($noticeRow->description) ? htmlspecialchars($noticeRow->description, ENT_QUOTES, 'UTF-8') : ''?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="attachment_url" class="form-label">Attachment</label>
                            <input type="file" class="form-control" id="attachment_url" name="attachment_url">
                            <?php if (isset($noticeRow->attachment_url) && !empty($noticeRow->attachment_url)): ?>
                                <p class="mt-2">Current Attachment: <a href="<?=base_url($noticeRow->attachment_url)?>" target="_blank" rel="noopener"><?=basename($noticeRow->attachment_url)?></a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="active" class="form-label">Status</label>
                            <select class="form-select" id="active" name="active" required>
                                <option value="N/A" selected disabled>Select Status</option>
                                <?php if (isset($activeData)): foreach ($activeData as $active): ?>
                                    <option value="<?=$active->num?>" <?=isset($noticeRow) && $noticeRow->active == $active->num ? 'selected' : ''?>><?=$active->name?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
</div>
