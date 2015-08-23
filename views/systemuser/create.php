<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Systemuser */

$this->title = '创建系统用户';
$this->params['breadcrumbs'][] = ['label' => 'Systemusers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="systemuser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
