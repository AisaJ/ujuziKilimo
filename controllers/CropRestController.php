<?php


namespace app\controllers;


use app\models\Crop;
use Throwable;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class CropRestController extends ActiveController
{
    public $modelClass = "app\models\Crop";

 /*   public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ],
            ],
        ]);
    }*/

    public function actionCreateCrop()
    {
        Yii::$app->response->format = Response:: FORMAT_JSON;

        $crop = new Crop();
        $crop->attributes = yii::$app->request->post();


        if($crop->save()) {
            return array('status' => true, 'data' => 'crop record is successfully saved');
        } else {
            return array('status' => false, 'data' => $crop->getErrors());
        }


    }

    public function actionGetAll()
    {
        Yii::$app->response->format = Response:: FORMAT_JSON;
        $crop = Crop::find()->all();
        if (count($crop) > 0) {
            return array('status' => true, 'data' => $crop);
        } else {
            return array('status' => false, 'data' => 'No crop record found');
        }

    }


    public function actionUpdateCrop()
    {

        Yii::$app->response->format = Response:: FORMAT_JSON;
        $attributes = yii::$app->request->post();

        $crop = Crop::find()->where(['id' => $attributes['id']])->one();
        if (count($crop) == 1) {
            $crop->attributes = yii::$app->request->post();
            $crop->save();
            return array('status' => true, 'data' => 'crop record is updated successfully');

        } else {
            return array('status' => false, 'data' => 'No crop record Found to update' );
        }


    }


    public function actionDeleteCrop()
    {

        $crop = new Crop();
        yii::$app->response->format = Response:: FORMAT_JSON;

        if ($crop->validate()) {
            $attributes = yii::$app->request->post();

            $cropId = $attributes['id'];
            $cropFromDB = Crop::find()->where(['ID' => $cropId])->one();
            if (count($cropFromDB) > 0) {
                try {
                    $cropFromDB->delete();
                } catch (yii\db\StaleObjectException $e) {
                } catch (Throwable $e) {
                }
                return array('status' => true, 'data' => 'Crop record is successfully deleted');
            } else {
                return array('status' => true, 'data' => 'no crop with id ' .$cropId.' found');

            }
        } else {
            return array('status' => false, 'data' => 'id is required');
        }

    }

}