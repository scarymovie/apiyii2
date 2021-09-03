<?php

namespace frontend\controllers;

use common\models\User;
use frontend\models\LoginForm;
use yii\rest\Controller;
use yii\validators\SafeValidator;


class LoginController extends Controller
{

    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new LoginForm();
        $model->load(\Yii::$app->request->post(), '');
        if ($model->validate() && $model->loginByUsername()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }
    }

}