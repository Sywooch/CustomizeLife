<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UsertoappSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="usertoapp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建用户下载的应用', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'userid',
            'appid',
            //'created_at',
        	[
        	'attribute' => 'created_at',
        				'label'=>'下载时间',
        						'value'=>
        						function($model){
        						return  date('Y-m-d H:i:s',$model->created_at);   //主要通过此种方式实现
        		},
        		'headerOptions' => ['width' => '170'],
        	],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
