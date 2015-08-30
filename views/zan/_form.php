<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Zan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="zan-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'myid')->textInput() ?>

    <?= $form->field($model, 'msgid')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
