<?php

namespace ereminmdev\yii2\sortablejs;

use yii\web\AssetBundle;

class SortableJsAsset extends AssetBundle
{
    public $sourcePath = '@npm/sortablejs';

    public $js = [
        'Sortable.min.js',
    ];
}
