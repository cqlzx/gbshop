<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "statics/css/bootstrap.min.css",
		"statics/css/bootstrap-responsive.min.css",
		"statics/css/font-awesome.min.css",
		"statics/css/style-metro.css",
		"statics/css/style.css",
		"statics/css/style-responsive.css",
		"statics/css/default.css",
		"statics/css/uniform.default.css",
    ];
    public $js = [
		// "statics/js/jquery-1.10.1.min.js",
		"statics/js/jquery-migrate-1.2.1.min.js",
		"statics/js/jquery-ui-1.10.1.custom.min.js",
		"statics/js/bootstrap.min.js",
		"statics/js/jquery.slimscroll.min.js",
		"statics/js/jquery.blockui.min.js",
		"statics/js/jquery.cookie.min.js",
		"statics/js/jquery.uniform.min.js",
		"statics/js/jquery.form.js",
		"statics/js/app.js",
    ];
    public $depends = [
		"yii\web\YiiAsset",
    ];
}

