<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use backend\models\Shop;
use backend\models\Album;
use backend\models\Photo;
use backend\models\ShopRecharge;
use yii\helpers\Url;
use backend\models\UploadIcon;
use yii\web\UploadedFile;
use backend\models\User;
use yii\data\ActiveDataProvider;
class BusinessController extends Controller{
	public $layout = "jf-main";
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionShopAddForm(){
        $request = Yii::$app->request;
        if($id = $request->get('shopid')){
            $exist = true;
            $shop = Shop::findOne($id);
        }else 
            $exist = false;
        $data['name'] = $exist ? $shop['name'] : "";
        $data['discount'] = $exist ? $shop['discount'] : "";
        $data['classB'] = $exist ? $shop['classB'] : "";
        $data['circle'] = $exist ? $shop['circle'] : "";
        $data['description'] = $exist ? $shop['description'] : "";
        $data['address'] = $exist ? $shop['address'] : "";
        $data['phone'] = $exist ? $shop['phone'] : "";
        $data['information'] = $exist ? $shop['information'] : "";
        $data['attention'] = $exist ? $shop['attention'] : "";
        $data['pic'] = $exist ? $shop['pic'] : "";
        // var_dump($data);
    	return  $this->render('shop-add-form', $data);
    }
    public function actionShopFormSave(){
        $request = Yii::$app->request;
        $shopid = $request->post('shopid');
        $shop = $shopid ? Shop::findOne($shopid) : (new Shop());
        $shop->name = $request->post('name');
        $shop->discount = $request->post('discount');
        $classA = $request->post('classA');
        $shop->classA = $request->post('classA');
        $shop->classB = $request->post('classB');
        $shop->circle = $request->post('circle');
        $shop->description = $request->post('description');
        $shop->address = $request->post('address');
        $shop->phone = $request->post('phone');
        $shop->information = $request->post('information');
        $shop->attention = $request->post('attention');

        $uploadIcon = new UploadIcon();
        $uploadIcon->path = "shop";
        $uploadIcon->image = UploadedFile::getInstanceByName('pic');
        if($uploadIcon->image != null && $uploadIcon->upload()){
            $shop->pic = $uploadIcon->newname;
        }
        if(!$shop->save())
            $shop->errors;
        $this->redirect(Url::toRoute(['business/index', 'classA' => $classA]));
    }
    public function actionSave(){
        $request = Yii::$app->request;
        $id = $request->post('shopid');
        $honour = $request->post('honour');
        $shop = Shop::findOne($id);
        $shop->honour = $honour;
        if($shop->save()){
            echo json_encode(array('status'=>200));
        }else{
            echo json_encode(array('status'=>400, 'errors'=>$model->getErrors()));
        }
    }
    public function actionAlbumAdd(){
        $enableCsrfValidation = false;
        $request = Yii::$app->request;
        $name = $request->post('name');
        $shopid = $request->post('shopid');
        $album = new Album();
        $album->name = $name;
        $album->shopID = $shopid;
        $album->save();
        $this->redirect(Url::to(['business/photo-change','shopid' => $shopid]));
    }
    public function actionAlbumDelete(){
        $request = Yii::$app->request;
        $id = $request->get('albumid');
        $shopid = $request->get('shopid');
        $modelAlbum = Album::findOne($id);
        $modelPhoto = Photo::find()->where(['albumID'=>$id])->all();
        if($modelAlbum){
            $modelAlbum->delete();
            foreach($modelPhoto as $photo){
                unlink($photo->path);
                $photo->delete();
            }
            $this->redirect(Url::to(['business/photo-change','shopid' => $shopid]));
        }else{
            echo json_encode(array("status" => 400, 'message' => '非法id'));
        }
    }
    //商家上传图片页面
    public function actionPhotoChange(){
        $shopid = Yii::$app->request->get('shopid');
        $shopalbums = Album::find()->where(['shopID'=>$shopid])->asArray()->all();
        if(empty($shopalbums)){
            $album = new Album();
            $album->name = '全部';
            $album->shopID = $shopid;
            $album->save();
        }
        return $this->render('photo-change', array('shopid'=>$shopid));
    }
    public function actionPhotoAdd(){
        $request = Yii::$app->request;
        $albumid = $request->post('albumid');
        $shopid = $request->post('shopid');
        $description = $request->post('description');
        $photo = new Photo();
        $photo->description = $description;
        $photo->albumID = $albumid;
        $photo->shopID = $shopid;
        $uploadIcon = new UploadIcon();
        $uploadIcon->path = "shop";
        $uploadIcon->image = UploadedFile::getInstanceByName('pic');
        if($uploadIcon->image != null && $uploadIcon->upload()){
            $photo->path = $uploadIcon->newname;
        }

        if($photo->save()){
            echo json_encode(array('status' => 200, 'data'=>array('pic'=>$photo->path, 'id' => $photo->ID, 'description'=>$photo->description)));
        }else{
            echo json_encode(array('status' => 400, 'errors' => $photo->getErrors()));
        }
    }
    public function actionPhotoDelete(){
        $request = Yii::$app->request;
        $id = $request->post('id');
        $model = Photo::findOne($id);
        if($model){
            unlink($model->path);
            if($model->delete()){
                echo json_encode(array("status" => 200 ));
            }else{
                echo json_encode(array("status" => 400, 'message' => '删除失败'));
            }
        }else{
            echo json_encode(array("status" => 400, 'message' => '非法id'));
        }
    }
    public function actionShopRecharge(){
        $request = Yii::$app->request;
        $id = $request->post("id");
        $name = $request->post("name");
        $discount = $request->post("discount");
        $money = $request->post("buygb");
        $gb = $money / $discount;
        $shopRecharge = new ShopRecharge();
        $shopRecharge->shopID = $id;
        $shopRecharge->shopName = $name;
        $shopRecharge->money = $money;
        $shopRecharge->gb = $gb;
        $shopRecharge->discount = $discount;
		$shop = Shop::findOne($id);
		$shop->gbLeft = $shop->gbLeft + $gb;
		$shop->latestCharge = $money;
		$shop->latestGb = $gb;
		$shop->moneyAll += $money;
		$shopRecharge->classA = $shop->classA;
		$connection = Yii::$app->db;
		$transaction = $connection->beginTransaction();
        if($shopRecharge->save() && $shop->save()){
			$transaction->commit();
            echo json_encode(array("status" => 200, 'data'=>array('gbLeft'=>$shop->gbLeft)));
        }else{
			$transaction->rollBack();
            echo json_encode(array("status" => 400, "errors" => $shopRecharge->getErrors()));
        }
    }
	public function actionClerk(){
		$params = array();
		$shopID = Yii::$app->request->get("shopID");
		$query = User::find()->where(['shopID' => $shopID])->andWhere("role=2 or role=3");
		$params['dataProvider'] = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		$params['shop'] = Shop::find()->where(['ID'=>$shopID])->asArray()->One();
        return $this->render('clerk', $params);
	}
	public function actionClerkSearch(){
		$user = User::findOne(['phone'=>Yii::$app->request->post('phone')]);
		if($user){
			echo json_encode(array("status" => 200, 'data'=>array('nickname'=>$user->nickname)));
		}else{
			echo json_encode(array("status" => 400, 'error'=>'查无用户，请用户先注册'));
		}
	}
	public function actionClerkAdd(){
		$request = Yii::$app->request;
		$shopID = $request->post("shopID");
		$shop = Shop::findOne($shopID);
		$user = User::findOne(['phone' => $request->post('phone')]);
		if($user){
			$user->role = User::CLERK;
			$user->shopID = $shop->ID;
			$user->shopName = $shop->name;
			$user->classA = $shop->classA;
			$user->save();
			echo json_encode(array('status'=>200));
		}else{
			echo json_encode(array('status'=>400));
		}
	}
	
	public function actionClerkDelete(){
		$user = User::findOne(['ID'=>Yii::$app->request->post("userID")]);
		if($user){
			$user->role = User::USER;
			$user->save();
			echo json_encode(array('status'=>200));
		}else{
			echo json_encode(array('status'=>400, 'error'=>'查无此用户'));
		}
	}
	public function actionClerkChange(){
		$user = User::findOne(['ID'=>Yii::$app->request->post("userID")]);
		if($user){
			$user->role = 2 + ($user->role + 1) % 2;
			$user->save();
			echo json_encode(array('status'=>200));
		}else{
			echo json_encode(array('status'=>400, 'error'=>'查无此用户'));
		}
	}
}
