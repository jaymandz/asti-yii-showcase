<?php
/* @var $this ExplorerController */

$this->breadcrumbs=array(
    'Explorer',
);
?>

<div class="btn-group mb-3" role="group">
    <?php if ($path == '/'): ?>
    <a class="btn btn-secondary disabled" href="javascript:;" role="button">
        <span class="bi bi-arrow-90deg-up"></span>
        Parent folder
    </a>
    <a class="btn btn-secondary disabled" href="javascript:;" role="button">
        <span class="bi bi-pen"></span>
        Edit
    </a>
    <?php elseif (! $folder->parent_id): ?>
    <a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/explorer', ['path' => '/']) ?>">
        <span class="bi bi-arrow-90deg-up"></span>
        Parent folder
    </a>
    <a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/folder/edit', ['id' => $folder->id]) ?>">
        <span class="bi bi-pen"></span>
        Edit
    </a>
    <?php else: ?>
    <a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/explorer', ['path' => $parentPath]) ?>">
        <span class="bi bi-arrow-90deg-up"></span>
        Parent folder
    </a>
    <a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/folder/edit', ['id' => $folder->id]) ?>">
        <span class="bi bi-pen"></span>
        Edit
    </a>
    <?php endif ?>
    <a class="btn btn-secondary" role="button"
      href="<?= $this->createUrl('/folder/create', ['path' => $path]) ?>">
        <span class="bi bi-folder-plus"></span>
        New folder
    </a>
    <a class="btn btn-primary" role="button"
      href="<?= $this->createUrl('/document/create', ['path' => $path]) ?>">
        <span class="bi bi-file-plus"></span>
        New file
    </a>
</div>

<h4 class="mb-3"><?= $path ?></h4>

<div class="overflow-y-auto" style="height: calc(100vh - 226px)">
<?php if (sizeof($childFolders) == 0 && sizeof($documents) == 0): ?>
<div class="alert alert-info">
    This folder is empty.
</div>
<?php else: ?>
<?php if (sizeof($childFolders) > 0): ?>
<ul class="list-group mb-3">
<?php foreach ($childFolders as $cf): ?>
<li class="list-group-item">
<div class="row">
    <div class="col-10">
        <span class="bi bi-folder-fill text-warning-emphasis"></span>
        <span data-bs-toggle="tooltip" data-bs-placement="right"
          data-bs-title="File name">
            <?= $cf->name ?>
        </span>
    </div>
    <div class="col-2">
        <a class="btn btn-outline-primary btn-sm" role="button"
          href="<?= $this->createUrl('/explorer',
          ['path' => $folderToPath($cf)]) ?>">
            <span class="bi bi-folder2-open"></span>
        </a>
        <button type="button" class="btn btn-outline-danger btn-sm"
          @click="confirmFolderDelete(<?= $cf->id ?>)">
            <span class="bi bi-trash"></span>
        </button>
    </div>
</div>
</li>
<?php endforeach ?>
</ul>
<?php endif ?>

<?php if (sizeof($documents) > 0): ?>
<ul class="list-group">
<?php foreach ($documents as $document): ?>
<li class="list-group-item">
<div class="row" x-data="{ getExtensionFromMime, getIconFromMime, getNameFromMime }">
    <div class="col-9">
        <span data-bs-toggle="tooltip" data-bs-placement="right"
          data-bs-title="File name">
            <span :class="`bi bi-${getMime('<?= $document->mime ?>').icon} ${getMime('<?= $document->mime ?>').color}`"></span>
            <?= $document->name ?>
        </span>
    </div>
    <div class="col">
        <span data-bs-toggle="tooltip" data-bs-placement="left"
          :data-bs-title="getNameFromMime('<?= $document->mime ?>')">
            <span class="badge text-bg-secondary"
              x-text="getExtensionFromMime('<?= $document->mime ?>')"></span>
        </span>
    </div>
    <div class="col-2">
        <a class="btn btn-outline-info btn-sm" role="button"
          href="<?= $this->createUrl('/document/show',
          ['id' => $document->id]) ?>">
            <span class="bi bi-info-circle"></span>
        </a>
        <a class="btn btn-outline-secondary btn-sm" role="button"
          href="<?= $this->createUrl('/explorer/download',
          ['id' => $document->id]) ?>">
            <span class="bi bi-download"></span>
        </a>
        <button type="button" class="btn btn-outline-danger btn-sm"
          @click="confirmDocumentDelete(<?= $document->id ?>)">
            <span class="bi bi-trash"></span>
        </button>
    </div>
</div>
</li>
<?php endforeach ?>
</ul>
<?php endif ?>
<?php endif ?>
</div>

<div class="fade modal" id="confirmFolderDeleteModal">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h5>Confirm folder delete</h5>
    </div>
    <div class="modal-body">
        <p>
            Are you sure you want to delete this folder? All its contents will
            be deleted.
        </p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="button" class="btn btn-primary" @click="deleteFolder()">
            OK
        </button>
    </div>
</div>
</div>
</div>

<div class="fade modal" id="confirmDocumentDeleteModal">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h5>Confirm document delete</h5>
    </div>
    <div class="modal-body">
        <p>Are you sure you want to delete this document?</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            Cancel
        </button>
        <button type="button" class="btn btn-primary" @click="deleteDocument()">
            OK
        </button>
    </div>
</div>
</div>
</div>

<script type="text/javascript">
const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
)
const tooltipList = [...tooltipTriggerList].map(
    tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl)
)

const confirmFolderDeleteModal = new bootstrap.Modal(
    '#confirmFolderDeleteModal', {},
)

const confirmDocumentDeleteModal = new bootstrap.Modal(
    '#confirmDocumentDeleteModal', {},
)

var folderToDeleteId, documentToDeleteId

function confirmFolderDelete(id)
{
    folderToDeleteId = id
    confirmFolderDeleteModal.show()
}

function confirmDocumentDelete(id)
{
    documentToDeleteId = id
    confirmDocumentDeleteModal.show()
}

function deleteFolder()
{
    window.location.href =
      '<?= $this->createUrl('/folder/destroy', ['id' => '']) ?>'+
      folderToDeleteId
}

function deleteDocument()
{
    window.location.href =
      '<?= $this->createUrl('/document/destroy', ['id' => '']) ?>'+
      documentToDeleteId
}
</script>