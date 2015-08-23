<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\CollectInteract */

$this->title = '添加互动收藏';
$this->params['breadcrumbs'][] = ['label' => 'Collect Interacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="collect-interact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
