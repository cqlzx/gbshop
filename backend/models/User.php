<?php

namespace backend\models;

use Yii;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property string $ID
 * @property string $openID
 * @property string $nickname
 * @property integer $sex
 * @property string $portrait
 * @property string $phone
 * @property integer $gbLeft
 * @property integer $adEarned
 * @property double $cashLeft
 * @property double $totalWithdrawCash
 * @property string $shopID
 * @property string $birthday
 * @property string $shopName
 * @property integer $classA
 * @property integer $role
 * @property integer $state
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
	const USER = 1;  		//role 用户
	const CLERK = 2;  		//role 店员
	const SHOPKEEPER = 3; 	//role 店长
	const APPLYING = 1; //state = 1，申请中
	const PASSED = 2;   //state = 2, 审核通过
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
	
	/**
     * 根据给到的ID查询身份。
     *
     * @param string|integer $id 被查询的ID
     * @return IdentityInterface|null 通过ID匹配到的身份对象
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * 根据 token 查询身份。
     *
     * @param string $token 被查询的 token
     * @return IdentityInterface|null 通过 token 得到的身份对象
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string 当前用户ID
     */
    public function getId()
    {
        return $this->ID;
    }

    /**
     * @return string 当前用户的（cookie）认证密钥
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
