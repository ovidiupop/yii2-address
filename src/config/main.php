<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: main.php
 */

return [
    'components' => [
        'addressComponent' => [
            'class' => 'ovidiupop\address\components\AddressComponent',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'rules' => [
                'address/<action:[\w-]+>' => 'address/default/<action>',
            ],
        ],
    ],
];