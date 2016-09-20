<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "userRecharge".
 *
 * @property string $ID
 * @property string $userID
 * @property string $userName
 * @property string $time
 * @property integer $gbRecharge
 * @property integer $gbExchange
 * @property integer $gbCash
 */
class UserRecharge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userRecharge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userID', 'userName', 'gbRecharge', 'gbExchange', 'gbCash'], 'required'],
            [['userID', 'gbRecharge', 'gbExchange', 'gbCash'], 'integer'],
            [['time'], 'safe'],
            [['userName'], 'string', 'max' => 20]
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
            'time' => '日期',
            'gbRecharge' => '充股币数',
            'gbExchange' => '股币兑换数',
            'gbCash' => '股币兑换金额（元）',
        ];
    }
}
