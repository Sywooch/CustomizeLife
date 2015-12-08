<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Tag */
function getkinds($tags,$first)
{
	$tag="";
	for($i=0;$i<count($tags);$i++) {
// 		$msg=$msg.'<a href="/admin/view/'.$apps[$i]['id'].'">';
// 		$msg=$msg.Html::img($apps[$i]['icon'],['width'=>'50','height'=>'50']);
// 		$msg=$msg. '</a>';
// 		$msg=$msg. '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
	$tag=$tag.$tags[$i]['second'].' ';
	};
	$tag=$tag.'<a href="/tag/indexoftag?TagSearch%5Bfirst%5D='.$first.'">';
	$tag =$tag .'管理二级分类';
	$tag=$tag. '</a>';
	$tag=$tag. '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
	return $tag;
}
//$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="tag-view">

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
            //'id',
            'first',
            //'second',
        	[
        	'attribute'=>'二级标签',
        			'value'=>getkinds($tags,$model->first),
        			'format' => ['html'],
			],
            //'commend',
        ],
    ]) ?>

</div>
