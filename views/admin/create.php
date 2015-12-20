<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\app */
$this->title = '创建应用';
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="app-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    	//'allkind1'=>$allkind1,
    	'allkind2'=>$allkind2,
    		'allkindlab'=>$allkindlab,
    ]) ?>

</div>

