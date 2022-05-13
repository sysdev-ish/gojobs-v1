<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';
$dbjo = require __DIR__ . '/dbjo.php';
use kartik\mpdf\Pdf;
use app\models\Userdata;

$config = [
    'id' => 'gojobs',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'name'=> 'GO JOBS',

    'timeZone' => 'Asia/Jakarta',
    'language' => 'id',

    'on beforeRequest' => function($event) {
		Yii::$app->language = Yii::$app->session->get('language', 'id');	
		if (!Yii::$app->user->isGuest){
			$session = Yii::$app->session;
			if ($session->isActive){
			  $checktoken = Userdata::find()->where(['id'=>Yii::$app->user->identity->id, 'access_token'=>null])->andWhere('role <> 2')->one();
			  if($checktoken){
				$session->destroy();
			  }
			}
		}
    },

    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
      'user' => [

            'identityClass' => 'app\models\User',
            // 'enableAutoLogin' => false,
            'authTimeout' => 3600,
            'enableSession' => true,

        ],
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 3600,
        ],
      'pdf' => [
            'class' => Pdf::classname(),
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'destination' => Pdf::DEST_BROWSER,
            'methods' => [
                // 'SetHeader'=>['Krajee Report Header'],
                'SetFooter'=>['{PAGENO}'],
            ]

            // refer settings section for all configuration options
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5dc9u6xggSAU1t09t_mrJ5LX-UPgY76r',
            'enableCsrfValidation' => false,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'check' => [
            'class' => 'app\components\checkComponent',
        ],
        'chproc' => [
            'class' => 'app\components\checkprocessComponent',
        ],
        'utils' => [
            'class' => 'app\components\UtilComponent',
        ],
        'oauth' => [
            'class' => 'app\components\OauthComponent',
        ],
        'checkhiring' => [
            'class' => 'app\components\checkDataforhiring',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'mailer' => 'mailer',
                    'levels' => ['error', 'warning'],
                    'message' => [
                        'to' => ['hisyamkstd@gmail.com'],
                        'subject' => 'Log message',
                    ],
                ],
            ],
        ],
        'db' => $db,
        'dbjo' => $dbjo,
        'urlManager' => [
          'enablePrettyUrl' => true,
          'showScriptName' => false,
          'rules' => [
            '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            '<controller:\w+>/<action:\w+>/<id:[0-9]+>'=>'<controller>/<action>',
            '<controller:\w+>/<action:\w+>/<slug:[a-zA-Z0-9_\-]+>'=>'<controller>/<action>',
            'class' => 'app\components\SearchUrlRule',
          ],
        ],

        'i18n' => [
            'translations' => [
                // 'app*' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
						'skill' => 'skill.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
    'modules' => [
        'gridview' => [
        'class' => 'kartik\grid\Module',]
        // enter optional module parameters below - only if you need to
        // use your own export download action or custom translation
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
        ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1', '192.168.88.33'],
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        // 'allowedIPs' => ['127.0.0.1', '::1', '192.168.88.33'],
        'allowedIPs' => ['*'],
    ];
}

return $config;
