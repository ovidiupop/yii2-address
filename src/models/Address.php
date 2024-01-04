<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: Address.php
 */

namespace ovidiupop\address\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class Address
 * @package ovidiupop\address\models
 *
 * @property int $id
 * @property string $street
 * @property string $house_number
 * @property string $apartment_number
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property string $country
 * @property string $address_type
 * @property string $additional_info
 */
class Address extends ActiveRecord
{
    const TYPE_PERSON = 1;
    const TYPE_COMPANY = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%address}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['country', 'region','city', 'postal_code', 'street'], 'required'],
            [['address_type', 'additional_info'], 'safe'],
            [['house_number', 'apartment_number'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country' => Yii::t('app', 'Country'),
            'region' => Yii::t('app', 'Region'),
            'city' => Yii::t('app', 'City'),
            'postal_code' => Yii::t('app', 'Postal Code'),
            'street' => Yii::t('app', 'Street'),
            'house_number' => Yii::t('app', 'House Number'),
            'apartment_number' => Yii::t('app', 'Block/Apartment Number'),
            'address_type' => Yii::t('app', 'Address Type'),
            'additional_info' => Yii::t('app', 'Address Additional Information'),
        ];
    }

    public function getAddressTypeLabel()
    {
        return $this->address_type == self::TYPE_PERSON
            ? Yii::t('app', 'Person')
            : Yii::t('app', 'Company');
    }
}
