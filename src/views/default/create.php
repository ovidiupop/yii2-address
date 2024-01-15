<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: create.php
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ovidiupop\address\models\Address */

$this->title = Yii::t('address', 'Create Address');
$this->params['breadcrumbs'][] = ['label' => Yii::t('address', 'Addresses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>