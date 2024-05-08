<!doctype html>
<html lang="en">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="<?= Yii::app()->request->baseUrl ?>/libraries/bootstrap/5.3.3/dist/css/bootstrap.css">
<link rel="stylesheet" href="<?= Yii::app()->request->baseUrl ?>/libraries/bootstrap-icons/1.11.3/font/bootstrap-icons.css">
<title><?= CHtml::encode($this->pageTitle) ?></title>

<body>

<script src="<?= Yii::app()->request->baseUrl ?>/libraries/alpinejs/3.13.10/dist/cdn.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/libraries/bootstrap/5.3.3/dist/js/bootstrap.bundle.js"></script>

<script type="text/javascript">
const defaultMimeTypes = [
    {
        value: 'text/plain',
        name: 'Text',
        extension: '.txt',
        icon: 'filetype-txt',
        color: 'text-body',
    },
    {
        value: 'application/octet-stream',
        name: 'Binary data',
        extension: '.bin',
        icon: 'file-binary',
        color: 'text-body',
    },
]

const miscMimeTypes = [
    {
        value: 'application/pdf',
        name: 'Adobe Portable Document Format (PDF)',
        extension: '.pdf',
        icon: 'file-pdf',
        color: 'text-danger',
    },
    {
        value: 'image/gif',
        name: 'Graphics Interchange Format (GIF)',
        extension: '.gif',
        icon: 'filetype-gif',
        color: 'text-body',
    },
    {
        value: 'image/jpeg',
        name: 'JPEG images',
        extension: '.jpeg',
        icon: 'filetype-jpg',
        color: 'text-body',
    },
    {
        value: 'application/vnd.ms-excel',
        name: 'Microsoft Excel',
        extension: '.xls',
        icon: 'filetype-xls',
        color: 'text-success',
    },
    {
        value: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        name: 'Microsoft Excel (OpenXML)',
        extension: '.xlsx',
        icon: 'file-excel',
        color: 'text-success',
    },
    {
        value: 'application/vnd.ms-powerpoint',
        name: 'Microsoft PowerPoint',
        extension: '.ppt',
        icon: 'filetype-ppt',
        color: 'text-danger',
    },
    {
        value: 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        name: 'Microsoft PowerPoint (OpenXML)',
        extension: '.pptx',
        icon: 'file-ppt',
        color: 'text-danger',
    },
    {
        value: 'application/msword',
        name: 'Microsoft Word',
        extension: '.doc',
        icon: 'filetype-doc',
        color: 'text-primary',
    },
    {
        value: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        name: 'Microsoft Word (OpenXML)',
        extension: '.docx',
        icon: 'file-word',
        color: 'text-primary',
    },
    {
        value: 'application/vnd.oasis.opendocument.presentation',
        name: 'OpenDocument presentation document',
        extension: '.odp',
        icon: 'file-slides',
        color: 'text-danger',
    },
    {
        value: 'application/vnd.oasis.opendocument.spreadsheet',
        name: 'OpenDocument spreadsheet document',
        extension: '.ods',
        icon: 'file-spreadsheet',
        color: 'text-success',
    },
    {
        value: 'application/vnd.oasis.opendocument.text',
        name: 'OpenDocument text document',
        extension: '.odt',
        icon: 'file-text',
        color: 'text-primary',
    },
    {
        value: 'image/png',
        name: 'Portable Network Graphics',
        extension: '.png',
        icon: 'filetype-png',
        color: 'text-body',
    },
    {
        value: 'application/zip',
        name: 'ZIP archive',
        extension: '.zip',
        icon: 'file-zip',
        color: 'text-warning',
    },
]

Alpine.data('mimeTypes', () => ({
    defaults: defaultMimeTypes,
    misc: miscMimeTypes,
}))

function getExtensionFromMime(mime)
{
    return miscMimeTypes.find(t => t.value == mime).extension
}

function getIconFromMime(mime)
{
    var mime = defaultMimeTypes.find(t => t.value == mime) ||
      miscMimeTypes.find(t => t.value == mime)
    return mime.icon
}

function getNameFromMime(mime)
{
    return miscMimeTypes.find(t => t.value == mime).name
}

function getMime(mime)
{
    return defaultMimeTypes.find(t => t.value == mime) ||
      miscMimeTypes.find(t => t.value == mime)
}
</script>

<nav class="bg-info navbar navbar-expand ">
<div class="container-fluid">
<a class="navbar-brand" href="#">
    <?= CHtml::encode(Yii::app()->name) ?>
</a>
<div class="collapse navbar-collapse">
<ul class="mb-2 mb-lg-0 me-auto navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/index') ?>">
            Home
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/page',
          ['view' => 'about']) ?>">About</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/contact') ?>">
            Contact
        </a>
    </li>
    <?php if (Yii::app()->user->isGuest): ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/login') ?>">
            Login
        </a>
    </li>
    <?php else: ?>
    <li class="nav-item">
        <a class="nav-link" href="<?= $this->createUrl('/site/logout') ?>">
            Logout (<?= Yii::app()->user->name ?>)
        </a>
    </li>
    <?php endif ?>
</ul>
</div>
</div>
</nav>

<div class="container-fluid">

<?php if (isset($this->breadcrumbs)): ?>
<nav aria-label="breadcrumb" class="fw-lighter mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?= $this->createUrl('/site/index') ?>">Home</a>
        </li>
        <?php foreach ($this->breadcrumbs as $c => $crumb): ?>
        <?php if (is_int($c)): ?>
        <?php if ($c == array_key_last($this->breadcrumbs)): ?>
        <li aria-current="page" class="breadcrumb-item active">
            <?= $crumb ?>
        </li>
        <?php else: ?>
        <li class="breadcrumb-item">
            <a href="javascript:;"><?= $c ?></a>
        </li>
        <?php endif ?>
        <?php else: ?>
        <li class="breadcrumb-item">
            <a href="<?= $this->createUrl($crumb[0]) ?>"><?= $c ?></a>
        </li>
        <?php endif ?>
        <?php endforeach ?>
    </ol>
</nav>
<?php endif ?>

<?= $content ?>

</div>

</body>
</html>