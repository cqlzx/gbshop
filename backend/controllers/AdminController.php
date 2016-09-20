<?php

namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Admin;

/**
 * AuthController implements the CRUD actions for AuthItem model.
 */
class AdminController extends Controller
{
	public $layout = 'jf-main';
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
       return $this->render('index');
    }

    /**
     * 增加一个管理员
     * @param string $id
     * @return mixed
     */
    public function actionAdd()
    {
		$model = new Admin();
		$model->attributes = Yii::$app->request->post();
		if ($model->save()) {
		   echo json_encode(array('status'=>200));
		} else {
		   echo json_encode(array('status'=>400, 'errors' => $model->getError()));
		}
    }


    /**
     * 修改管理员密码
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$model->attributes = Yii::$app->request->post();
         if ($model->save()) {
           echo json_encode(array('status'=>200));
        } else {
           echo json_encode(array('status'=>400, 'errors' => $model->getErrors()));
        }
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete()){
			echo  json_encode(array('status'=>200));
        } else {
           echo json_encode(array('status'=>400));
        }
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
