<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: Address.php
 */

namespace ovidiupop\address;

use ovidiupop\address\models\Address;
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

    public $rules  = [
        [['country', 'region','city', 'postal_code', 'street'], 'required'],
        [['house_number', 'apartment_number', 'additional_info'], 'string'],
    ];
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'ovidiupop\address\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        $config = require __DIR__ . '/config/main.php';
        \Yii::$app->setComponents($config['components']);

        //get countries without region
        $noRegionCountries = Yii::$app->nordicgeo->callApi('CountriesWithoutRegion', ['region'=>"null"]);
        if ($noRegionCountries) {
            $rules = [
                [['country', 'city', 'postal_code', 'street'], 'required'],
                [['additional_info'], 'safe'],
                [['house_number', 'apartment_number'], 'string'],

                ['region', 'required', 'when' => function ($model) use ($noRegionCountries) {
                    return !in_array($model->country, $noRegionCountries);
                }, 'whenClient' => "function (attribute, value) {
                    var noRegionCountries = " . json_encode($noRegionCountries) . ";
                    return !(noRegionCountries.includes($('.geography-select.country').val()));
                }"],
            ];
            $this->rules = $rules;
        }
    }
}