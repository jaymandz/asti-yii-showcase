<?php

class FolderController extends Controller
{
	public function actionCreate($path)
	{
		echo $this->engine->render('folder/create', [
			'path' => $path,
		]);
	}

	public function actionDestroy($id)
	{
		$folder = Folder::model()->findByPk($id);
		$parentPath = $this->folderToPath(
			Folder::model()->findByPk($folder->parent_id)
		);
		$folder->delete();
		$this->redirect(['/explorer', 'path' => $parentPath]);
	}

	public function actionEdit($id)
	{
		echo $this->engine->render('folder/edit', [
			'folder' => Folder::model()->findByPk($id),
		]);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionShow()
	{
		$this->render('show');
	}

	public function actionStore()
	{
		$folder = new Folder;
		$folder->name = $_POST['name'];
		$folder->parent_id = $this->pathToFolder($_POST['path'])->id ?? null;
		$folder->save();

		$this->redirect(['/explorer', 'path' => $_POST['path']]);
	}

	public function actionUpdate($id)
	{
		$folder = Folder::model()->findByPk($id);
		$folder->name = $_POST['name'];
		$folder->save();

		$this->redirect(['/explorer', 'path' => $this->folderToPath($folder)]);
	}

	public function folderToPath($folder)
    {
        $path = '/';
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