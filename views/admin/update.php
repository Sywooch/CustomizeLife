<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\app */

$this->title = '更新应用: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apps', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<html lang="en-US" style="padding-left:15px">
<div class="app-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_update', [
        'model' => $model,
    	//'allkind1' => $allkind1,
    	'allkind2' => $allkind2,
    	'apptopicture'=>$apptopicture,
    		'allkindlab'=>$allkindlab,
    ]) ?>

</div>
