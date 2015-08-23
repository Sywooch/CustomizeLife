<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\AppcommentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="appcomments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'appid') ?>

    <?= $form->field($model, 'userid') ?>

    <?= $form->field($model, 'userthumb') ?>

    <?= $form->field($model, 'usernickname') ?>

    <?php // echo $form->field($model, 'commentstars') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
