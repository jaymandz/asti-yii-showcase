<?php

require __DIR__ . '/../extensions/autoload.php';

use League\Plates\Engine;

class DocumentController extends Controller
{
	public $engine;

	public function __construct($id, $module=null)
	{
		parent::__construct($id, $module);

		$this->engine = new Engine(__DIR__ . '/../views');
		$this->engine->registerFunction(
			'createUrl',
			[$this, 'createUrl']
		);
		$this->engine->registerFunction(
			'folderToPath',
			[$this, 'folderToPath']
		);
		$this->engine->addData([
			'pageTitle' => $this->pageTitle,
		]);
	}

	public function actionCreate($path)
	{
		echo $this->engine->render('document/create', [
			'path' => $path,
		]);
	}

	public function actionDestroy($id)
	{
		$document = Document::model()->findByPk($id);
		$parentPath = $this->folderToPath(
			Folder::model()->findByPk($document->folder_id)
		);
		$document->delete();
		$this->redirect(['/explorer', 'path' => $parentPath]);
	}

	public function actionEdit($id)
	{
		echo $this->engine->render('document/edit', [
			'document' => Document::model()->findByPk($id),
		]);
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionShow($id)
	{
		$document = Document::model()->findByPk($id);
		$this->render('show', [
			'document' => $document,
			'parentPath' => $this->folderToPath(
			  Folder::model()->findByPk($document->folder_id)),
		]);
	}

	public function actionStore()
	{
		$document = new Document;
		$document->folder_id = $this->pathToFolder($_POST['path'])->id ?? null;
		$document->name = $_POST['name'];
		$document->mime = $_POST['mime'];
		$document->content = file_get_contents($_FILES['content']['tmp_name']);
		$document->save();

		$this->redirect(['/explorer', 'path' => $_POST['path']]);
	}

	public function actionUpdate($id)
	{
		$document = Document::model()->findByPk($id);
		$document->name = $_POST['name'];
		$document->mime = $_POST['mime'];
		$document->save();

		$this->redirect(['/document/show', 'id' => $id]);
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