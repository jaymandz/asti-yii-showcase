<?php

class ExplorerController extends Controller
{
    public function actionDownload($id)
    {
        $document = Document::model()->find(
            'id = :documentId',
            ['documentId' => $id],
        );

        Yii::app()->getRequest()->sendFile(
            $document->name,
            $document->content
        );
    }

    public function actionIndex($path='/')
    {
        # Pretty sure there are plenty of redundancies here. Will fix later.
        $folderId = $this->folderPathToId($path);
        $currentFolders = [];
        $currentDocuments = [];

        if (! $folderId)
        {
            $currentFolders = Folder::model()->findAll(
              'parent_id IS NULL');
            $currentDocuments = Document::model()->findAll(
              'folder_id IS NULL');
        }
        else
        {
            $currentFolders = Folder::model()->findAll(
              'parent_id = :parentId',
              ['parentId' => $folderId]);
            $currentDocuments = Document::model()->findAll(
              'folder_id = :folderId',
              ['folderId' => $folderId]);
        }

        $this->render('index', [
            'path' => $path,
            'folder' => Folder::model()->findByPk($folderId),
            'childFolders' => $currentFolders,
            'documents' => $currentDocuments,
            'folderIdToPath' => [$this, 'folderIdToPath'],
        ]);
    }

    protected function folderIdToPath($id)
    {
        $path = '';
        $currentId = $id;
        while ($currentId != null)
        {
            $folder = Folder::model()->findByPk($currentId);
            $path = "/$folder->name$path";
            $currentId = $folder->parent_id;
        }
        return $path;
    }

    protected function folderPathToId($path)
    {
        $currentId = null;
        $currentParentId = null;
        $chunks = explode('/', $path);
        foreach ($chunks as $chunk)
        {
            if (! $chunk) continue;

            if (! $currentParentId) $folder = Folder::model()->find(
              'name = :name AND parent_id IS NULL',
              ['name' => $chunk]);
            else $folder = Folder::model()->find(
              'name = :name AND parent_id = :parentId',
              ['name' => $chunk, 'parentId' => $currentParentId]);
            $currentId = $folder->id;
            $currentParentId = $folder->parent_id;
        }

        return $currentId;
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