<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\form\ActiveForm;
use app\models\appSearch;
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

<?php ActiveForm::end();?>

<p>
   <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
</p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
    		'filterModel'=>$searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
			[
'attribute' => 'icon',
				'label'=>'图标',
				'value'=>'icon',
				'format' => ['image',['width'=>'40','height'=>'40']],
				],
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
            
             'kind',
            // 'updated_log',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
