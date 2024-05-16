<?php
$this->layout('document/create_edit', [
	'document' => $document,
    'formActionUrl' => $this->createUrl('/document/update', [
        'id' => $document->id,
    ]),
    'path' => $this->folderToPath(
		Folder::model()->findByPk($document->folder_id)
	),
    'breadcrumbs' => [
        'Document' => ['/document'],
        'Edit',
    ],
]);
?>
