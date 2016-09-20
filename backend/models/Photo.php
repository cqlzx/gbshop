<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property string $ID
 * @property string $path
 * @property string $description
 * @property string $albumID
 * @property string $shopID
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['path', 'albumID', 'shopID'], 'required'],
            [['albumID', 'shopID'], 'integer'],
            [['path', 'description'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'path' => 'Path',
            'description' => 'Description',
            'albumID' => 'Album ID',
            'shopID' => 'Shop ID',
        ];
    }
}
