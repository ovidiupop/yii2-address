<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: Address.php
 */

namespace ovidiupop\address;

use ovidiupop\address\components\ApiCallerComponent;
use ovidiupop\address\models\Address;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;

/**
 * AddressModule definition class
 *
 * @property string $formVertical1
 * @property string $formVertical2
 * @property string $formHorizontal
 * @property string $formCustom
 * @property array $rules
 * @property bool $useCascade
 * @property string $queryBaseUrl
 * @property string $apisBaseUrl
 * @property array $apis
 * @property array $countriesNoRegion
 */
class AddressModule extends \yii\base\Module
{
    /**
     * Path to the view file for the first type of vertical form.
     *
     * @var string
     */
    public $formVertical1 = '@ovidiupop/address/views/default/_form_vertical_1';
    /**
     * Path to the view file for the second type of vertical form.
     *
     * @var string
     */
    public $formVertical2 = '@ovidiupop/address/views/default/_form_vertical_2';
    /**
     * Path to the view file for the horizontal form.
     *
     * @var string
     */
    public $formHorizontal = '@ovidiupop/address/views/default/_form_horizontal';
    /**
     * Path to the view file for the custom form. Must be defined in configuration if needed
     *
     * @var string
     */
    public $formCustom;

    /**
     * Validation rules for various form fields, including required fields and data types.
     *
     * @var array[]
     */
    public $rules = [
        [['country', 'region', 'city', 'postal_code', 'street'], 'required'],
        [['house_number', 'apartment_number', 'additional_info'], 'string'],
    ];

    /**
     * Indicates whether to use cascade options for addresses in the form.
     *
     * @var bool
     */
    public $useCascade = true;

    /**
     * The base URL for API queries with a specified type.
     *
     * @var string $queryBaseUrl
     */
    public $queryBaseUrl = 'http://world-postal.local/api/query?type=';

    /**
     * The base URL for API calls.
     *
     * @var string $apisBaseUrl The base URL for API calls.
     */
    public $apisBaseUrl = 'http://world-postal.local/';

    /**
     * An array containing API configuration parameters.
     *
     * @var array $apis
     */
    public $apis;
    /**
     * Countries that do not have associated regions.
     *
     * @var $countriesNoRegion array
     */
    public $countriesNoRegion;

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        AddressAsset::register(\Yii::$app->getView());
        $config = require __DIR__ . '/config/main.php';
        $this->loadApis();
        $this->setCountriesNoRegions();
        $this->setRulesNoRegion();
        \Yii::$app->setComponents($config['components']);
    }

    /**
     * Loads API configuration parameters from the specified URL.
     */
    private function loadApis()
    {
        $url = $this->apisBaseUrl . 'params';
        $this->apis = Json::decode(file_get_contents($url), true) ?: [];
    }

    /**
     * Set a list with countries with no region
     *
     * @return void
     */
    public function setCountriesNoRegions()
    {
        if (!$this->countriesNoRegion) {
            //get countries without region
            $this->countriesNoRegion = $this->callApi('CountriesWithoutRegion', ['has_region' => 0]);
            if ($this->countriesNoRegion) {
                //register js for external address.js
                $jsonArray = Json::encode($this->countriesNoRegion);
                Yii::$app->view->registerJs("var noRegionCountries = {$jsonArray};", yii\web\View::POS_HEAD);
            }
        }
    }

    /**
     * Makes an API call based on the provided type, parameters, and optional combining flag.
     *
     * @param string $type The type of the API request.
     * @param array $params The parameters for the request.
     * @param bool $combine Whether to combine the results into an associative array.
     * @return array|false|mixed The result of the API request.
     */
    public function callApi($type, $params = [], $combine = false)
    {
        $url = $this->buildApiUrl($type, $params);
        $result = $this->makeApiCall($url);

        if ($combine) {
            if ($type == 'CountriesWithName') {
                $countries = [];
                foreach ($result as $country) {
                    $countries[$country['country_code']] = $country['country_name'];
                }
                $result = $countries;
            } else {
                $result = array_combine($result, $result);
            }
        }

        return $result;
    }

    /**
     * Builds the API URL based on the provided type and parameters.
     *
     * @param string $type The type of the API request.
     * @param array $params The parameters for the request.
     * @return string The constructed API URL.
     * @throws \Exception If a required parameter is missing.
     */
    private function buildApiUrl($type, $params)
    {
        $url = $this->queryBaseUrl . $type;
        $configParams = ArrayHelper::getValue($this->getParams(), "$type.params", []);

        foreach ($configParams as $param) {
            if (!isset($params[$param])) {
                throw new \InvalidArgumentException("Parameter '{$param}' is required for API call '{$type}'.");
            }
            $url .= '&' . $param . '=' . urlencode($params[$param]);
        }

        return $url;
    }

    /**
     * Gets the loaded API configuration parameters.
     *
     * @return mixed
     */
    public function getParams()
    {
        return $this->apis;
    }

    /**
     * Makes an API call to the specified URL and returns the decoded response.
     *
     * @param string $url The URL for the API call.
     * @return array|mixed The decoded API response.
     */
    private function makeApiCall($url)
    {
        $response = file_get_contents($url);
        return json_decode($response, true) ?: [];
    }

    /**
     * Set special validation rules for model Address
     *
     * @return void
     */
    public function setRulesNoRegion()
    {
        if ($this->countriesNoRegion) {
            $noRegionCountries = $this->countriesNoRegion;
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

    /**
     * Converts an associative array to HTML option tags.
     *
     * @param array $array The associative array to convert.
     * @return string The HTML options.
     */
    public function arrayToOptions($array)
    {
        $html = '';
        foreach ($array as $key => $value) {
            $html .= '<option value="' . htmlspecialchars($key) . '">' . htmlspecialchars($value) . '</option>';
        }
        return $html;
    }


}