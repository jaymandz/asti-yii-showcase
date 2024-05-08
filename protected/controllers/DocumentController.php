<?php

class DocumentController extends Controller
{
	public function actionCreate($path)
	{
		$this->render('create', [
			'path' => $path,
		]);
	}

	public function actionDestroy($id)
	{
		Document::model()->findByPk($id)->delete();
	}

	public function actionEdit($id)
	{
		$this->render('edit');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionShow($id)
	{
		$this->render('show', [
			'document' => Document::model()->findByPk($id),
		]);
	}

	public function actionStore()
	{
		$document = new Document;
		$document->name = $_POST['name'];
		$document->mime = $_POST['mime'];
		$document->content = file_get_contents($_FILES['content']['tmp_name']);
		$document->save();

		$this->redirect(['/explorer']);
	}

	public function actionUpdate($id)
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