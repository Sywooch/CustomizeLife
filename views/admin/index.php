<?php
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE HTML>
<html>
<html lang="en-US" style="padding-left:-15px">
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

    <div class="dl-log">欢迎您！ <a href="<?=Yii::$app->urlManager->createUrl(['admin/login'])?>" title="退出系统" class="dl-log-quit">[退出]</a>
    </div>
</div>
<div class="content">
    <div class="dl-main-nav">
        <div class="dl-inform"><div class="dl-inform-title"><s class="dl-inform-icon dl-up"></s></div></div>
        <ul id="J_Nav"  class="nav-list ks-clear">
            <li class="nav-item dl-selected"><div class="nav-item-inner nav-home">定制生活系统管理</div></li>		

        </ul>
    </div>
    <ul id="J_NavContent" class="dl-tab-conten">

    </ul>
</div>


<script>
    var myapp="<?= Yii::$app->urlManager->createUrl('admin/app')?>";
    var thumb="<?= Yii::$app->urlManager->createUrl('user/index')?>";
    var appcom="<?= Yii::$app->urlManager->createUrl('appcomments/index')?>";
    var apptopic="<?= Yii::$app->urlManager->createUrl('apptopicture/index')?>";
    var staruser="<?= Yii::$app->urlManager->createUrl('staruser/index')?>";
    var sysuser="<?= Yii::$app->urlManager->createUrl('systemuser/index')?>";
    var friend="<?= Yii::$app->urlManager->createUrl('friend/indexofall')?>";
    var follow="<?= Yii::$app->urlManager->createUrl('follow/indexofall')?>";
    var message="<?= Yii::$app->urlManager->createUrl('message/index')?>";
    var msgtoapp="<?= Yii::$app->urlManager->createUrl('msgtoapp/index')?>";
    var reply="<?= Yii::$app->urlManager->createUrl('reply/index')?>";
    var usertoapp="<?= Yii::$app->urlManager->createUrl('usertoapp/index')?>";
    var zan="<?= Yii::$app->urlManager->createUrl('zan/index')?>";
    var collectinteract="<?= Yii::$app->urlManager->createUrl('collect-interact/index')?>";
    var collectperson="<?= Yii::$app->urlManager->createUrl('collect-person/index')?>";
    var tag="<?= Yii::$app->urlManager->createUrl('tag/index')?>";
    var tag2="<?= Yii::$app->urlManager->createUrl('tag2/index')?>";
    var push="<?= Yii::$app->urlManager->createUrl('push/create')?>";
    
    BUI.use('common/main',function(){
        var config = [
            {id:'1',menu:[
				  {text:'应用管理',items:[{id:'11',text:'应用',href:myapp},{id:'12',text:'应用评论',href:appcom},
				    				  {id:'13',text:'一级标签',href:tag},{id:'14',text:'二级标签',href:tag2}]},
                  //{text:'应用管理',items:[{id:'11',text:'应用',href:myapp},{id:'12',text:'应用评论',href:appcom},{id:'13',text:'应用图片',href:apptopic}]},

                  {text:'用户管理',items:[{id:'22',text:'普通用户',href:thumb},{id:'23',text:'明星用户',href:staruser},
                                      {id:'24',text:'后台用户',href:sysuser}]},
                  {text:'好友管理',items:[{id:'33',text:'好友关系',href:friend},{id:'35',text:'关注关系',href:follow}]},
                  {text:'消息管理',items:[{id:'44',text:'消息',href:message},{id:'45',text:'消息对应应用',href:msgtoapp},{id:'46',text:'消息回复',href:reply}]},
                  {text:'推送',items:[{id:'55',text:'推送消息',href:push}]},
                ]},
            {id:'7',homePage : '9',menu:[{text:'业务管理',items:[{id:'9',text:'查询业务',href:myapp}]}]}
        ];
        new PageUtil.MainPage({
            modulesConfig : config
        });
    });
</script>
</body>
</html>
