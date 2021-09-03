<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\RegisterForm;
use Yii;
use yii\rest\Controller;
use yii\web\JsonResponseFormatter;

class RegisterController extends Controller
{
    public function actionSignup()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new RegisterForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->validate() && $model->regByUsername()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }

    }
}