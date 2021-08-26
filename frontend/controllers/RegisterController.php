<?php

namespace frontend\controllers;

use common\models\User;
use DateTime;
use frontend\models\SignupForm;
use Yii;
use yii\rest\Controller;
use yii\web\JsonResponseFormatter;

class RegisterController extends Controller
{


    public function actionSignup()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $date = new DateTime();
        $user = new User();
        $user->load(\Yii::$app->request->post(), '');
        $user->password = \Yii::$app->security->generatePasswordHash($user->password_hash);
        $user->generateEmailVerificationToken();
        $user->generateAuthKey();
        $user->beforeSave($user);
        $user->save();
        return $user->serializeToArray();
    }
}