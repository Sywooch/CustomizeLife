<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apps';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="app-index">

    <h1><?= Html::encode($this->title) ?></h1>

    
    <?php $form=ActiveForm::begin();?>
 <?=$form->field($model,'user')->textInput(["placeholder"=>"应用名称"]); ?>
 <div class="form-group">
            <?=  Html::submitButton('搜索', ['class'=>'btn btn-primary','name' =>'submit-button']) ?>
             
            </div>
<?php ActiveForm::end();?>

<p>
   <?= Html::a('Create App', ['create'], ['class' => 'btn btn-success']) ?>
</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'version',
            //'android_url:url',
            //'ios_url:url',
             'stars',
             'downloadcount',
            // 'introduction',
             'updated_at',
             'size',
             'icon',
            // 'updated_log',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
