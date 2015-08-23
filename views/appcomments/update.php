<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Appcomments */

$this->title = '更新评论: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Appcomments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<html lang="en-US" style="padding-left:15px">
<div class="appcomments-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
