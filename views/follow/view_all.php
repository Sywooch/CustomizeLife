<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Friend */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Friends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="friend-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['updateall', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['deleteall', 'id' => $model->id], [
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
            'myid',
'mynickname',
[
'attribute'=>'图标',
'value'=>$model->myicon,
'format' => ['image',['width'=>'100','height'=>'100']],
],
            'friendid',
'friendnickname',
[
'attribute'=>'图标',
'value'=>$model->friendicon,
'format' => ['image',['width'=>'100','height'=>'100']],
],
        	//'isfriend',
        ],
    ]) ?>

</div>
