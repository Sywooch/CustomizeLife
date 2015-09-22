<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Tag */

$this->title ="";
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
                'confirm' => '确定删除该条记录?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'first',
            'second',
			[
               'attribute'=>'应用',
               //'value'=>'<a href='.'/admin/app?AppcommentsSearch%5Bappid%5D='.$model->name.'&amp;AppcommentsSearch%5Buserid%5D=&amp;AppcommentsSearch%5Busernickname%5D=&amp;AppcommentsSearch%5Bcommentstars%5D=&amp;AppcommentsSearch%5Bcomments%5D=&amp;sort=created_at'.'>点击这里</a>',
		       'value'=>'<a href='.'/admin/tagrecom?appSearch%5Bkind%5D='.$model->second.'>二级标签的应用</a>',
               'format' => ['html'],
		    ],
            //'commend',
        ],
    ]) ?>

</div>
