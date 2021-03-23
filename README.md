# yii2-sortablejs

Reorderable drag-and-drop lists widget for Yii framework.

Based on JavaScript library: https://github.com/RubaXa/Sortable

## Install

``composer require ereminmdev/yii2-sortablejs``

## Documentation

ClientOptions: https://github.com/RubaXa/Sortable#sortable

## Use

Insert widget into view:

```
<?= \ereminmdev\yii2\sortablejs\SortableJs::widget([
    'elementSelector' => '.items',
    'clientOptions' => [
        'handle' => '.item-handle',
    ],
]) ?>
```

or with SortableJsAction action:

- add action to controller:

```
public function actions()
{
    return [
        'sortable' => [
            'class' => 'ereminmdev\yii2\sortablejs\SortableJsAction',
        ],
    ];
}
```

- add widget into view:

```
<?= SortableJs::widget([
    'elementSelector' => '.items',
    'storeSetAction' => Url::toRoute(['/site/sortable', 'model' => Product::class]),
]) ?>
```

## Tips

To refresh after ajax:

- add into view before widget

```
$this->registerJs('if (Sortable.active) Sortable.active.destroy();');
```

- or set `destroyOldBeforeThis` widget option to `true`
