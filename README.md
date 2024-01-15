
**Description**

The address module is a Yii2 extension designed to simplify the management and integration of address-related  
functionalities within your Yii2 applications. It provides a seamless way to handle addresses as a standalone entity,  
allowing you to associate them with various models, such as customers, companies, or any other entities in your  
application.

**Installation**


The preferred method for installation is using Composer.

    composer require ovidiupop/yii2-address "@dev"

Or, add the following line to your composer.json file::

    "ovidiupop\yii2-address": "@dev"

**Configuration:**

1. Run the migration in the migrations folder to create the 'address' table.
   The model that includes the address will need a field "address_id" that relates to the "address" table.   
 
2. In the config/main.php file, add:
````
'modules' => [
    'address' => [
     'class' => 'ovidiupop\address\Address',
    ], 
........
'controllerMap' => [
     'address'=> 'ovidiupop\address\controllers\AddressController',
 ..............
````

**Usage**

In the create and update actions of the controller being used, you can proceed as follows:

    use ovidiupop\address\models\Address;
    
    public function actionCreate()
    {
        $model = new Model();
        $addressModel = new Address();

        if ($model->load(Yii::$app->request->post()) && $addressModel->load(Yii::$app->request->post())) {
            if ($addressModel->save()) {
                $model->address_id = $addressModel->id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'addressModel' => $addressModel,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $addressModel = $model->address_id ? Address::findOne($model->address_id) :  new Address();

        if ($model->load(Yii::$app->request->post()) && $addressModel->load(Yii::$app->request->post())) {
            if ($addressModel->save()) {
                $model->address_id = $addressModel->id;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
            'addressModel' => $addressModel,
        ]);
    }

In the host model's form, add one of the predefined form variants for displaying the address fields:  

 - If you want to display the inputs horizontally (default mode):

       <?php echo Yii::$app->getModule('address')->addressComponent->formInclude($addressModel, $form) ?>

- If you want to display the inputs in a vertical column:

      <?php echo Yii::$app->getModule('address')->addressComponent->formInclude($addressModel, $form, 1) ?>

- If you want to display the inputs in 2 vertical columns:

      <?php echo Yii::$app->getModule('address')->addressComponent->formInclude($addressModel, $form, 2) ?>


- If you want a custom form, you can either copy one of the existing three and adjust it according to your preferences,  
  or create a completely new one. To use it, add the paths to the custom form or forms in the configuration as follows:
  

    'modules'=>[
        'address' => [
            'class' => 'ovidiupop\address\AddressModule',
            'formCustom' => '@path/to/views/my_custom_form',
        ],

In this case, the address form will be displayed in the form with:
    
    <?php echo Yii::$app->getModule('address')->addressComponent->formInclude($addressModel, $form, 'custom') ?>



**i18n**

For message translation, the 'address' convention [Yii::t('address', message)] has been used as the "category."

