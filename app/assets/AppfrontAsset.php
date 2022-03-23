<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppfrontAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'css/site.css',
        // 'css/custom.css',
        // 'css/smartwizard/smart_wizard.css',
        // 'css/smartwizard/smart_wizard_theme_dots.css',
        // 'css/smartwizard/smart_wizard_theme_circles.css',
        'css/frontend/bootstrap.css',
        'css/frontend/font-awesome.css',
        'css/frontend/flaticon.css',
        'css/frontend/fonts/next-icon/flat-icon.css',
        'css/frontend/slick-slider.css',
        'css/frontend/plugin-css/fancybox.css',
        'css/frontend/plugin-css/plugin.css',
        'css/frontend/style.css',
        'css/frontend/homepage-two.css',
        'css/frontend/homepage-three.css',
        'css/frontend/homepage-four.css',
        'css/frontend/color.css',
        'css/frontend/responsive.css',
        'css/frontend/homepage-two-typo.css',
        'css/frontend/home-two-color.css',
        'css/cssloadajax/modal-loading-animate.css',
        'css/cssloadajax/modal-loading.css',
    ];

    public $js = [
      // 'js/app.min.js',
      'js/custom.js',
      'js/modal-loading.js',
    ];
    public $depends = [
        // 'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
        // 'yii\bootstrap\BootstrapPluginAsset',
    ];
    // public $skin = '_all-skins';

    /**
     * @inheritdoc
     */
    public function init()
    {
      parent::init();
    // resetting BootstrapAsset to not load own css files
    \Yii::$app->assetManager->bundles['yii\\bootstrap\\BootstrapAsset'] = [
        'css' => [],
    ];
    // \Yii::$app->assetManager->bundles['yii\\web\\JqueryAsset'] = [
    //     'js' => [],
    // ];
    }
}
