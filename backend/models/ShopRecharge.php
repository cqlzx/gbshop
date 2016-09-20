<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shopRecharge".
 *
 * @property string $ID
 * @property string $shopID
 * @property string $shopName
 * @property string $time
 * @property integer $money
 * @property integer $gb
 * @property double $discount
 */
class ShopRecharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shopRecharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['shopID', 'shopName', 'money', 'gb', 'discount'], 'required'],
            [['shopID', 'money', 'gb'], 'integer'],
            [['time'], 'safe'],
            [['discount'], 'number'],
            [['shopName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '充值ID',
            'shopID' => '商家ID',
            'shopName' => '商家名称',
            'time' => '充值日期',
            'money' => '充值金额',
            'gb' => '充值股宝数',
            'discount' => '充值折扣',
        ];
    }
}
