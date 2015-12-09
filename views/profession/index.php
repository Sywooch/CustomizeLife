<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProfessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="profession-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'profession',
            //'created_at',

            [
    			'class' => 'yii\grid\ActionColumn',
				'template' => '{delete}',
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
