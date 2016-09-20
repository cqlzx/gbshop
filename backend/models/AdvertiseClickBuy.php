<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "advertiseClickBuy".
 *
 * @property string $ID
 * @property string $productID
 * @property string $productName
 * @property string $shopID
 * @property string $shopName
 * @property string $time
 * @property integer $cash
 * @property integer $clickTimes
 * @property integer $classA
 */
class AdvertiseClickBuy extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertiseClickBuy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['productID', 'productName', 'shopID', 'shopName', 'cash', 'clickTimes', 'classA'], 'required'],
            [['productID', 'shopID', 'cash', 'clickTimes', 'classA'], 'integer'],
            [['time'], 'safe'],
            [['productName', 'shopName'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '够买点击广告ID',
            'productID' => '产品ID',
            'productName' => '产品名称',
            'shopID' => '商铺ID',
            'shopName' => '商铺名称',
            'time' => '购买日期',
            'cash' => '现金，单位元',
            'clickTimes' => '广告点击数',
            'classA' => '一级分类',
        ];
    }
}
