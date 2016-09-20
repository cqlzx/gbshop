<?php

namespace backend\controllers;

use Yii;
use backend\models\Advertise;
use backend\models\UploadIcon;
use yii\web\UploadedFile;


class AdvertiseController extends \yii\web\Controller
{
	public $enableCsrfValidation = false;
	public $layout = "jf-main";
    public function actionIndex()
    {
        return $this->render('index');
    }
	public function actionAdd(){
		//添加广告
		$request = Yii::$app->request;
		$classA = $request->post("classA");
		$advertise = new Advertise();
		$uploadIcon = new UploadIcon();
		$advertise->level = ($classA) ? Advertise::CLASSPAGE : Advertise::HOMEPAGE;
		$advertise->classA = $classA;
		$uploadIcon->path = "advertise";
		$uploadIcon->image = UploadedFile::getInstanceByName('pic');
		if ($uploadIcon->image != null && $uploadIcon->upload()) {
			if($advertise->pic != "" && file_exists($advertise->pic)){
					unlink($advertise->pic);
			}
			$advertise->pic = $uploadIcon->newname;
		}
		if($advertise->save()){
			echo json_encode(array('status' => 200, 'data'=>array('pic'=>$advertise->pic, 'id' => $advertise->ID)));
		}else{
			echo json_encode(array('status' => 400, 'errors' => $advertise->getErrors()));
		}
	}
	public function actionDelete(){
		$request = Yii::$app->request;
		$id = $request->post("id");
		$model = Advertise::findOne($id);
		if($model){
			if($model->pic != "" && file_exists($model->pic)){
					unlink($model->pic);
			}
			if($model->delete()){
				echo json_encode(array("status" => 200 ));
			}else{
				echo json_encode(array("status" => 400, 'message' => '删除失败'));
			}
		}else{
			echo json_encode(array("status" => 400, 'message' => '非法id'));
		}
		
	}

}
