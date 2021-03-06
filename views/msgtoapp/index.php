<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MsgtoappSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="msgtoapp-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建消息对应应用', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'msgid',
            //'id',
            [
				'attribute' => 'appicon',
				'label'=>'图标',
				'value'=>'appicon',
				'format' => ['image',['width'=>'40','height'=>'40']],
			],
            
            'appid',
			
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
