<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $ID
 * @property string $openID
 * @property string $nickname
 * @property integer $sex
 * @property string $birthday
 * @property string $portrait
 * @property string $phone
 * @property string $address
 * @property integer $gbLeft
 * @property integer $adEarned
 * @property double $cashLeft
 * @property double $totalWithdrawCash
 * @property string $shopID
 * @property string $shopName
 * @property integer $classA
 * @property integer $role
 * @property integer $state
 */
class Userbak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openID', 'nickname'], 'required'],
            [['sex', 'gbLeft', 'adEarned', 'shopID', 'classA', 'role', 'state'], 'integer'],
            [['birthday'], 'safe'],
            [['cashLeft', 'totalWithdrawCash'], 'number'],
            [['openID', 'nickname', 'portrait', 'shopName'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 200],
            [['phone'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '用户ID',
            'openID' => 'openID',
            'nickname' => '昵称',
            'sex' => '性别',
            'birthday' => '生日',
            'portrait' => '头像',
            'phone' => '手机号',
            'address' => '收获地址',
            'gbLeft' => '股币余额',
            'adEarned' => '广告赚股币数',
            'cashLeft' => '现金余额',
            'totalWithdrawCash' => '累计提现金额',
            'shopID' => '隶属商家',
            'shopName' => '所属商店名称',
            'classA' => '一级分类',
            'role' => '角色，未选0，用户1， 商家2，店员3',
            'state' => '当role=2或role=3时：1申请中，2审核通过',
        ];
    }
}
