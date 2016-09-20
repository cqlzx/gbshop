<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property string $ID
 * @property string $userID
 * @property string $userName
 * @property string $productID
 * @property string $time
 * @property string $code
 * @property integer $valid
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'userName', 'productID', 'code'], 'required'],
            [['userID', 'productID', 'valid'], 'integer'],
            [['time'], 'safe'],
            [['userName', 'code'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'userID' => 'User ID',
            'userName' => '名称（手机号）',
            'productID' => 'Product ID',
            'time' => '日期',
            'code' => 'Code',
            'valid' => '是否有效（0无效，1有效）',
        ];
    }
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['ID' => 'productID']);
    }
}
