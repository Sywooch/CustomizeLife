<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Push */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="push-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textarea(['rows'=>3]) ?>

    <?//= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
    <? $all=array();
    $all["全部用户"]="全部用户";
    foreach ($allkind2 as $second)
    {
    	foreach ($second as $first)
    	{
    		if ($first!=''){
    			$all[$first]=$first;
    		}
    	}
    }
    
    echo $form->field($model, 'label[]')->checkboxList($all) ?>

    <?//= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '推送' : '推送', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
