<?php
namespace backend\models;

use Yii\base\Model;
use Yii\web\UploadedFile;

/*文件上传*/
class UploadIcon extends Model
{
    /**
     * @var UploadedFile
     */
    public $image;
	public $path;//哪个文件夹下的
	public $newname;//新的路径
    public function rules()
    {
        return [
            [['image'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
			$name = date("YmdHis");
			$this->newname = "image/" . $this->path . "/$name" . "." . $this->image->extension;
			$this->image->saveAs($this->newname);
            return true;
        } else {
			echo "请上传png，jpg，gif格式文件";
            return false;
        }
    }
}
