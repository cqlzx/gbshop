<?php
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use backend\models\ClassA;
use backend\models\ClassB;
use backend\models\Circle;
use backend\models\Admin;
use backend\models\UploadIcon;
use yii\web\UploadedFile;
use backend\models\Icon;

/*输出界面*/
class ClassController extends Controller{
	public $enableCsrfValidation = false;
	public $layout = "jf-main"; //布局文件
	
	/*分类页面*/
	public function actionIndex(){
		
		return $this->render("index");
	}
	public function actionClassBDelete(){
		//二级分类删除
		$request = Yii::$app->request;
		if($request->isPost){
			$id = $request->post('id');
			if($id == null) return;
			$item = ClassB::findOne($id);
			$item->delete();
		}	
		$this->redirect(Url::to(['class/index']));
	}
	public function actionCircleDelete(){
		//商圈分类删除
		$request = Yii::$app->request;
		if($request->isPost){
			$id = $request->post('id');
			if($id == null) return;
			$item = Circle::findOne($id);
			$item->delete();
		}
		$this->redirect(Url::to(['class/index']));
	}
	public function actionClassBSequence(){
		//修改二级分类顺序
		$request = Yii::$app->request;
		$classA = $request->post("classA", 1); 
		$items = json_decode($request->post('sequence'));
		$count = count($items);
		for($i = 1; $i <= $count; $i++){
			$classB = ClassB::findOne($items[$i-1]->id);
			$classB->sequence = $i;
			$classB->save();
		}
		$this->redirect(Url::to(['class/index', 'id'=>$classA]));

	}	
	public function actionCircleSequence(){
		//修改商圈顺序
		$request = Yii::$app->request;
		$items = json_decode($request->post('sequence'));
		$count = count($items);
		for($i = 1; $i <= $count; $i++){
			$classB = Circle::findOne($items[$i-1]->id);
			$classB->sequence = $i;
			$classB->save();
		}
		$this->redirect(Url::to(['class/index']));

	}
	public function actionIcon(){
		return $this->render("icon");
	}
	public function actionClassAUpdate(){
		//修改一级分类的图片和名称
		$request = Yii::$app->request;
		$id = 1;
		if($request->isPost){
			$name = $request->post("name");
			$id = $request->post("id");
			$classA = ClassA::findOne($id);
			$classA->name = $name;
			$uploadIcon = new UploadIcon();
			$uploadIcon->path = "classA";
			$uploadIcon->image = UploadedFile::getInstanceByName('icon');
			if ($uploadIcon->image != null && $uploadIcon->upload()) {
				$pic = $uploadIcon->newname;
				if($classA->pic != ""){
						unlink($classA->pic);
				}
				$classA->pic = $pic;
			}
			$classA->save();
		}
		
		$this->redirect(Url::to(['class/index','id' => $id]));
	}
	public function actionIconUpdate(){
		//修改首页图标
		$request = Yii::$app->request;
		if($request->isPost){
			$id = $request->post("ID");
			$icon = icon::findOne($id);
			$icon->attributes = $request->post();
			$uploadIcon = new UploadIcon();
			$uploadIcon->path = "icon";
			$uploadIcon->image = UploadedFile::getInstanceByName('pic');
			if ($uploadIcon->image != null && $uploadIcon->upload()) {
				$pic = $uploadIcon->newname;
				if($icon->pic != ""){
						unlink($icon->pic);
				}
				$icon->pic = $pic;
			}
			$icon->save();
		}
		
		$this->redirect(Url::to(['class/icon']));
	}
	public function actionClassBAdd(){
		//增加二级分类
		$request = Yii::$app->request;
		$classA = $request->post("classA");
		$name = $request->post("name");
		$classB = new ClassB();
		$classB->name = $name;
		$classB->classA = $classA;
		$classB->save();
		$this->redirect(Url::to(['class/index','id' => $classA]));
	}
	public function actionCircleAdd(){
		//增加商圈分类
		$request = Yii::$app->request;
		$name = $request->post("name");
		$circle = new Circle();
		$circle->name = $name;
		$circle->save();
		$this->redirect(Url::to(['class/index']));
	}
	public function actionTest(){
		// $this->layout = false;
		$model = new Admin();
		return $this->render("test", ['model'=>$model]);
	}
	
	private function setHeader($status)
    {

        $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
        $content_type="application/json; charset=utf-8";

        header($status_header);
        header('Content-type: ' . $content_type);
        header('X-Powered-By: ' . "Nintriva <nintriva.com>");
    }
    private function _getStatusCodeMessage($status)
    {
        // these could be stored in a .ini file and loaded
        // via parse_ini_file()... however, this will suffice
        // for an example
        $codes = Array(
            200 => 'OK',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
        );
        return (isset($codes[$status])) ? $codes[$status] : '';
    }
}
