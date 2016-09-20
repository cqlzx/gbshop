<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "circle".
 *
 * @property integer $ID
 * @property string $name
 * @property integer $sequence
 */
class Circle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'circle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sequence'], 'integer'],
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
            'name' => '商圈名称',
            'sequence' => '顺序',
        ];
    }
}
