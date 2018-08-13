<?php
/**
 * @author Jakhar <https://github.com/jakharbek>
 * @author Nazrullo <https://github.com/nazrullo>
 * @author O`tkir    <https://github.com/utkir24>
 * @team Adigitalteam <https://github.com/adigitalteam>
 * @package Tag of Yii2
 */

namespace adigitalteam\tag\widgets\assets;

use yii\web\AssetBundle;

/**
 * SelectizeAsset
 * @author Jakhar Nazrullo O'tkir
 */
class SelectizeAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/selectize/dist';

    /**
     * @var array
     */
    public $css = [
        'css/selectize.bootstrap3.css',
    ];
    /**
     * @var array
     */
    public $js = [
        'js/standalone/selectize.js',
    ];
    /**
     * @var array
     */
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
