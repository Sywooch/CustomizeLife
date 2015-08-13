<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE HTML>
<html>
<html lang="en-US" style="padding-bottom:50px">
<head>
    <title>管理系统</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?=Html::cssFile('@web/assets/css/dpl-min.css')?>
    <?=Html::cssFile('@web/assets/css/bui-min.css')?>
    <?=Html::cssFile('@web/assets/css/main-min.css')?>
    <?=Html::cssFile('@web/css/site.css')?>
    <?=Html::jsFile('@web/assets/js/jquery-1.8.1.min.js')?>
    <?=Html::jsFile('@web/assets/js/bui-min.js')?>
    <?=Html::jsFile('@web/assets/js/common/main-min.js')?>
    <?=Html::jsFile('@web/assets/js/config-min.js')?>
   

</head>
<body>


<div class="header">

    <div class="dl-title">
        <!--<img src="/chinapost/Public/assets/img/top.png">-->
    </div>

    <div class="dl-log">欢迎您！ <a href="<?=Yii::$app->urlManager->createUrl(['admin/index/logout'])?>" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
</div>
<div class="content">
    
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
</div>


<script>
    var myapp="<?= Yii::$app->urlManager->createUrl('admin/app')?>";
    var thumb="<?= Yii::$app->urlManager->createUrl('admin/index/thumb')?>";

    BUI.use('common/main',function(){
        var config = [
            {id:'1',menu:[
                  {text:'数据管理',items:[{id:'11',text:'APP',href:myapp},{id:'12',text:'USER',href:thumb}]}
                ]}
        ];
        new PageUtil.MainPage({
            modulesConfig : config
        });
    });
</script>
</body>
</html>