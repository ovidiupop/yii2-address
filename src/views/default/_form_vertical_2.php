<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: _form.php
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ovidiupop\address\models\Address */
/* @var $form yii\widgets\ActiveForm */
?>


    <div class="row">
        <div class="col-6">
            <?php if (class_exists(\ovidiupop\nordicgeo\controllers\NordicGeoController::class)): ?>
                <?php echo $form->field($model, 'country')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('Countries', []),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select country'),
                        'class' => 'geography-select country'
                    ],
                ]); ?>
                <?php echo $form->field($model, 'region')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('RegionsByCountry', ['country' => $model->country]),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select region'),
                        'class' => 'geography-select region'
                    ],
                ]); ?>
                <?php echo $form->field($model, 'city')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('PlacesByRegion', ['country' => $model->country, 'region' => $model->region]),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select city'),
                        'class' => 'geography-select place'
                    ],
                ]); ?>
                <?php echo $form->field($model, 'postal_code')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('PostalCode', ['country' => $model->country, 'region' => $model->region, 'place' => $model->city]),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select postal code'),
                        'class' => 'geography-select postalcode'
                    ],
                ]); ?>
            <?php else: ?>
                <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
            <?php endif; ?>
        </div>
        <div class="col-6">
            <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'apartment_number')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address_type')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'additional_info')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

