<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div>
    <?php $form=ActiveForm::begin(['action' => ['default/index'],'method'=>'post']) ?>
    <?= $model->attributeLabels()['configfiles']; ?>:
    <?= $form->field($model, 'configfiles')->checkboxList($configfiles)->label(false) ?>
    <?= Html::submitButton('提交') ?>

    <?= Html::resetButton('重置') ?>

    <?php ActiveForm::end(); ?>
</div>
