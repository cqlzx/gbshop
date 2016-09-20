<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shopWithdraw".
 *
 * @property string $ID
 * @property string $shopID
 * @property string $shopName
 * @property string $phone
 * @property string $time
 * @property double $money
 */
class ShopWithdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shopWithdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shopID', 'shopName', 'phone', 'money'], 'required'],
            [['shopID'], 'integer'],
            [['time'], 'safe'],
            [['money'], 'number'],
            [['shopName'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '提现ID',
            'shopID' => '商家ID',
            'shopName' => '商家名称',
            'phone' => '电话',
            'time' => '提现时间',
            'money' => '提现金额',
        ];
    }
}
