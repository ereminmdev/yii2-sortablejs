<?php

namespace ereminmdev\yii2\sortablejs;

use yii\web\AssetBundle;


class SortableJsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/npm/sortablejs';

    public $js = [
        YII_DEBUG ? 'Sortable.js' : 'Sortable.min.js',
    ];
}
