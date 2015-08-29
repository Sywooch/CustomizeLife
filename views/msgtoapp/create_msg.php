<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Msgtoapp */

$this->title = '创建消息对应应用';
$this->params['breadcrumbs'][] = ['label' => 'Msgtoapps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="msgtoapp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_msg', [
        'model' => $model,
    	'msgid' =>$msgid,
    ]) ?>

</div>
