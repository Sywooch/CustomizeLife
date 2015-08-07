<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\app */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="app-form">

    <?php
				
$form = ActiveForm::begin ( [ 
						'id' => 'form' 
				] );
				?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'stars')->textInput()?>

    <?= $form->field($model, 'downloadcount')->textInput()?>

    <?= $form->field($model, 'introduction')->textInput(['maxlength' => true])?>
    
    <?= $form->field($model, 'size')->textInput(['maxlength' => true])?>
    
    <?= $form->field($model, 'updated_log')->textInput(['maxlength' => true])?>
    
<div>
<div class="col-md-12">
		<div id="container" style="position: relative;">
			<a class="btn btn-default btn-lg " id="android" href="#"
				style="position: relative; z-index: 1;"> <i
				class="glyphicon glyphicon-plus"></i> <sapn>Android_app</sapn>
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


<div style="display: none" id="success" class="col-md-12">
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
			</tbody>
		</table>
	</div>
</div>

<div>
<div class="col-md-12">
		<div id="container" style="position: relative;">
			<a class="btn btn-default btn-lg " id="ios" href="#"
				style="position: relative; z-index: 1;"> <i
				class="glyphicon glyphicon-plus"></i> <sapn>Ios_app</sapn>
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


<div style="display: none" id="success" class="col-md-12">
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
			</tbody>
		</table>
	</div>
</div>

<div>
<div class="col-md-12">
		<div id="container" style="position: relative;">
			<a class="btn btn-default btn-lg " id="icon" href="#"
				style="position: relative; z-index: 1;"> <i
				class="glyphicon glyphicon-plus"></i> <sapn>Icon</sapn>
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


<div style="display: none" id="success" class="col-md-12">
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
			</tbody>
		</table>
	</div>
</div>


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
			<tbody id="fsUploadProgress1">
			</tbody>
		</table>
	</div>
</div>



<script src="/assets/jssdk/plupload.full.min.js"></script>
<script src="/assets/jssdk/ui.js"></script>
<script src="/assets/jssdk/qiniu.js"></script>
<script src="/assets/jssdk/moxie.js"></script>
<script src="/assets/jssdk/main.js"></script>
<script src="/assets/jssdk/pic.js"></script>
<script src="/assets/jssdk/ios.js"></script>
<script src="/assets/jssdk/android.js"></script>


<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

<?php ActiveForm::end(); ?>

</div>
