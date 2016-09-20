<?php
namespace backend\models;

use Yii\base\Model;
use Yii\web\UploadedFile;

/*�ļ��ϴ�*/
class UploadIcon extends Model
{
    /**
     * @var UploadedFile
     */
    public $image;
	public $path;//�ĸ��ļ����µ�
	public $newname;//�µ�·��
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
			echo "���ϴ�png��jpg��gif��ʽ�ļ�";
            return false;
        }
    }
}
