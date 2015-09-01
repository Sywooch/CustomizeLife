<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="tag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建二级标签', ['createoftag?first='.$first], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'first',
            'second',
            //'commend',

            //['class' => 'yii\grid\ActionColumn'],
        		[
        		'class' => 'yii\grid\ActionColumn',
				'template' => '{viewoftag} {updateoftag} {deleteoftag}',
        		'buttons' => [
        			'viewoftag' => function ($url, $model, $key) {
        			$options = [
        				'title' => Yii::t('yii', 'View'),
        				'aria-label' => Yii::t('yii', 'View'),
        				'data-pjax' => '0',
        					];
        				return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
					},
        															'updateoftag' => function ($url, $model, $key) {
        															$options = [
        												'title' => Yii::t('yii', 'Update'),
        												'aria-label' => Yii::t('yii', 'Update'),
        														'data-pjax' => '0',
        														];
        														return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
        															},
        															'deleteoftag' => function ($url, $model, $key) {
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
