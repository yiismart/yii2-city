<?php

namespace smart\city\backend\assets;

use yii\web\AssetBundle;

class CityAsset extends AssetBundle
{
    public $sourcePath = __DIR__ . '/city';

    public $js = [
        'city.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
