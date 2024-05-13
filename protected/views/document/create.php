<?php
/* @var $this DocumentController */

$this->breadcrumbs=array(
    'Document'=>array('/document'),
    'Create',
);
?>

<div class="btn-group mb-3" role="group">
    <a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/explorer', ['path' => $path]) ?>">
        <span class="bi bi-arrow-90deg-up"></span>
        To folder
    </a>
    <button type="submit" class="btn btn-primary" form="fileUploadForm">
        <span class="bi bi-save"></span>
        Save
    </button>
</div>

<div class="card">
<div class="card-body">

<form action="<?= $this->createUrl('/document/store') ?>" method="post"
  enctype="multipart/form-data" id="fileUploadForm">
<div class="mb-3">
    <label class="form-label" for="filenameInput">Filename</label>
    <input required class="form-control" id="filenameInput" name="name"
      type="text">
</div>

<div class="mb-3">
<label class="form-label" for="filenameInput">File type</label>
<select required class="form-control" name="mime" x-data="mimeTypes">
    <option selected value="">Select a file type.</option>
    <optgroup label="Default types">
        <template x-for="(t, i) in defaults">
            <option x-text="`${t.name} [usually ${t.extension}]`"
              :value="t.value"></option>
        </template>
    </optgroup>
    <optgroup label="Miscellaneous types">
        <template x-for="(t, i) in misc">
            <option x-text="`${t.name} [${t.extension}]`"
              :value="t.value"></option>
        </template>
    </optgroup>
</select>
</div>

<div class="mb-3">
    <label class="form-label" for="filenameInput">Store in folder</label>
    <input readonly required class="form-control" name="path" type="text"
      value="<?= $path ?>">
    <div class="form-text" id="mimeTypeText">
        Make sure this folder exists or an error will appear.
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="filenameInput">File to upload</label>
    <input required class="form-control" name="content" type="file">
</div>
</form>

</div>
</div>