<?php
/* @var $this DocumentController */

$this->breadcrumbs=array(
    'Document'=>array('/document'),
    'Create',
);
?>

<script type="text/javascript">
Alpine.data('mimeTypes', () => ({
    content: [
        {
            value: 'application/vnd.ms-excel',
            name: 'Microsoft Excel [.xls]',
        },
        {
            value: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            name: 'Microsoft Excel (OpenXML) [.xlsx]',
        },
        {
            value: 'application/vnd.ms-powerpoint',
            name: 'Microsoft PowerPoint [.ppt]',
        },
        {
            value: 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            name: 'Microsoft PowerPoint (OpenXML) [.pptx]',
        },
        {
            value: 'application/msword',
            name: 'Microsoft Word [.doc]',
        },
        {
            value: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            name: 'Microsoft Word (OpenXML) [.docx]',
        },
        {
            value: 'application/vnd.oasis.opendocument.text',
            name: 'OpenDocument text document [.odt]',
        },
    ],
}))
</script>

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

<form action="<?= $this->createUrl('/document/store') ?>" method="post"
  enctype="multipart/form-data" id="fileUploadForm">
<div class="mb-3">
    <label class="form-label" for="filenameInput">Filename</label>
    <input required class="form-control" id="filenameInput" name="name"
      type="text">
</div>

<div class="mb-3">
<label class="form-label" for="filenameInput">File type</label>
<select required class="form-control" name="mime">
    <option selected value="">Select a file type.</option>
    <optgroup label="Default types">
        <option value="text/plain">Text</option>
        <option value="application/octet-stream">Binary data</option>
    </optgroup>
    <optgroup label="Other types" x-data="mimeTypes">
        <template x-for="(t, i) in content">
            <option x-bind:value="t.value" x-text="t.name"></option>
        </template>
    </optgroup>
</select>
<div class="form-text" id="mimeTypeText">
    The file type will be determined by the file extension of your upload, but
    you can still select another one if you like.
</div>
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
