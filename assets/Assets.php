<?php

namespace humhub\modules\stepstone_sync\assets;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@stepstone_sync/resources';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        // TIPP: Change forceCopy to true when testing your js in order to rebuild
        // this assets on every request (otherwise they will be cached)
        'forceCopy' => false
    ];
    
    public $css = [
        'css/humhub.stepstone_sync.css'
    ];
    
    /**
     * @inheritdoc
     */
    public $js = [
        'js/humhub.stepstone_sync.js'
    ];
    
    public $images = [
        'images/ajax-loader.gif'
    ];
    
}