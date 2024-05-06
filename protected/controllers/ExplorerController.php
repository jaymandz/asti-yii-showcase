<?php

class ExplorerController extends Controller
{
	public function actionIndex($path='/')
	{
		$currentFolders = Folder::model()->find([
			'condition' => 'parent_id = NULL',
		]);

		$currentDocuments = Document::model()->find([
			'condition' => 'folder_id = NULL',
		]);

		$pathChunks = explode('/', $path);
		foreach ($pathChunks as $chunk)
		{
			if (! $chunk) continue;
		}

		$this->render('index', [
			'path' => $path,
		]);
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