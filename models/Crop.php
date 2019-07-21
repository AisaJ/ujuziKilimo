<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tbl_crop".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $Description
 * @property string $updated_at
 * @property string $created_at
 */
class Crop extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_crop';
    }

	public function getCategory()
	{
		return $this->hasOne(Crop::className(), ['id' => 'category_id']);
	}

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'Description'], 'required'],
            [['category_id'], 'integer'],
            [['Description'], 'string'],
            [['updated_at', 'created_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'name' => 'Name',
            'Description' => 'Description',
        ];
    }



}
