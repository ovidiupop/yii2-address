<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: main.php
 */

return [
    'components' => [
        'nordicgeo' => [
            'class' => 'ovidiupop\nordicgeo\NordicGeo',
            'apisBaseUrl' => 'http://geo.local/',
            'queryBaseUrl' => 'http://geo.local/api/query?type=',
        ],
        'addressComponent' => [
            'class' => 'ovidiupop\address\components\AddressComponent',
        ],
    ],
];