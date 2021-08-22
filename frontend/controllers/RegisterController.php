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
    public $modelClass = User::class;

    public function actionSignup(){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $date = new DateTime();
        $user = new User();
        $user->load(\Yii::$app->request->post());
        $user->username = \Yii::$app->request->post('username');
        $user->password = \Yii::$app->security->generatePasswordHash($user->password_hash);
        $user->email = \Yii::$app->request->post('email');
        $user->generateEmailVerificationToken();
        $user->generateAccessToken();
        $user->generateAuthKey();
        $user->created_at = $date->getTimestamp();
        $user->updated_at = $date->getTimestamp();
        $user->save();
        return \Opis\Closure\serialize( $user->access_token);
    }
}