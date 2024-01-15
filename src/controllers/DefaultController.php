<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: DefaultController.php
 */

namespace ovidiupop\address\controllers;

use ovidiupop\address\components\ApiCallerComponent;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use ovidiupop\address\models\Address;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `address` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new \ovidiupop\address\models\AddressSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Renders the view for a single address
     * @param int $id
     * @return string
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Address model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return Address the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Address::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Displays a form to create a new address.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Address();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a form to update an existing address.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Action to retrieve options based on the provided API type and parameters.
     *
     * @return string The HTML options based on the API call result.
     */
    public function actionGetOptions()
    {
        $params = Yii::$app->request->queryParams;

        if (isset($params['type']) && $params['type']) {
            $type = $this->typeForPlacesAndPostalCode($params['type'], $params);
            return self::arrayToOptions(Address::cmb($type, $params));
        }

        return '';
    }

    /**
     * Corrects the API type for countries without region.
     *
     * @param string $type The original API type.
     * @param array $params The parameters for the API request.
     * @return string The corrected API type.
     */
    private function typeForPlacesAndPostalCode($type, $params)
    {
        if ($type !== 'PlacesByRegion' && $type !== 'PostalCode') {
            return $type;
        }

        $country = $params['country'];
        $countriesNoRegions = Yii::$app->getModule('address')->countriesNoRegion;

        // If the country does not have regions, filtering will be based solely on the country name for places.
        if($type == 'PlacesByRegion' && in_array($country, $countriesNoRegions)) {
            return 'PlacesByCountry';
        }

        // If the country has regions, postal code filtering will also consider the region.
        if($type == 'PostalCode' && !in_array($country, $countriesNoRegions)){
            return 'PostalCodeStrict';
        }

        return $type;
    }

    /**
     * Converts an associative array to HTML option tags.
     *
     * @param array $array The associative array to convert.
     * @return string The HTML options.
     */
    public static function arrayToOptions($array)
    {
        $html = '';
        foreach ($array as $key => $value) {
            $html .= '<option value="' . htmlspecialchars($key) . '">' . htmlspecialchars($value) . '</option>';
        }
        return $html;
    }

}