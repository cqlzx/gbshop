<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "classB".
 *
 * @property integer $ID
 * @property string $name
 * @property integer $sequence
 * @property string $classA
 */
class ClassB extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'classB';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'classA'], 'required'],
            [['sequence', 'classA'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '主键',
            'name' => '二级分类名称',
            'sequence' => '顺序',
            'classA' => '一级分类',
        ];
    }
}
