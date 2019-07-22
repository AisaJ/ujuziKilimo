<?php


	namespace app\controllers;


	use app\models\Category;
	use Throwable;
	use Yii;
	use yii\web\Response;

	class CategoryRestController extends BaseRestController
	{
		public $modelClass = "app\models\Category";


		public function actionCreate()
		{
			Yii::$app->response->format = Response:: FORMAT_JSON;

			$category = new Category();
			$category->attributes = yii::$app->request->post();

			$transaction = Category::getDb()->beginTransaction();
			try {
				$category = $category->save();
				return array('status' => true, 'data' => 'successfully created ' );

			} catch (Throwable $e) {
				$transaction->rollBack();
				return array('status' => false, 'data' => 'could not create the category');

			}

		}

		public function actionGetAll()
		{
			Yii::$app->response->format = Response:: FORMAT_JSON;

			$transaction = Category::getDb()->beginTransaction();
			try {
				$categories = Category::find()->all();

				if (count($categories) > 0)
					return array('status' => true, 'data' => $categories);
				else
					return array('status' => false, 'data' => 'could not get the categories');


			} catch (Throwable $e) {
				$transaction->rollBack();
				return array('status' => false, 'data' => 'an  error occurred');

			}

		}

		public function actionGetOne()
		{
			Yii::$app->response->format = Response:: FORMAT_JSON;

			$attributes = yii::$app->request->get();

			if ($attributes == null) {
				return array('status' => false, 'data' => 'your request must have parameters');
			}


			$id = $attributes['id'];


			$transaction = Category::getDb()->beginTransaction();
			try {
				$category = Category::findOne($id);
				if ($category != null)
					return array('status' => true, 'data' => $category);
				else
					return array('status' => false, 'data' => 'No crop record found');


			} catch (Throwable $e) {
				return array('status' => false, 'data' => 'an  error occurred');

			}


		}


		public function actionUpdate()
		{
			Yii::$app->response->format = Response:: FORMAT_JSON;
			$attributes = yii::$app->request->post();

			$transaction = Category::getDb()->beginTransaction();
			try {
				$category = Category::find()->where(['id' => $attributes['id']])->one();
				$category->attributes = yii::$app->request->post();
				$category->save();
				return array('status' => true, 'data' => 'category record is updated successfully');

			} catch (Throwable $e) {
				$transaction->rollBack();
				return array('status' => false, 'data' => 'No category record Found to update');
			}

		}


		public function actionDelete($id)
		{
			yii::$app->response->format = Response:: FORMAT_JSON;

			$transaction = Category::getDb()->beginTransaction();
			try {
				$category = Category::findOne($id);
				$category->delete();
				return array('status' => true, 'data' => 'deleted successfully');

			} catch (Throwable $e) {
				$transaction->rollBack();
				return array('status' => false, 'data' => 'unable to delete');
			}

		}





	}