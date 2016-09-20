<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "icon".
 *
 * @property integer $ID
 * @property string $name
 * @property string $description
 * @property string $pic
 */
class Icon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'icon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'pic'], 'required'],
            [['name', 'description'], 'string', 'max' => 20],
            [['pic'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'name' => '一级名称',
            'description' => '描述',
            'pic' => '图标地址',
        ];
    }
}
