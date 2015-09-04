<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Tag */
/* @var $form yii\widgets\ActiveForm */
?>
<html lang="en-US" style="padding-left:15px">
<div class="tag-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first')->textInput(['maxlength' => true]) ?>

    <?//= $form->field($model, 'second')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'commend')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
