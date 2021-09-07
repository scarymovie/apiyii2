<?php

namespace frontend\controllers;

use frontend\models\login\LoginByUsernameForm;
use yii\rest\Controller;


class LoginController extends Controller
{

    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new LoginByUsernameForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->login()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }
    }

}