<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "userWithdraw".
 *
 * @property string $ID
 * @property string $userID
 * @property string $nickname
 * @property string $openid
 * @property string $phone
 * @property string $time
 * @property integer $money
 * @property integer $classA
 */
class UserWithdraw extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userWithdraw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'nickname', 'openid', 'phone', 'money', 'classA'], 'required'],
            [['userID', 'money', 'classA'], 'integer'],
            [['time'], 'safe'],
            [['nickname', 'openid'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20]
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
            'nickname' => 'Nickname',
            'openid' => 'Openid',
            'phone' => '名称（手机号）',
            'time' => '日期',
            'money' => '提现金额（元）',
            'classA' => 'Class A',
        ];
    }
}
