<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "shop".
 *
 * @property string $ID
 * @property string $name
 * @property double $discount
 * @property string $classA
 * @property string $classB
 * @property integer $circle
 * @property string $description
 * @property string $address
 * @property string $phone
 * @property string $information
 * @property string $attention
 * @property integer $moneyAll
 * @property integer $gbLeft
 * @property double $gjOld
 * @property double $gjNow
 * @property double $gjNew
 * @property double $increaseRateOld
 * @property double $increaseRateNew
 * @property double $gbChargeRate
 * @property double $gbExchangeRate
 * @property double $cashReturnRate
 * @property double $cashReturn
 * @property integer $userNum
 * @property integer $state
 * @property integer $honour
 * @property double $latestCharge
 * @property integer $latestGb
 */
class Shop extends \yii\db\ActiveRecord
{
	const HONOURED = 2;
	const UNHONOURED = 1;
	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'classA', 'classB', 'circle', 'description', 'pic', 'address', 'phone', 'information', 'attention'], 'required'],
            [['discount', 'gjOld', 'gjNow', 'gjNew', 'increaseRateOld', 'increaseRateNew', 'gbChargeRate', 'gbExchangeRate', 'cashReturnRate', 'cashReturn', 'latestCharge'], 'number'],
            [['classA', 'classB', 'circle', 'moneyAll', 'gbLeft', 'userNum', 'state', 'honour', 'latestGb'], 'integer'],
            [['name', 'pic'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 512],
            [['address', 'information', 'attention'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '主键',
            'name' => '商家名',
            'discount' => '商家折扣',
            'classA' => '所属一级分类',
            'classB' => '所属二级分类',
            'circle' => '商圈',
            'description' => '商家描述',
            'pic' => '商家照片',
            'address' => '地址',
            'phone' => '电话号码',
            'information' => '商家信息',
            'attention' => '购买须知',
            'moneyAll' => '累计充值金额',
            'gbLeft' => '股币剩余数',
            'gjOld' => '旧股价',
            'gjNow' => '正在使用的股价',
            'gjNew' => '新股价',
            'increaseRateOld' => '涨跌幅(旧)',
            'increaseRateNew' => '涨跌幅(新)',
            'gbChargeRate' => '商家给用户充股币系数',
            'gbExchangeRate' => '商家给用户兑换现金系数',
            'cashReturnRate' => '返利比例',
            'cashReturn' => '隶属利润',
            'userNum' => '隶属用户总数',
            'state' => '商户状态',
            'honour' => '是否为贵宾，1否， 2是',
            'latestCharge' => '最后一次充值',
            'latestGb' => '最后一次充值股币',
        ];
    }
}
