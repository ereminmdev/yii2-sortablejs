<?php

namespace ereminmdev\yii2\sortablejs;

use yii\base\Widget;
use yii\helpers\Json;


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
     * @inheritdoc
     */
    public function run()
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
