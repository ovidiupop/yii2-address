<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: Address.php
 */

namespace ovidiupop\address;

use Yii;

/**
 * address module definition class
 */
class AddressModule extends \yii\base\Module
{
    public $formVertical1 = '@ovidiupop/address/views/default/_form_vertical_1';
    public $formVertical2 = '@ovidiupop/address/views/default/_form_vertical_2';
    public $formHorizontal = '@ovidiupop/address/views/default/_form_horizontal';
    public $formCustom = '@ovidiupop/address/views/default/_form_horizontal';

    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'ovidiupop\address\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
       \Yii::configure($this, require __DIR__ . '/config/main.php');

    }
}