<?php
$this->layout('folder/create_edit', [
    'formActionUrl' => $this->createUrl('/folder/store'),
    'path' => $path,
    'breadcrumbs' => [
        'Folder' => ['/folder'],
        'Create',
    ],
]);
?>