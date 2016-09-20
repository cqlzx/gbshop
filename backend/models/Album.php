<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "album".
 *
 * @property string $ID
 * @property string $name
 */
class Album extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'album';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '相册ID',
            'name' => '相册分类名',
        ];
    }
}
