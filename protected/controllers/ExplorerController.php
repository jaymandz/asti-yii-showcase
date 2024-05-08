<?php

class ExplorerController extends Controller
{
	public function actionDownload($id)
	{
		$document = Document::model()->find(
			'id = :documentId',
			['documentId' => $id],
		);

		echo $document->content;
	}

	public function actionIndex($path='/')
	{
		$currentFolders = Folder::model()->findAll(
			'parent_id IS NULL',
		);

		$currentDocuments = Document::model()->findAll(
			'folder_id IS NULL',
		);
		#print_r($currentDocuments); die;

		$pathChunks = explode('/', $path);
		foreach ($pathChunks as $chunk)
		{
			if (! $chunk) continue;
		}

		$this->render('index', [
			'path' => $path,
			'folders' => $currentFolders,
			'documents' => $currentDocuments,
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