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
   <?//= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
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
        		//'commentscount',
            // 'introduction',
             [
				'attribute' => 'updated_at',
				'label'=>'创建时间',
				'value'=>
				function($model){
				return  date('Y-m-d H:i:s',$model->updated_at);   //主要通过此种方式实现
							},
				'headerOptions' => ['width' => '170'],
			],
              'size',
            
             'kind',
            // 'updated_log',

          [
    			'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {userupdate} {userdelete}',
		    	'buttons' => [
			        'view' => function ($url, $model, $key) {
				        $options = [
				        	'title' => Yii::t('yii', 'View'),
				        		'aria-label' => Yii::t('yii', 'View'),
				        		'data-pjax' => '0',
				        ];
			        	return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
					},
					'userupdate' => function ($url, $model, $key) {
						$options = [
							'title' => Yii::t('yii', 'Update'),
							'aria-label' => Yii::t('yii', 'Update'),
							'data-pjax' => '0',
						];
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
			        },
			        'userdelete' => function ($url, $model, $key) {
			        	$options = [
			        		'title' => Yii::t('yii', 'Delete'),
			        		'aria-label' => Yii::t('yii', 'Delete'),
			        		'data-confirm' => Yii::t('yii', '确定要删除该条记录?'),
			        		'data-method' => 'post',
			            	'data-pjax' => '0',
			        	];
			        	return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
			        },
		      	],
			],
        ],
    ]); ?>

</div>
