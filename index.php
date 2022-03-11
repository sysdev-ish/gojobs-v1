<?php

//echo $_SERVER["REMOTE_ADDR"];

error_reporting(E_ALL);
ini_set('display_errors', '1');

// comment out the following two lines when deployed to production
if ($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
defined('YII_DEBUG') or define('YII_DEBUG', true);
}
defined('YII_ENV') or define('YII_ENV', 'dev');

require __DIR__ . '/app/vendor/autoload.php';
require __DIR__ . '/app/vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/app/config/web.php';

(new yii\web\Application($config))->run();
