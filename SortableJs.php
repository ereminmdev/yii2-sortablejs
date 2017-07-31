<?php

namespace ereminmdev\yii2\sortablejs;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;


/**
 * Class SortableJs
 * @package ereminmdev\yii2\sortablejs
 */
class SortableJs extends Widget
{
    /**
     * @var string containing one or more CSS selectors separated by commas.
     * See: https://developer.mozilla.org/en-US/docs/Web/API/Document/querySelectorAll
     */
    public $elementSelector = '.items';
    /**
     * @var array the client options
     * See available options: https://github.com/RubaXa/Sortable#options
     */
    public $clientOptions = [];
    /**
     * @var string|array route to store sortable ids
     */
    public $storeSetAction;


    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->storeSetAction !== null) {
            $this->clientOptions = ArrayHelper::merge([
                'store' => [
                    'get' => new JsExpression('function (sortable) { return []; }'),
                    'set' => new JsExpression('
function (sortable) {
    $.post("' . Url::toRoute($this->storeSetAction) . '", {
        order: sortable.toArray(),
        "' . Yii::$app->request->csrfParam . '": "' . Yii::$app->request->csrfToken . '"
    });
}
'),
                ],
            ], $this->clientOptions);
        }

        $this->registerScripts();
    }

    public function registerScripts()
    {
        $view = $this->getView();

        SortableJsAsset::register($view);

        $view->registerJs('
$("' . $this->elementSelector . '").each(function() {
    new Sortable(this, ' . Json::encode($this->clientOptions, JSON_FORCE_OBJECT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . ');
});
        ');
    }
}