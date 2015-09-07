<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Push */

$this->title = '再次推送: ';
$this->params['breadcrumbs'][] = ['label' => 'Pushes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<html lang="en-US" style="padding-left:15px">
<div class="push-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
