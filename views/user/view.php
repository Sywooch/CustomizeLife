<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\User */

$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="user-view">

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
         //   'id',
			'nickname',
           		[
				'attribute'=>'我的好友',
				'value'=>'<a href='.'/friend/index?FriendSearch%5Bmyid%5D='.$model->phone.'>点击这里</a>',
				'format' => ['html'],
			],
    		[
    		'attribute'=>'我的关注',
    				'value'=>'<a href='.'/follow/index?FollowSearch%5Bmyid%5D='.$model->phone.'>点击这里</a>',
    						'format' => ['html'],
    								],
    		[
    			'attribute'=>'我发表的消息',
    			//'value'=>'<a href='.'/message/index?MessageSearch%5Bid%5D=&MessageSearch%5Buserid%5D=18354765214&MessageSearch%5Bcontent%5D=&MessageSearch%5Bkind%5D=&MessageSearch%5Barea%5D=&MessageSearch%5Bcreated_at%5D='.'>点击这里</a>',
    			'value'=>'<a href='.'/message/index?MessageSearch%5Bid%5D=&MessageSearch%5Buserid%5D='.$model->phone.'&MessageSearch%5Bcontent%5D=&MessageSearch%5Bkind%5D=&MessageSearch%5Barea%5D=&MessageSearch%5Bcreated_at%5D=&sort=-created_at'.'>点击这里</a>',
    			'format' => ['html'],
    		],
    		[
    			'attribute'=>'我上传的应用',
    			'value'=>'<a href='.'/usertoapp/index?UsertoappSearch%5Buserid%5D='.$model->phone.'&UsertoappSearch%5Bappid%5D=&UsertoappSearch%5Bcreated_at%5D=&sort=created_at'.'>点击这里</a>',
    			'format' => ['html'],
    		],
    		[
    			'attribute'=>'我收藏的应用',
    			'value'=>'<a href='.'/collect-person/index?CollectPersonSearch%5Buserid%5D='.$model->phone.'&CollectPersonSearch%5Bapp%5D=&CollectPersonSearch%5Bcreated_at%5D=&sort=created_at'.'>点击这里</a>',
    			'format' => ['html'],
    		],
    		
//             [
// 				'attribute'=>'是否明星',
// 				'value'=>$model->famous==1?'是':'否',
// 				//'format' => ['image',['width'=>'150','height'=>'150']],
// 			],
            'shared',
			'favour',
			
            //'thumb:image',
			[
				'attribute'=>'头像',
				'value'=>$model->thumb,
				'format' => ['image',['width'=>'150','height'=>'150']],
			],
            'phone',
            'gender',
            'area',
            'job',
            'hobby',
            'signature',
			[
				'attribute' => 'created_at',
				//'label'=>'创建时间',
				'value'=>date('Y-m-d H:i:s',$model->created_at),
				'headerOptions' => ['width' => '170'],
			],
			[
					'attribute' => 'updated_at',
					//'label'=>'创建时间',
					'value'=>date('Y-m-d H:i:s',$model->updated_at),
					'headerOptions' => ['width' => '170'],
			],
        ],
    ]) ?>

</div>
