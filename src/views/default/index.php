<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: index.php
 */

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel ovidiupop\address\models\AddressSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('address', 'Addresses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="address-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('address', 'Create Address'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'street',
            'house_number',
            'apartment_number',
            'city',
            'region',
            'postal_code',
            'country',
            'additional_info',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>