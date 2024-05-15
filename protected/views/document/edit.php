<?php
$this->layout('document/create_edit', [
	'document' => $document,
    'path' => $this->folderToPath(
		Folder::model()->findByPk($document->folder_id)
	),
    'breadcrumbs' => [
        'Document' => ['/document'],
        'Edit',
    ],
]);
?>
