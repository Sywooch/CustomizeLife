<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Friend */

$this->title = '添加好友关系';
$this->params['breadcrumbs'][] = ['label' => 'Friends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="friend-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_formall', [
        'model' => $model,
    ]) ?>

</div>