<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Reply */

$this->title = '更新回复: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Replies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<html lang="en-US" style="padding-left:15px">
<div class="reply-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
