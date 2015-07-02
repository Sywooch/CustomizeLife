<?php
$params = require (__DIR__ . '/params.php');

$config = [ 
		'id' => 'basic',
		'basePath' => dirname ( __DIR__ ),
		'bootstrap' => [ 
				'log' 
		],
		'modules' => [
				'v1' => 'app\modules\v1\customlife'  // 后台模块引用
		],
		'components' => [ 
				'request' => [ 
						// !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
						'cookieValidationKey' => '123456' 
				],
				'cache' => [ 
						'class' => 'yii\caching\FileCache' 
				],
				'user' => [ 
						'identityClass' => 'app\modules\v1\models\User',
						'enableAutoLogin' => true 
				],
				'response' =>[
						//'format'=>\yii\web\Response::FORMAT_JSON
				],
				'mailer' => [ 
						'class' => 'yii\swiftmailer\Mailer',
						// send all mails to a file by default. You have to set
						// 'useFileTransport' to false and configure a transport
						// for the mailer to send real emails.
						'useFileTransport' => false,
// 						'transport' => [
// 								'class' => 'Swift_SmtpTransport',
// 								'host' => 'smtp.163.com',
// 								'username' => 'zhou544028616@163.com',
// 								'password' => '',
// 								'port' => '25',
// 								'encryption' => 'tls',
								 
// 						],
						'messageConfig'=>[
								'charset'=>'UTF-8',
								'from'=>['shepherdbird@163.com'=>'admin']
								],
				],
				'log' => [ 
						'traceLevel' => YII_DEBUG ? 3 : 0,
						'targets' => [ 
								[ 
										'class' => 'yii\log\FileTarget',
										'levels' => [ 
												'error',
												'warning' 
										] 
								] 
                            ]
						],
				'urlManager' => [ 
								'enablePrettyUrl' => true,
                                'showScriptName' => false,
								'rules' => [ 
										"<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<controller>/<action>",
										"<controller:\w+>/<action:\w+>/<id:\d+>" => "<controller>/<action>",
										"<controller:\w+>/<action:\w+>" => "<controller>/<action>",
										//"<module:\w+>/<version:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>" => "<module>/<version>/<controller>/<action>",
								] 
						],
				
				'db' => require (__DIR__ . '/db.php') 
		],
		'params' => $params 
];
if (YII_ENV_DEV) {
	// configuration adjustments for 'dev' environment
	$config ['bootstrap'] [] = 'debug';
	$config ['modules'] ['debug'] = 'yii\debug\Module';
	
	$config ['bootstrap'] [] = 'gii';
	$config ['modules'] ['gii'] = 'yii\gii\Module';
}

return $config;
