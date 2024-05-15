<?php
/* @var $this FolderController */

$this->breadcrumbs=array(
	'Folder'=>array('/folder'),
	'Create',
);
?>

<div class="btn-group mb-3" role="group">
    <a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/explorer', ['path' => $path]) ?>">
        <span class="bi bi-arrow-90deg-up"></span>
        To folder
    </a>
    <button type="submit" class="btn btn-primary" form="folderCreateForm">
        <span class="bi bi-save"></span>
        Save
    </button>
</div>

<div class="card">
<div class="card-body">
<form action="<?= $this->createUrl('/folder/store') ?>" method="post"
  id="folderCreateForm">
<div class="mb-3">
    <label class="form-label" for="filenameInput">Folder name</label>
    <input required class="form-control" id="filenameInput" name="name"
      type="text">
</div>

<div class="mb-3">
    <label class="form-label" for="filenameInput">Store in folder</label>
    <input readonly required class="form-control" name="path" type="text"
      value="<?= $path ?>">
    <div class="form-text" id="mimeTypeText">
        Make sure this folder exists or an error will appear.
    </div>
</div>
</form>
</div>
</div>
