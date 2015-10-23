<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Message */
//echo $apps;
function getapps($apps,$msgid)
{
	$msg="";
	for($i=0;$i<count($apps);$i++) {
		$msg=$msg.'<a href="/admin/view/'.$apps[$i]['id'].'">';
		$msg=$msg.Html::img($apps[$i]['icon'],['width'=>'50','height'=>'50']);
		$msg=$msg. '</a>';
		$msg=$msg. '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
	};
	$msg=$msg.'<a href="/msgtoapp/indexofmsg?MsgtoappSearch%5Bmsgid%5D='.$msgid.'">';
	$msg =$msg .'添加删除应用';
	$msg=$msg. '</a>';
	$msg=$msg. '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
	return $msg;
}
//$this->title = $model->id;
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
                'confirm' => '确定要删除该条记录?',
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
        	'appstars',
            'appkinds',
        	//'area',
			[
					'attribute'=>'应用',
					'value'=>$model->appid,
					'format' => ['image',['width'=>'100','height'=>'100']],
			],
			[
				'attribute'=>'消息回复',
				'value'=>'<a href='.'/reply/index?ReplySearch%5Bmsgid%5D='.$model->id.'&sort=created_at'.'>点击这里</a>',
				'format' => ['html'],
			],
			[
				'attribute' => 'created_at',
				'label'=>'创建时间',
				'value'=>date('Y-m-d H:i:s',$model->created_at),

				'headerOptions' => ['width' => '170'],
				],
        ],
    ]) ?>

</div>
