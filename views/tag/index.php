<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="tag-index">

    <h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::Button('创建顶级分类',['value'=>\yii\helpers\Url::to(['create']),'class' => 'showModalButton btn btn-success','id'=>'modalButton']) ?>
</p>
<!--引入模态对话框 -->
<?php
\yii\bootstrap\Modal::begin([
   // 'header' => '<h2>Branches</h2>',
    'id'=>'modal',
    'size'=>'modal-lg',
]);
echo "<div id='modalContent'></div>";

\yii\bootstrap\Modal::end()
?>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a('创建顶级标签', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'first',
            //'second',
            //'commend',
        		[
        		//if ($date->famous==0){
        		'label'=>'是否推荐',
        				//}
        				'format'=>'raw',
        				'value' => function($data){
        						$url = "recom";
        						$recom="";
        							//var_dump($data->phone);
        							if($data->commend==0){
        							$recom="推荐";
        						}else{
        						$recom="取消推荐";
        						}
        							
        									return Html::a($recom, "recom/".$data->id, ['title' => '审核']);
        						}
        						],
          // ['class' => 'yii\grid\ActionColumn'],
       
           [
           'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update} {delete}',
           						'buttons' => [
           								'view' => function ($url, $model, $key) {
           								$options = [
           									'title' => Yii::t('yii', 'View'),
           									'aria-label' => Yii::t('yii', 'View'),
           											'data-pjax' => '0',
           									];
           											return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
					},
           													'update' => function ($url, $model, $key) {
           													$options = [
           										'title' => Yii::t('yii', 'Update'),
           										'aria-label' => Yii::t('yii', 'Update'),
           												'data-pjax' => '0',
           												];
           												
           													\yii\bootstrap\Modal::begin([
           															//'header' => '<h2>Branches</h2>',
           															'id'=>'modal',
           															'size'=>'modal-lg',
           													]);
           													echo "<div id='modalContent'></div>";
           													
           													\yii\bootstrap\Modal::end();
           											
           												return Html::Button('',['style'=>'background:none;border:0;','value'=>\yii\helpers\Url::to(['update','id'=>$model->id]),'class' => 'showModalButton glyphicon glyphicon-pencil','id'=>'modalButton']);
           													},
           													'delete' => function ($url, $model, $key) {
           														$options = [
           																'title' => Yii::t('yii', 'Delete'),
           																		'aria-label' => Yii::t('yii', 'Delete'),
           																				'data-confirm' => Yii::t('yii', '确定要删除该条记录?'),
           																						'data-method' => 'post',
           																						'data-pjax' => '0',
			        	];
           			        	return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
           			        },
           		      	],
           			],
            
        ],
    ]); ?>

</div>
