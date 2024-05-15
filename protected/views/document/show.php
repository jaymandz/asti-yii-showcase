<?php
/* @var $this DocumentController */

$this->breadcrumbs=array(
	'Document'=>array('/document'),
	'Show',
);
?>

<div class="btn-group mb-3" role="group">
	<a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/explorer', ['path' => $parentPath]) ?>">
        <span class="bi bi-arrow-90deg-up"></span>
        To folder
    </a>
	<a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/explorer/download',
	  ['id' => $document->id]) ?>">
        <span class="bi bi-download"></span>
        Download
    </a>
	<a class="btn btn-primary" role="button"
	  href="<?= $this->createUrl('/document/edit',
	  ['id' => $document->id]) ?>">
	  	<span class="bi bi-pen"></span>
		Edit
	</a>
</div>

<h3><?= $document->name ?></h3>

<div x-data="{ getNameFromMime }">
	<p x-text="getNameFromMime('<?= $document->mime ?>')"></p>
</div>

<button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal"
  data-bs-target="#commentAddModal">
	Add comment
</button>

<?php if (sizeof($document->comments) > 0): ?>
<ul class="list-group">
<?php foreach ($document->comments as $comment): ?>
<li class="list-group-item">
<div class="row">
    <div class="col-9"><?= $comment->content ?></div>
    <div class="col-2">
        <span class="bi bi-hand-thumbs-up-fill"></span>
        <?= $comment->num_likes ?>
        <span class="bi bi-hand-thumbs-down-fill"></span>
        <?= $comment->num_dislikes ?>
    </div>
    <div class="col">
        <button type="button" class="btn btn-outline-success btn-sm"
          @click="updateComment(<?= $comment->id ?>, 'like')">
            <span class="bi bi-hand-thumbs-up"></span>
        </button>
        <button type="button" class="btn btn-outline-danger btn-sm"
          @click="updateComment(<?= $comment->id ?>, 'dislike')">
            <span class="bi bi-hand-thumbs-down"></span>
        </button>
    </div>
</div>
</li>
<?php endforeach ?>
</ul>
<?php endif ?>

<div class="fade modal" id="commentAddModal">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h5>Add comment</h5>
    </div>
    <div class="modal-body">
        <form method="post" id="commentAddForm"
		  action="<?= $this->createUrl('/comment/store') ?>">
		  	<input type="hidden" name="document_id"
			  value="<?= $document->id ?>">
			<textarea required class="form-control" name="content"
			  placeholder="Enter your comment here." rows="5"
			  style="resize: none"></textarea>
		</form>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="submit" class="btn btn-primary" form="commentAddForm">
            Finish
        </button>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
function updateComment(cmtId, updateType)
{
    fetch("<?= $this->createUrl('/comment/show', ['id' => '']) ?>"+cmtId)
    .then(r => r.json())
    .then(data => {
        var numLikes = data.num_likes + (updateType == 'like' ? 1 : 0)
        var numDislikes = data.num_dislikes + (updateType == 'dislike' ? 1 : 0)

        var formData = new FormData()
        formData.append('document_id', data.document_id)
        formData.append('content', data.content)
        formData.append('num_likes', numLikes)
        formData.append('num_dislikes', numDislikes)

        return fetch(
            "<?= $this->createUrl('/comment/update', ['id' => '']) ?>"+cmtId,
            { method: 'POST', body: formData },
        )
    })
    .then(r => { location.reload() })
}
</script>
