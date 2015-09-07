<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Push */

$this->title = '推送消息';
$this->params['breadcrumbs'][] = ['label' => 'Pushes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="push-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    		'allkind2'=>$allkind2,
    ]) ?>

</div>
