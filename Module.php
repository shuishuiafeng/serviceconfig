<?php
namespace serviceconfig;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;
/**
 * Created by PhpStorm.
 * User: dongxiaofeng
 * Date: 2017/11/13
 * Time: 9:51
 */
class Module extends \yii\base\Module implements BootstrapInterface{

    public $controllerNamespace = 'serviceconfig\controllers';
    public $allowedIPs = ['127.0.0.1', '::1'];

    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<id:\w+>', 'route' => $this->id . '/default/view'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => $this->id . '/<controller>/<action>'],
            ], false);
        }
    }
}
