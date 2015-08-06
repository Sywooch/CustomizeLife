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


    <?= $form->field($model, 'android_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ios_url')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'stars')->textInput()?>

    <?= $form->field($model, 'downloadcount')->textInput()?>

    <?= $form->field($model, 'introduction')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'updated_at')->textInput()?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true])?>

<div class="col-md-12">
		<div id="container" style="position: relative;">
			<a class="btn btn-default btn-lg " id="pickfiles" href="#"
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
</div>





<script src="/assets/jssdk/plupload.full.min.js"></script>
<script src="/assets/jssdk/ui.js"></script>
<script src="/assets/jssdk/qiniu.js"></script>
<script src="/assets/jssdk/moxie.js"></script>

<script>
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'pickfiles',
        container: 'container',
        drop_element: 'container',
        max_file_size: '100mb',
        flash_swf_url: '/assets/jssdk/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: '/admin/token',
        domain: 'http://7xkbeq.com1.z0.glb.clouddn.com',
        auto_start: true,
        init: {
            'FilesAdded': function(up, files) {
                $('table').show();
                $('#success').hide();
                plupload.each(files, function(file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus("等待...");
                });
            },
            'BeforeUpload': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },
            'UploadProgress': function(up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));

                progress.setProgress(file.percent + "%", file.speed, chunk_size);
            },
            'UploadComplete': function() {
                $('#success').show();
            },
            'FileUploaded': function(up, file, info) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                progress.setComplete(up, info);
                var obj=JSON.parse(info);

                var form=document.forms['form'];

                var　tempInput　=　document.createElement("input");　  
               　tempInput.type="hidden";　  
               　tempInput.name="icon";　　  
               　tempInput.value=obj.key;
                form.appendChild(tempInput);
                
                console.log(obj.key);
            },
            'Error': function(up, err, errTip) {
                    $('table').show();
                    var progress = new FileProgress(err.file, 'fsUploadProgress');
                    progress.setError();
                    progress.setStatus(errTip);
                }
                // ,
                // 'Key': function(up, file) {
                //     var key = "";
                //     // do something with key
                //     return key
                // }
        }
    });

    uploader.bind('FileUploaded', function() {
        console.log('hello man,a file is uploaded');
    });
    </script>

<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

<?php ActiveForm::end(); ?>

</div>