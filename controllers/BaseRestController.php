<?php


	namespace app\controllers;


	use Yii;
	use yii\filters\VerbFilter;
	use yii\rest\ActiveController;
	use yii\web\BadRequestHttpException;
	use yii\web\Response;

	class BaseRestController extends ActiveController
	{
		public function beforeAction($action)
		{

			Yii::$app->response->format = Response::FORMAT_JSON;
			try {
				return parent::beforeAction($action);
			} catch (BadRequestHttpException $e) {
			}
		}

		public function actions()
		{
			$actions = parent::actions();
			unset($actions['create']);
			unset($actions['update']);
			unset($actions['delete']);
			unset($actions['view']);
			unset($actions['index']);
			return $actions;

		}


		public function behaviors()
		{
			return [
				'verbs' => [
					'class' => VerbFilter::className(),
					'actions' => [
						'create' => ['POST'],
						'update' => ['POST'],
						'delete' => ['GET'],
						'index' => ['GET'],
						'view' => ['GET'],
						'get-one' => ['GET'],
						'get-all' => ['GET'],

					],
				],
			];
		}

	}