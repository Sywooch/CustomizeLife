<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\CollectPerson */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Collect People', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="collect-person-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'userid',
            [
				'attribute' => 'created_at',
				'label'=>'创建时间',
				'value'=>date('Y-m-d H:i:s',$model->created_at),

				'headerOptions' => ['width' => '170'],
				],
            'app',
        ],
    ]) ?>

</div>
