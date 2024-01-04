<?php
/**
 * Author: Antonio Ovidiu Pop
 * Date: 1/3/24
 * Filename: AddressComponent.php
 */

namespace ovidiupop\address\components;

use Yii;
use yii\base\Component;

class AddressComponent extends Component
{
    public function formInclude($model, $form, $mode=3)
    {
        switch ($mode){
            case 1:
                $view = Yii::$app->getModule('address')->formVertical1;
                break;
            case 2:
                $view = Yii::$app->getModule('address')->formVertical2;
                break;
            case 'custom':
                $view = Yii::$app->getModule('address')->formCustom;
                break;
            default:
                $view = Yii::$app->getModule('address')->formHorizontal;
        }

        return Yii::$app->getView()->render($view, [
            'model' => $model,
            'form' => $form,
        ]);
    }

    public function modelForm($model, $form)
    {
        return Yii::$app->getView()->render('@ovidiupop/address/views/default/_form', [
            'model' => $model,
            'form' => $form,
        ]);
    }
}