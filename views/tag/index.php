<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = 'Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="tag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建顶级标签', ['create'], ['class' => 'btn btn-success']) ?>
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
