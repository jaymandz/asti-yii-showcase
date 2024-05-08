<?php

class FolderController extends Controller
{
	public function actionCreate($path)
	{
		$this->render('create', [
			'path' => $path,
		]);
	}

	public function actionDestroy()
	{
		#
	}

	public function actionEdit()
	{
		$this->render('edit');
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
		$folder->save();

		$this->redirect(['/explorer']);
	}

	public function actionUpdate()
	{
		#
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