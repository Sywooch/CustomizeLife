<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="staruser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('添加用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'pwd',
            //'authKey',
        	'phone',
[
    		'attribute' => 'thumb',
'label'=>'头像',
		'value'=>'thumb',
				'format' => ['image',['width'=>'40','height'=>'40']],
						],
        	'nickname',
            //'famous',
            'shared',
            //'thumb',
            'gender',
            // 'area',
             'job',
             'hobby',
            'signature',
            // 'created_at',
            // 'updated_at',
    		[
    		//if ($date->famous==0){
    		'label'=>'是否推荐',
			//}
    				'format'=>'raw',
    				'value' => function($data){
    						$url = "recom";
    						$recom="";
    						//var_dump($data->phone);
    						if($data->authKey==0){
								$recom="推荐";
								}else{
									$recom="取消推荐";
								}
							
    						return Html::a($recom, "recom/".$data->id, ['title' => '审核']);
    		}
    		],
    		[
    		//if ($date->famous==0){
    		'label'=>'转为普通用户',
    				//}
    				'format'=>'raw',
    				'value' => function($data){
    				$url = "recom";
    				$recom="转换";
    			//var_dump($data->phone);
    			//     							if($data->authKey==0){
    			//     							$recom="推荐";
    			//     						}else{
    			//     						$recom="取消推荐";
    			//     						}
    		
    			return Html::a($recom, "down/".$data->id, ['title' => '转换']);
    				
    		}
    		
    		],
            ['class' => 'yii\grid\ActionColumn'],
    		
    		    
        ],
    ]); ?>

</div>
