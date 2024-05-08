<?php
/* @var $this DocumentController */

$this->breadcrumbs=array(
	'Document'=>array('/document'),
	'Show',
);
?>

<div class="btn-group mb-3" role="group">
	<a class="btn btn-secondary" role="button"
      href="javascript:;">
        <span class="bi bi-arrow-90deg-up"></span>
        To folder
    </a>
	<a class="btn btn-secondary" role="button"
      href="javascript:;">
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
