<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Usertoapp */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Usertoapps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="usertoapp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'appid',
            [
				'attribute' => 'created_at',
				'label'=>'创建时间',
				'value'=>date('Y-m-d H:i:s',$model->created_at),

				'headerOptions' => ['width' => '170'],
				],
        ],
    ]) ?>

</div>
