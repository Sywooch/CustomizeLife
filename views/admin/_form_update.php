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
				$str =json_encode($model->kindarray);
				?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'profile')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'stars')->textInput()?>

    <?= $form->field($model, 'downloadcount')->textInput()?>
    <?= $form->field($model, 'commentscount')->textInput()?>

    <?= $form->field($model, 'introduction')->textInput(['maxlength' => true])?>
    
    <?= $form->field($model, 'size')->textInput(['maxlength' => true])?>
    
    <?= $form->field($model, 'kindarray[]')->checkboxList(['社交'=>'社交','休闲'=>'休闲','娱乐'=>'娱乐','工具'=>'工具','导航'=>'导航','购物'=>'购物','体育'=>'体育',
			'旅游'=>'旅游','生活'=>'生活','音乐'=>'音乐','教育'=>'教育','办公'=>'办公','理财'=>'理财','图像'=>'图像'])?>
	<script type="text/javascript">
	console.log("aa");
	var kindarray;
	var kind ='<?php echo $str?>';
	//console.log(kind[0]);
	kindarray=JSON.parse(kind);
	console.log(kindarray[0]);
	s=document.getElementsByName("app[kindarray][]");
	console.log(s.length);
	for (var i = 0;i < s.length;i++)
	{
		console.log(kindarray.length);
		for(var j=0;j<kindarray.length;j++){
			console.log(s[i].value);
			console.log(kindarray[j]);
			console.log(kindarray[0]);
		    if (s[i].value == kindarray[j])
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