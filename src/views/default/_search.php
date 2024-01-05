<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: _search.php
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ovidiupop\address\models\AddressSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="address-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'street') ?>

    <?= $form->field($model, 'house_number') ?>

    <?= $form->field($model, 'apartment_number') ?>

    <?= $form->field($model, 'city') ?>

    <?= $form->field($model, 'region') ?>

    <?= $form->field($model, 'postal_code') ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'additional_info') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
