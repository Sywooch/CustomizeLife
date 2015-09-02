<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\FriendSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="friend-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加关注', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'myid',
            'mynickname',
			[
			'attribute' => 'myicon',
			'label'=>'头像',
			'value'=>'myicon',
			'format' => ['image',['width'=>'40','height'=>'40']],
			],
			
            'friendid',
			'friendnickname',
            [
             	'attribute' => 'friendicon',
				'label'=>'头像',
				'value'=>'friendicon',
				'format' => ['image',['width'=>'40','height'=>'40']],
			],
        	//'friendname',

           // ['class' => 'yii\grid\ActionColumn'],
    		[
    		'class' => 'yii\grid\ActionColumn',
				'template' => '{viewall} {updateall} {deleteall}',
    								'buttons' => [
    										'viewall' => function ($url, $model, $key) {
    										$options = [
    			'title' => Yii::t('yii', 'View'),
    					'aria-label' => Yii::t('yii', 'View'),
    					'data-pjax' => '0',
    					];
    					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
					},
					'updateall' => function ($url, $model, $key) {
    			$options = [
							'title' => Yii::t('yii', 'Update'),
    									'aria-label' => Yii::t('yii', 'Update'),
    											'data-pjax' => '0',
    													];
    													return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
			        },
			        'deleteall' => function ($url, $model, $key) {
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
