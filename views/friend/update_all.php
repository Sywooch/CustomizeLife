<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Friend */

$this->title = '更新好友关系: ';
$this->params['breadcrumbs'][] = ['label' => 'Friends', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<html lang="en-US" style="padding-left:15px">
<div class="friend-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formall', [
        'model' => $model,
    ]) ?>

</div>
