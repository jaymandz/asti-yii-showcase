<?php

class ExplorerController extends Controller
{
    public $mimeExtensions = [
        'text/plain' => '.txt',
        'application/octet-stream' => '.bin',
        'application/pdf' => '.pdf',
        'image/gif' => '.gif',
        'image/jpeg' => '.jpeg',
        'application/vnd.ms-excel' => '.xls',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '.xlsx',
        'application/vnd.ms-powerpoint' => '.ppt',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => '.pptx',
        'application/msword' => '.doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
        'application/vnd.oasis.opendocument.presentation' => '.odp',
        'application/vnd.oasis.opendocument.spreadsheet' => '.ods',
        'application/vnd.oasis.opendocument.text' => '.odt',
        'image/png' => '.png',
        'application/zip' => '.zip',
    ];

    public function actionDownload($id)
    {
        $document = Document::model()->find(
            'id = :documentId',
            ['documentId' => $id],
        );

        Yii::app()->getRequest()->sendFile(
            $document->name . $this->mimeExtensions[$document->mime],
            $document->content
        );
    }

    public function actionIndex($path='/')
    {
        # Pretty sure there are plenty of redundancies here. Will fix later.
        $folder = $this->pathToFolder($path);
        $parentPath = ! $folder ? null : $this->folderToPath(
            Folder::model()->findByPk($folder->parent_id)
        );
        $currentFolders = [];
        $currentDocuments = [];

        if (! $folder)
        {
            $currentFolders = Folder::model()->findAll(
              'parent_id IS NULL');
            $currentDocuments = Document::model()->findAll(
              'folder_id IS NULL');
        }
        else
        {
            $currentFolders = Folder::model()->findAll(
              'parent_id = :parentId', ['parentId' => $folder->id]);
            $currentDocuments = Document::model()->findAll(
              'folder_id = :folderId', ['folderId' => $folder->id]);
        }

        $this->render('index', [
            'path' => $path,
            'folder' => $folder,
            'childFolders' => $currentFolders,
            'documents' => $currentDocuments,
            'folderToPath' => [$this, 'folderToPath'],
            'parentPath' => $parentPath,
        ]);
    }

    protected function folderToPath($folder)
    {
        $path = '';
        $currentFolder = $folder;
        while ($currentFolder != null)
        {
            $path = "/$currentFolder->name$path";
            $currentFolder = Folder::model()->findByPk(
              $currentFolder->parent_id);
        }
        return $path;
    }

    protected function pathToFolder($path)
    {
        $currentFolder = null;
        $chunks = explode('/', $path);
        foreach ($chunks as $chunk)
        {
            if (! $chunk) continue;

            if (! $currentFolder) $currentFolder = Folder::model()
              ->find('name = :name AND parent_id IS NULL', ['name' => $chunk]);
            else $currentFolder = Folder::model()->find(
              'name = :name AND parent_id = :parentId',
              ['name' => $chunk, 'parentId' => $currentFolder->id]);
        }

        return $currentFolder;
    }

    // Uncomment the following methods and override them if needed
    /*
    public function filters()
    {
        // return the filter configuration for this controller, e.g.:
        return array(
            'inlineFilterName',
            array(
                'class'=>'path.to.FilterClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }

    public function actions()
    {
        // return external action classes, e.g.:
        return array(
            'action1'=>'path.to.ActionClass',
            'action2'=>array(
                'class'=>'path.to.AnotherActionClass',
                'propertyName'=>'propertyValue',
            ),
        );
    }
    */
}