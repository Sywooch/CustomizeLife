<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Message */
//echo $apps;
function getapps($apps)
{
	$msg="";
	for($i=0;$i<count($apps);$i++) {
		$msg=$msg.'<a href="/admin/view/'.$apps[$i]['id'].'">';
		$msg=$msg.Html::img($apps[$i]['icon'],['width'=>'50','height'=>'50']);
		$msg=$msg. '</a>';
		$msg=$msg. '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
	};
	return $msg;
}
$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="message-view">

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
			'id',
            'userid',
            'content',
            'kind',
        	'area',
			[
				'attribute'=>'应用',
				'value'=>getapps($apps),
				'format' => ['html'],
			],
            'created_at',
        ],
    ]) ?>

</div>
