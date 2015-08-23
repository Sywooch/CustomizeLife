<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\v1\models\Apptopicture */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apptopicture-form">

    <?php $form = ActiveForm::begin(['id' => 'form']); ?>

    <?= $form->field($model, 'appid')->textInput() ?>

<div>
	<div>
		<div class="col-md-12">
			<div id="container" style="position: relative;">
				<a class="btn btn-default btn-lg " id="pic" href="#"
					style="position: relative; z-index: 1;"> <i
					class="glyphicon glyphicon-plus"></i> <sapn>Picture</sapn>
				</a>
				<div id="html5_19rugovp4pupkrh1n901mlkrhd3_container"
					class="moxie-shim moxie-shim-html5"
					style="position: absolute; top: 0px; left: 0px; width: 167px; height: 46px; overflow: hidden; z-index: 0;">
					<input id="html5_19rugovp4pupkrh1n901mlkrhd3" type="file"
						style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;"
						multiple="" accept="">
				</div>
			</div>
		</div>


		<div style="display: none" id="success1" class="col-md-12">
			<div class="alert-success">队列全部文件处理完毕</div>
		</div>
		<div class="col-md-12 ">
			<table class="table table-striped table-hover text-left"
				style="margin-top: 40px; display: none">
				<thead>
					<tr>
						<th class="col-md-4">文件名</th>
						<th class="col-md-2">大小</th>
						<th class="col-md-6">详情</th>
					</tr>
				</thead>
				<tbody id="fsUploadProgress">
					<tr id="o_19s3ckjug1c08lq3ht6hamola9" class="progressContainer"
						style="opacity: 1;">
					</tr>
				</tbody>
			</table>
		</div>
	</div>



	<script src="/assets/jssdk/plupload.full.min.js"></script>
	<script src="/assets/jssdk/ui.js"></script>
	<script src="/assets/jssdk/qiniu.js"></script>
	<script src="/assets/jssdk/moxie.js"></script>
	<script src="/assets/jssdk/icon.js"></script>
	<script src="/assets/jssdk/pic.js"></script>
	<script src="/assets/jssdk/ios.js"></script>
	<script src="/assets/jssdk/android.js"></script>
<p>&nbsp</p>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
