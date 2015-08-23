<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Msgtoapp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msgtoapp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'msgid')->textInput() ?>

    <?= $form->field($model, 'appid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
