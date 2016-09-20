<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "token".
 *
 * @property integer $ID
 * @property string $createTime
 * @property string $token
 */
class Token extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['createTime'], 'safe'],
            [['token'], 'required'],
            [['token'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'TOKEN',
            'createTime' => '更新时间',
            'token' => 'token',
        ];
    }
}
