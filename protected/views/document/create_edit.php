<?php
$this->layout('layouts/main_plates', [
    'breadcrumbs' => $breadcrumbs,
]);
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
<div class="card-body overflow-y-scroll" style="height: calc(100vh - 183px)">

<form action="<?= $formActionUrl ?>" method="post"
  enctype="multipart/form-data" id="fileUploadForm">
<div class="mb-3">
    <label class="form-label" for="filenameInput">Filename</label>
    <input required class="form-control" id="filenameInput" name="name"
      type="text" value="<?= $document->name ?? '' ?>">
</div>

<div class="mb-3">
<label class="form-label" for="filenameInput">File type</label>
<select required class="form-control" name="mime" x-data="mimeTypes">
    <option selected value="">Select a file type.</option>
    <optgroup label="Default types">
        <template x-for="(t, i) in defaults">
            <option x-text="`${t.name} [usually ${t.extension}]`"
              :value="t.value"
              :selected="t.value == '<?= $document->mime ?? '' ?>'"></option>
        </template>
    </optgroup>
    <optgroup label="Miscellaneous types">
        <template x-for="(t, i) in misc">
            <option x-text="`${t.name} [${t.extension}]`" :value="t.value"
              :selected="t.value == '<?= $document->mime ?? '' ?>'"></option>
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

<?php if (isset($document)): ?>
<div class="mb-3">
    <a href="<?= $this->createUrl('/explorer/download', ['id' => $document->id]) ?>">
        Currently uploaded file
    </a>
</div>
<?php endif ?>

<div class="mb-3">
    <label class="form-label" for="filenameInput">File to upload</label>
    <input class="form-control" name="content" type="file"
      <?= isset($document) ? '' : 'required' ?>>
</div>
</form>

</div>
</div>