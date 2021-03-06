<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\CollectPerson */

$this->title = '更新个人收藏: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Collect People', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<html lang="en-US" style="padding-left:15px">
<div class="collect-person-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
