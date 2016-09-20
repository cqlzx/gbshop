<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "classA".
 *
 * @property string $ID
 * @property string $name
 * @property string $pic
 */
class ClassA extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classA';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pic'], 'required'],
            [['name', 'pic'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'name' => '分类名称',
            'pic' => '一级分类图标',
        ];
    }
}
