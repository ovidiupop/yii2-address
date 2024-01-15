<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/14/24
 * Filename: AddressAsset.php
 */

namespace ovidiupop\address;

use yii\web\AssetBundle;
class AddressAsset extends AssetBundle{
    public $sourcePath;
    public $js;

    public function init(){
        parent::init();
        $this->sourcePath = __DIR__ . '/assets/';
        $this->js = [
            'address.js'
        ];
    }
    public $depends = [
        'yii\web\YiiAsset',
    ];
}