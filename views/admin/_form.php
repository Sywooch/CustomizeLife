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
				$str3 = json_encode($allkind2);
				?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'version')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'profile')->textInput(['maxlength' => true])?>

    <?//= $form->field($model, 'stars')->textInput()?>

    <?//= $form->field($model, 'downloadcount')->textInput()?>
    <?//= $form->field($model, 'commentscount')->textInput()?>

    <?= $form->field($model, 'introduction')->textarea(['rows'=>6])?>
    <?= $form->field($model, 'size')->textInput(['maxlength' => true])?>
    <?php 
//     	foreach ($allkind2 as $first=>$second)
//     	{
//     		echo $form->field($model, 'kind2array[]')->checkboxList($second)->label($first);
//     	}
    ?>
    <?php 
    	echo '<label class="control-label">'.'一级标签:'.'</label>';
    	echo '         ';
    	foreach ($allkind2 as $first=>$second)
    	{
    		echo '<label onclick=change(\''.$first.'\')>'.$first.'</label>';
    		echo '    ';
    		//echo $form->field($model, 'kind2array[]')->checkboxList($second)->label($first);
    	}
    ?>
    <div id="panel"></div>
	<?//= $form->field($model, 'kind2array[]')->checkboxList($allkind2)?>
	<script type="text/javascript">
	console.log("bb");
	var allkind;
	var all = '<?php echo $str3?>';
	allkind=JSON.parse(all);
	//console.log(allkind);
 	var allkind1={};
 	//console.log(allkind);
 	for(var kind in allkind){
 		allkind1[kind]=0;//[kind]=0;
 	}
 	for(var kind in allkind){
		for (var kind2 in allkind[kind])
 			{
				var l = document.createElement("label");
				l.setAttribute("style","display:none");
				l.setAttribute("name",kind);
				var　tempInput　=　document.createElement("input");　  
           　	tempInput.type="checkbox";
           　	tempInput.name="app[kind2array][]";
           　	tempInput.value=kind2;
            // tempInput.onclick = "checkboxclicked(kind2)";
             //console.log(allkind2[kind2]);
//            		if(allkind2[kind2]==true){
//         	   		console.log(kind2);
//         	   		tempInput.setAttribute("checked",true);
//            		}
	             l.appendChild(tempInput);
	             l.innerHTML+=" "+kind2;
	             panel.appendChild(l);
	             panel.innerHTML+=" ";
 			}
 	}
	function change(kind){
		//panel=document.getElementById('panel');
		//panel.innerHTML="";
		if(allkind1[kind]==0)
			allkind1[kind]=1;
		else
			allkind1[kind]=0;
		//s=document.getElementsByName("app[kind2array][]");
		for(var kind in allkind1){
			if(allkind1[kind]==1)
			{
				console.log(kind);
				items=document.getElementsByName(kind);
				console.log(items);
				for(var i=0;i< items.length;i++){
					items[i].setAttribute("style","display");
				}
			}else{
				items=document.getElementsByName(kind);
				console.log(items);
				for(var i=0;i< items.length;i++){
					items[i].setAttribute("style","display:none");
				}
			}
		}
	}
	</script>
    
    
    
    <?//= $form->field($model, 'kind2array[]')->checkboxList($allkind2)?>
    <?= $form->field($model, 'updated_log')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'package')->textInput(['maxlength' => true])?>
    <?//= $form->field($model, 'ios_package')->textInput(['maxlength' => true])?>
    <?= $form->field($model, 'ios_url')->textInput(['maxlength' => true])?>
    
<div>
		<div class="col-md-12">
			<div id="container" style="position: relative;">
				<a class="btn btn-default btn-lg " id="android" href="#"
					style="position: relative; z-index: 1;"> <i
					class="glyphicon glyphicon-plus"></i> <sapn>上传安卓应用</sapn>
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
							class="glyphicon glyphicon-plus"></i> <sapn>上传应用图标</sapn>
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
							<a class="btn btn-default btn-lg " id="pic" href="#"
								style="position: relative; z-index: 1;"> <i
								class="glyphicon glyphicon-plus"></i> <sapn>上传应用图片</sapn>
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
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

<?php ActiveForm::end(); ?>

</div>
