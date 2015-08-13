<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">

<div class="app-app">

    <h1><?= Html::encode($this->title) ?></h1>

    
 <?php $form=ActiveForm::begin([
 		'id' => 'login-form-inline',
 		'type' => ActiveForm::TYPE_INLINE
 		]);?>
 <?=$form->field($model,'name')->textInput(["placeholder"=>"应用名称"]); ?>
 
 <div class="form-group">
            <?=  Html::submitButton('搜索', ['class'=>'btn btn-success','name' =>'submit-button']) ?>
             
            </div>
<?php ActiveForm::end();?>
 <?= GridView::widget([
        'dataProvider' => $appdata,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'version',
        	'profile',
            //'android_url:url',
            //'ios_url:url',
             'stars',
             'downloadcount',
            'commentscount',
            // 'introduction',
             'updated_at',
             'size',
             'icon',
            // 'updated_log',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<p>&nbsp</p>
<p>
   <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'version',
        		'profile',
            //'android_url:url',
            //'ios_url:url',
             'stars',
             'downloadcount',
        		'commentscount',
            // 'introduction',
             'updated_at',
             'size',
             'icon',
            // 'updated_log',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
