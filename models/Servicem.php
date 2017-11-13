<?php
namespace serviceconfig\models;

use yii\base\Model;

class Servicem extends Model{
    public $configfiles;

    public function rules(){
        return [
            [['configfiles'], 'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'configfiles' => "配置文件列表",
        ];
    }

}
