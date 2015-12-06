<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="message-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a('创建消息', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'userid',
            'content',
            //'kind',
        	'appstars',
        	'appkinds',
        	//'area',
        		[
				'attribute' => 'appid',
				//'label'=>'图标',
				//'value'=>'appid',
				'format' => ['image',['width'=>'40','height'=>'40']],
				],
             [
				'attribute' => 'created_at',
				'label'=>'创建时间',
				'value'=>
				function($model){
				return  date('Y-m-d H:i:s',$model->created_at);   //主要通过此种方式实现
							},
				'headerOptions' => ['width' => '170'],
			],

           	[
    			'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {delete}',
		    	'buttons' => [
			        'view' => function ($url, $model, $key) {
				        $options = [
				        	'title' => Yii::t('yii', 'View'),
				        		'aria-label' => Yii::t('yii', 'View'),
				        		'data-pjax' => '0',
				        ];
			        	return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
					},
					'updateofmsg' => function ($url, $model, $key) {
						$options = [
							'title' => Yii::t('yii', 'Update'),
							'aria-label' => Yii::t('yii', 'Update'),
							'data-pjax' => '0',
						];
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
			        },
			        'delete' => function ($url, $model, $key) {
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
