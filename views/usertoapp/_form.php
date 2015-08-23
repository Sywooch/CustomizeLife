<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Usertoapp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usertoapp-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'appid')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '下载' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
