<?php

namespace frontend\controllers;

use frontend\models\registration\RegistrationForm;
use yii\rest\Controller;

class RegisterController extends Controller
{
    public function actionSignup()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new RegistrationForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->registerUser()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }

    }
}