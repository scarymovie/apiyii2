<?php

namespace frontend\controllers;

use common\models\User;
use yii\rest\Controller;

class LoginController extends Controller
{

    public function actionLogin()
    {
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');

        $user = User::find()->where(['username' => $username])->one() and !empty($password)
        and $user->validatePassword($password);

        $user->generateAccessToken();
        $user->save();

        return $user->serializeToArray();
    }

}