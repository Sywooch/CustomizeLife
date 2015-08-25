<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\modules\v1\models\Appcomments;

/* @var $this yii\web\View */
/* @var $model app\models\app */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="app-view">

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
            'name',
            'version',
        	'profile',
            'android_url:url',
            'ios_url:url',
            'stars',
            'downloadcount',
            'commentscount',
        	'introduction',
            'updated_at',
            'size',
			[
					'attribute'=>'图标',
					'value'=>$model->icon,
					'format' => ['image',['width'=>'100','height'=>'100']],
			],
			'kind',
            'updated_log',
    		[
    				'attribute'=>'评论',
    				'value'=>'<a href='.'/appcomments/index?AppcommentsSearch%5Bappid%5D='.$model->name.'&amp;AppcommentsSearch%5Buserid%5D=&amp;AppcommentsSearch%5Busernickname%5D=&amp;AppcommentsSearch%5Bcommentstars%5D=&amp;AppcommentsSearch%5Bcomments%5D=&amp;sort=created_at'.'>点击这里</a>',
    				'format' => ['html'],
    		],
        ],
    ]); 
    echo '<h2>图片</h2>';
    for($i=0;$i<count($apptopicture);$i++) {
    	echo '<a href="/apptopicture/view/'.$apptopicture[$i]['id'].'">';
    	echo Html::img($apptopicture[$i]['picture'],['width'=>'240','height'=>'400']);
    	echo '</a>';
    	echo '&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp';
    }
    
    ?>
 
</div>
