<?php
namespace serviceconfig\controllers;

use serviceconfig\models\Servicem;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
       $this->layout = 'main';
        $model=new Servicem();
        $configfiles = ['goods'=>'商品','cart'=>'购物车','order'=>'订单','payment'=>'支付'];
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            $str = '<?php '.PHP_EOL;
            $str .= 'return '.PHP_EOL;
            //print_r(\Yii::$app->request->post());exit;
            $filecontent_arr = [];
            if(!empty($model->configfiles)){
                foreach ($model->configfiles as $k=>$confile){
                    $filename = ucfirst($confile);
                    $set = require(\Yii::$app->basePath."/../common/config/services/".$filename.".php");
                    $filecontent_arr = ArrayHelper::merge($filecontent_arr,$set);
                }
            }
            $str .= $this->toPhpCode($filecontent_arr);
            $str .= ';';
            $path = \Yii::$app->basePath."/../common/config/all.php";
            if (@file_put_contents($path, $str) === false) {
                return "Unable to write the file '{$path}'.";
            }
            \Yii::$app->session->setFlash('success', '成功');
            return $this->render('success');
        }
        return $this->render('index',['model'=>$model,'configfiles'=>$configfiles]);
    }

    public function actionView()
    {
        return $this->render('view');
    }

    function toPhpCode($arr,$i=0){
        $i++;
        $tb_i = $i*4;
        $tb = ($i-1)*4;
        $tb1_str = '';
        $tb2_str = '';
        for($j=0;$j<$tb;$j++){
            $tb1_str .= ' ';
        }
        for($jj=0;$jj<$tb_i;$jj++){
            $tb2_str .= ' ';
        }
        $mystr = '';
        if(is_array($arr) && !empty($arr)){
            $mystr .= PHP_EOL .$tb1_str.'['.PHP_EOL;
            $t_arr = [];
            foreach($arr as $k => $v){
                $key   = '';
                $value   = '';
                if(is_string($k)){
                    $key = "'".$k."'";
                }else{
                    $key = $k;
                }
                if(is_array($v) && !empty($v)){
                    $value = $this->toPhpCode($v,$i);
                }else if(is_array($v) && empty($v)){
                    $value = '[]';

                }else{
                    if(is_string($v)){
                        $value = "'".$v."'";
                    }else if(is_bool($v)){
                        if($v){
                            $value = 'true';
                        }else{
                            $value = 'false';
                        }
                    }else{
                        if(is_null($v)){
                            $v = "''";
                        }
                        $value = $v;
                    }

                }
                $t_arr[] = $tb2_str.$key."=>".$value;
            }
            $mystr .= implode(','.PHP_EOL,$t_arr);
            $mystr .= PHP_EOL .$tb1_str.']'. PHP_EOL;
        }
        return $mystr;
    }
}
