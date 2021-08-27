<?php

namespace frontend\controllers;

use common\models\User;
use yii\rest\Controller;
use yii\validators\SafeValidator;


class LoginController extends Controller
{

    public function actionLogin()
    {

        $user = new User();
        $user->load(\Yii::$app->request->post(), '');
        if ($user->validate()){
            $user = User::find()->where(['username' => $user->username])->one()
            and !empty($user->password_hash)
            and $user->validatePassword($user->password_hash);
            $user->beforeSave($user);
            $user->save();

            return $user->serializeToArray();
        } else {
            return $erros = $user->errors;
        }
    }

}