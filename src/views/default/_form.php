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

<div class="address-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">

        <?php if (class_exists(\ovidiupop\nordicgeo\controllers\NordicGeoController::class)): ?>
            <div class="col-3">
                <?php echo $form->field($model, 'country')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('Countries', []),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select country'),
                        'class' => 'geography-select country'
                    ],
                ]); ?>
            </div>
            <div class="col-3">
                <?php echo $form->field($model, 'region')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('RegionsByCountry', ['country' => $model->country]),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select region'),
                        'class' => 'geography-select region'
                    ],
                ]); ?>
            </div>
            <div class="col-3">
                <?php echo $form->field($model, 'city')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('PlacesByRegion', ['country' => $model->country, 'region' => $model->region]),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select city'),
                        'class' => 'geography-select place'
                    ],
                ]); ?>
            </div>
            <div class="col-3">
                <?php echo $form->field($model, 'postal_code')->widget(\kartik\widgets\Select2::class, [
                    'data' => \ovidiupop\nordicgeo\controllers\NordicGeoController::cmb('PostalCode', ['country' => $model->country, 'region' => $model->region, 'place' => $model->city]),
                    'options' => [
                        'prompt' => Yii::t('app', 'Select postal code'),
                        'class' => 'geography-select postalcode'
                    ],
                ]); ?>
            </div>
        <?php else: ?>
            <div class="col-3">
                <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'region')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-3">
                <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
            </div>
        <?php endif; ?>

        <div class="col-3">
            <?= $form->field($model, 'street')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-3">
            <?= $form->field($model, 'apartment_number')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?= $form->field($model, 'additional_info')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord
            ? Yii::t('app', 'Create')
            : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
