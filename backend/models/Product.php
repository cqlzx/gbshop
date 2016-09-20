<?php

namespace backend\models;



use Yii;
use \yii\data\Pagination;
/**
 * This is the model class for table "product".
 *
 * @property string $ID
 * @property integer $classA
 * @property string $shopID
 * @property string $shopName
 * @property string $name
 * @property string $description
 * @property integer $gbPrice
 * @property integer $cashPrice
 * @property string $photo
 * @property integer $numAll
 * @property integer $numLeft
 * @property string $beginTime
 * @property integer $gbBuy
 * @property integer $zeroBuy
 * @property integer $todayBuy
 * @property integer $adBuy
 * @property integer $adLeft
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 const CHECKED = 1;
	 const UNCHECKED = 0;
	 const COEFFICIENT = 2;
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['classA', 'shopID', 'shopName', 'name', 'description', 'gbPrice', 'cashPrice', 'photo'], 'required'],
            [['classA', 'shopID', 'gbPrice', 'cashPrice', 'numAll', 'numLeft', 'gbBuy', 'zeroBuy', 'todayBuy', 'adBuy', 'adLeft'], 'integer'],
            [['beginTime'], 'safe'],
            [['shopName', 'name', 'photo'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => '产品ID',
            'classA' => '一级分类',
            'shopID' => '所属商家',
            'shopName' => '店铺名称',
            'name' => '产品名称',
            'description' => '产品描述',
            'gbPrice' => '股币价',
            'cashPrice' => '现金价',
            'photo' => '产品图片',
            'numAll' => '产品库存',
            'numLeft' => '产品剩余库存',
            'beginTime' => '开抢时间',
            'gbBuy' => '股币惠购',
            'zeroBuy' => '0元换购',
            'todayBuy' => '今日特惠',
            'adBuy' => '购买广告',
            'adLeft' => '剩余点击次数',
        ];
    }
	public function getProdectByShop($params_input){
		$wheres = array();
		$params = array();
		foreach($params_input as $key => $value){
			if($key == "shopName"){
				$wheres[] = "$key like :$key";
				$params[":$key"] = '%' . $value . '%';
			}else{
				$wheres[] = "$key=:$key";
				$params[":$key"] = $value;
			}
			
		}
		$where  = implode(" and ", $wheres);
		if($where != '') $where = " where $where ";
		$model = new Product();
		$connection = $model->getDb();		   
		$totalCount = $connection->createCommand("select count(*) as num from product $where order by shopID")
				   ->bindValues($params)
				   ->queryOne()['num'];
		$pages = new Pagination(['totalCount' => $totalCount, 'pageSize'=>10]); 	
		$data = $connection->createCommand("select * from product $where  order by shopID limit ".$pages->limit." offset ".$pages->offset)
				   ->bindValues($params)
				   ->queryAll();
		return array("data"=>$data,  'pages'=>$pages);
		
	}
}
