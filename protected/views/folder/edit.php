<?php
$this->layout('folder/create_edit', [
	'folder' => $folder,
	'formActionUrl' => $this->createUrl('/folder/update', [
		'id' => $folder->id,
	]),
    'path' => $this->folderToPath(
		Folder::model()->findByPk($folder->parent_id)
	),
    'breadcrumbs' => [
        'Folder' => ['/folder'],
        'Edit',
    ],
]);
?>