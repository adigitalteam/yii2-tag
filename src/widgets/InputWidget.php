<?php
/**
 * @author Jakhar <https://github.com/jakharbek>
 * @author Nazrullo <https://github.com/nazrullo>
 * @author O`tkir    <https://github.com/utkir24>
 * @team Adigitalteam <https://github.com/adigitalteam>
 * @package Tag of Yii2
 */

namespace adigitalteam\tag\widgets;

use adigitalteam\tag\widgets\assets\SelectizeAsset;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;

/**
 * InputWidget
 * @property $loadUrl string
 * @property $queryParam string
 * @property $clientOptions string
 * @author Jakhar Nazrullo O'tkir
 */
class InputWidget extends \yii\widgets\InputWidget
{
    /**
     * @var string
     */
    public $loadUrl;

    /**
     * @var string the parameter name
     */
    public $queryParam = 'query';

    /**
     * @var array
     */
    public $clientOptions;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->registerClientScript();
    }

    /**
     * Registers the needed JavaScript.
     */
    public function registerClientScript()
    {
        $id = $this->options['id'];

        if ($this->loadUrl !== null) {
            $url = Url::to($this->loadUrl);
            $this->clientOptions['load'] = new JsExpression("function (query, callback) { if (!query.length) return callback(); $.getJSON('$url', { {$this->queryParam}: query }, function (data) { callback(data); }).fail(function () { callback(); }); }");
        }

        $options = Json::encode($this->clientOptions);
        $view = $this->getView();
        SelectizeAsset::register($view);
        $view->registerJs("jQuery('#$id').selectize($options);");
    }
}
