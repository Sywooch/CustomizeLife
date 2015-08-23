<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Appcomments */

$this->title = '创建评论';
$this->params['breadcrumbs'][] = ['label' => 'Appcomments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="appcomments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
