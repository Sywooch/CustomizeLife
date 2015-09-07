<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Push */

$this->title = "";
$this->params['breadcrumbs'][] = ['label' => 'Pushes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="push-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('再次推送', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除该条记录?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'title',
            'message',
            'label',
            [
				'attribute' => 'created_at',
				'label'=>'推送时间',
				'value'=>date('Y-m-d H:i:s',$model->created_at),
				
				'headerOptions' => ['width' => '170'],
			],
        ],
    ]) ?>

</div>
