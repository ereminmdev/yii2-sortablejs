# yii2-sortablejs

Reorderable drag-and-drop lists widget for Yii framework.

Based on JavaScript library: https://github.com/RubaXa/Sortable

## Install

``composer require ereminmdev/yii2-sortablejs``

## Documentation

See for plugin: https://github.com/RubaXa/Sortable#sortable

## Use

```
echo \ereminmdev\yii2\sortablejs\SortableJs::widget([
    'elementSelector' => '.items',
    'clientOptions' => [
        'handle' => '.item-handle',
        'onUpdate' => new \yii\web\JsExpression('
            function (evt) {
                var item = evt.item;
                ...
            },
        '),
    ],
]);
```
