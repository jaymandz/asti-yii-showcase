<?php
$this->layout('document/create_edit', [
    'formActionUrl' => $this->createUrl('/document/store'),
    'path' => $path,
    'breadcrumbs' => [
        'Document' => ['/document'],
        'Create',
    ],
]);
?>