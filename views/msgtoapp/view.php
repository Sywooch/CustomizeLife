<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Msgtoapp */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Msgtoapps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<html lang="en-US" style="padding-left:15px">
<div class="msgtoapp-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定要删除该条记录?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            'msgid',
            'appid',
        ],
    ]) ?>

</div>
