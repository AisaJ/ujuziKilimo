<?php


	namespace app\controllers;


	use app\models\Category;
	use app\models\Crop;
	use Throwable;
	use Yii;
	use yii\filters\VerbFilter;
	use yii\helpers\Json;
	use yii\rest\ActiveController;
	use yii\web\BadRequestHttpException;
	use yii\web\Response;

	class CropRestController extends ActiveController
	{
		public $modelClass = "app\models\Crop";

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
						'make' => ['POST'],
						'get-all' => ['GET'],
						'get-one' => ['GET'],
						'delete' => ['GET'],
					],
				],
			];
		}

		public function actionCreate()
		{
			$crop = new Crop();
			$attributes = yii::$app->request->post();
			$crop->attributes = $attributes;
			$crop->created_at = date('Y-m-d H:i:s');
			$category_id = $attributes['category_id'];

			$transaction = Crop::getDb()->beginTransaction();

			try {
				$category = Category::findOne($category_id);
				if (is_null($category)) {

					return array('status' => false, 'data' => 'make sure the category exist');

				}

				$crop->category_id = $category->id;
				$crop->save();

				return array('status' => true, 'info' => 'successfully created crop',
					'crop created' => $crop);


			} catch (Throwable $e) {
				return array('status' => false, 'data' => 'an error was encountered');


			}


		}

		public function actionGetAll()
		{


			$transaction = Crop::getDb()->beginTransaction();
			try {
				$crops = Crop::find()->all();
				if (count($crops) > 0)
					return array('status' => true, 'data' => $crops);
				else
					return array('status' => false, 'data' => 'No crops records found');

			} catch (Throwable $e) {
				return array('status' => false, 'data' => 'an  error occurred');


			}

		}

		public function actionGetOne()
		{

			$attributes = yii::$app->request->get();

			if ($attributes == null) {
				return array('status' => false, 'data' => 'your request must have parameters');
			}


			$id = $attributes['id'];


			$transaction = Crop::getDb()->beginTransaction();
			try {
				$crop = Crop::findOne($id);
				if ($crop != null)
					return array('status' => true, 'data' => $crop);
				else
					return array('status' => false, 'data' => 'No crop record found');


			} catch (Throwable $e) {
				return array('status' => false, 'data' => 'an  error occurred');

			}


		}


		public function actionUpdate()
		{


			$attributes = yii::$app->request->post();
			$cropID = $attributes['id'];
			$transaction = Crop::getDb()->beginTransaction();

			try {
				$crop = Crop::findOne($cropID);
				$crop->attributes = $attributes;
				$crop->updated_at = date('Y-m-d H:i:s');
				$crop->save();
				return array('status' => true, 'data' => 'crop record is updated successfully --> ' . Json::encode($crop));

			} catch (Throwable $e) {
				$transaction->rollBack();
				return array('status' => false, 'data' => 'an error occurred', 'error');
			}

		}


		public function actionDelete()
		{

			$crop = new Crop();
			yii::$app->response->format = Response:: FORMAT_JSON;

			$attributes = yii::$app->request->get();
			$cropId = $attributes['id'];
			$cropFromDB = Crop::findOne($cropId);
			if ($cropFromDB !=null) {
				try {
					$cropFromDB->delete();
				} catch (yii\db\StaleObjectException $e) {
					return array('status' => true, 'data' => 'deletion unsuccessfull');

				} catch (Throwable $e) {
					return array('status' => true, 'data' => 'deletion unsuccessful');

				}
				return array('status' => true, 'data' => 'Crop record is successfully deleted');
			} else {
				return array('status' => true, 'data' => 'no crop with id ' . $cropId . ' found');

			}

		}

	}