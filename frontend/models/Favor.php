<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "favor".
 *
 * @property string $ID
 * @property string $userID
 * @property string $productID
 */
class Favor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'favor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'productID'], 'required'],
            [['userID', 'productID'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '主键',
            'userID' => '用户ID',
            'productID' => '商品ID',
        ];
    }
}
