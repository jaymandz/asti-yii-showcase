<?php

class CommentController extends Controller
{
	public function actionDestroy()
	{
		$this->render('destroy');
	}

	public function actionShow($id)
	{
		$comment = Comment::model()->findByPk($id);
		echo json_encode([
			'id' => $comment->id,
			'document_id' => $comment->document_id,
			'content' => $comment->content,
			'num_likes' => $comment->num_likes,
			'num_dislikes' => $comment->num_dislikes,
		]);
	}

	public function actionStore()
	{
		$comment = new Comment;
		$comment->document_id = $_POST['document_id'];
		$comment->content = $_POST['content'];
		$comment->save();

		$this->redirect(['/document/show', 'id' => $_POST['document_id']]);
	}

	public function actionUpdate($id)
	{
		$comment = Comment::model()->findByPk($id);
		$comment->document_id = $_POST['document_id'];
		$comment->content = $_POST['content'];
		$comment->num_likes = $_POST['num_likes'];
		$comment->num_dislikes = $_POST['num_dislikes'];
		$comment->save();

		$this->redirect(['/document/show', 'id' => $_POST['document_id']]);
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