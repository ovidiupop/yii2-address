<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: Address.php
 */

namespace ovidiupop\address\models;

use yii\httpclient\Client;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\base\BaseObject;

/**
 * Class Address
 * @package ovidiupop\address\models
 *
 * @property int $id
 * @property string $street
 * @property string $house_number
 * @property string $apartment_number
 * @property string $city
 * @property string $region
 * @property string $postal_code
 * @property string $country
 * @property string $additional_info
 */
class Address extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * Retrieves a combined array for a specified type and parameters.
     *
     * @param string $type The type of the API request.
     * @param array $params The parameters for the API request.
     * @return array The combined array result from the API call.
     * @throws \Exception If required parameters are missing.
     */
    public static function cmb($type, $params)
    {
        $module = Yii::$app->getModule('address');
        $defaultParams = ArrayHelper::getValue($module->getParams(), "$type.params", []);
        foreach ($defaultParams as $defaultParam) {
            if (!array_key_exists($defaultParam, $params) || !$params[$defaultParam]) {
                return [];
            }
        }
        return $module->callApi($type, $params, true);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return Yii::$app->getModule('address')->rules;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('address', 'ID'),
            'country' => Yii::t('address', 'Country'),
            'region' => Yii::t('address', 'Region'),
            'city' => Yii::t('address', 'City'),
            'postal_code' => Yii::t('address', 'Postal Code'),
            'street' => Yii::t('address', 'Street'),
            'house_number' => Yii::t('address', 'House Number'),
            'apartment_number' => Yii::t('address', 'Block/Apartment Number'),
            'additional_info' => Yii::t('address', 'Address Additional Information'),
        ];
    }

}

