<?php

namespace frontend\controllers;

use frontend\models\SignupForm;
use Yii;
use yii\rest\ActiveController;
use common\models\User;

class RegisterController extends ActiveController
{
public $modelClass = User::class;



        public function actionCreate()
    {
        $model = new User();

        if ($this->isPost() && ($data = $_POST)) { // добавился метод isPost наряду с isPut и isDelete
            $model->attributes = $data;
            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model), true, 201); // возвращаем объект
            }
        }
        $this->render('../site/signup', array('model' => $model), false, array('model')); // в ответе только model
    }

}