<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Usertoapp */

$this->title = '创建用户下载的应用';
$this->params['breadcrumbs'][] = ['label' => 'Usertoapps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="usertoapp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
