<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Profession */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profession-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'profession')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
