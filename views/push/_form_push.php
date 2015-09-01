<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Message */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(); ?>

    <?//= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'content')->textarea(['rows'=>6])?>

    
    <?//= $form->field($model, 'area')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '推送' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
