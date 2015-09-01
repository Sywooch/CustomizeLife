<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Appcomments */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Appcomments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="appcomments-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该条记录?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'appid',
            'userid',
			[
				'attribute'=>'头像',
				'value'=>$model->userthumb,
				'format' => ['image',['width'=>'50','height'=>'50']],
			],
            'usernickname',
            'commentstars',
            'comments',
            [
				'attribute' => 'created_at',
				'label'=>'创建时间',
				'value'=>date('Y-m-d H:i:s',$model->created_at),

				'headerOptions' => ['width' => '170'],
				],
            'title',
        ],
    ]) ?>

</div>
