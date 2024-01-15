<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: update.php
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ovidiupop\address\models\Address */

$this->title = Yii::t('address', 'Update Address: {id}', ['id' => $model->id]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('address', 'Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('address', 'Update');
?>
<div class="address-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>