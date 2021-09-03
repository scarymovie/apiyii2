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


        /*$username = (\Yii::$app->request->post('username'));
        $password = (\Yii::$app->request->post('password'));

        $user = User::find()
            ->andWhere(['username' => $username])
            ->one();

        if (empty($user)) {
            return [
                'error' => 'User not found',
            ];
        }

        if (!$user->validatePassword($password)) {
            return [
                'error' => 'Wrong password',
            ];
        }

        if (!$user->save()) {
            return $user->getErrors();
        }

        return [
            'user' => $user->serializeToArray(),
            'accessToken' => $user->access_token,
        ];*/

    }

}