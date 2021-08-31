<?php

namespace frontend\controllers;

use common\models\User;
use yii\rest\Controller;
use yii\validators\SafeValidator;


class LoginController extends Controller
{
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    public function actionLogin()
    {

        $username = (\Yii::$app->request->post('username'));
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
        ];

    }

}