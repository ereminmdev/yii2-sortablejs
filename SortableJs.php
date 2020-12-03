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
     * See available options: https://github.com/SortableJS/sortablejs#options
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
            $url = is_array($this->storeSetAction) ? Url::toRoute($this->storeSetAction) : $this->storeSetAction;
            $this->clientOptions = ArrayHelper::merge([
                'delay' => 250,
                'store' => [
                    'get' => new JsExpression('function (sortable) { sortable.oldOrder = sortable.toArray(); return []; }'),
                    'set' => new JsExpression('(sortable) => {
    $.post("' . $url . '", {
        order: sortable.toArray(),
        oldOrder: sortable.oldOrder,
        "' . Yii::$app->request->csrfParam . '": "' . Yii::$app->request->csrfToken . '"
    })
    .done(function() {
        sortable.oldOrder = sortable.toArray();
    })
    .fail(function() {
        sortable.sort(sortable.oldOrder);
    });
}'),
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
