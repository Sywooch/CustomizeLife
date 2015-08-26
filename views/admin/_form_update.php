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
				$str1 =json_encode($model->kind1array);
				$str2 =json_encode($model->kind2array);
				?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'profile')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'stars')->textInput()?>

    <?= $form->field($model, 'downloadcount')->textInput()?>
    <?= $form->field($model, 'commentscount')->textInput()?>

    <?= $form->field($model, 'introduction')->textInput(['maxlength' => true])?>
    
    <?= $form->field($model, 'size')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'kind1array[]')->checkboxList($allkind1)?>
	<?= $form->field($model, 'kind2array[]')->checkboxList($allkind2)?>
	<script type="text/javascript">
	console.log("aa");
	var kind1array;
	var kind1 ='<?php echo $str1?>';
	kind1array=JSON.parse(kind1);
	console.log(kind1array[0]);
	s=document.getElementsByName("app[kind1array][]");
	console.log(s.length);
	for (var i = 0;i < s.length;i++)
	{
		for(var j=0;j<kind1array.length;j++){
		    if (s[i].value == kind1array[j])
		    { 
		        s[i].checked = true;
		        break;
		    }
	    }
	}


	var kind2array;
	var kind2 ='<?php echo $str2?>';
	kind2array=JSON.parse(kind2);
	console.log(kind2array[0]);
	s=document.getElementsByName("app[kind2array][]");
	console.log(s.length);
	for (var i = 0;i < s.length;i++)
	{
		for(var j=0;j<kind2array.length;j++){
		    if (s[i].value == kind2array[j])
		    { 
		        s[i].checked = true;
		        break;
		    }
	    }
	}
	</script>
	
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

<p>&nbsp</p>

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

<p>&nbsp</p>


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


<p>&nbsp</p>

				<div>
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
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

<?php ActiveForm::end(); ?>

</div>