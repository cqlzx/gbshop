<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "advertise".
 *
 * @property string $ID
 * @property integer $level
 * @property string $pic
 * @property string $classA
 */
class Advertise extends \yii\db\ActiveRecord
{
	const HOMEPAGE = 1;
	const CLASSPAGE = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advertise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'pic'], 'required'],
            [['level', 'classA'], 'integer'],
            [['pic'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '广告ID',
            'level' => '级别 1主页 2分类页',
            'pic' => '图片地址',
            'classA' => '一级分类',
        ];
    }
	 //返回首页广告列表
	 public function advertiseIndex(){
		 return $this->find()->where(['level' => $this::HOMEPAGE])->asArray()->all();
	 }
	 //返回根据分类返回分类页广告列表
	 public function advertiseClass($classA){
		 return $this->find()->where(['level' => $this::CLASSPAGE, 'classA' => $classA])->asArray()->all();
	 }
}
