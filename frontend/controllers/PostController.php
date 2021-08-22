<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\User;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;

class PostController extends ActiveController
{
    public $modelClass = Post::class;

    /*    public function behaviors()
        {
            $behaviors = parent::behaviors();
            $behaviors['authenticator'] = [
                'class' => HttpBasicAuth::class
            ];
        }*/

    public function actionLogin()
    {
        $username = \Yii::$app->request->post('username');
        $password = \Yii::$app->request->post('password');

        $user = User::find()->where(['username' => $username])->one() and !empty($password)
        and $user->validatePassword($password);

        $user->generateAccessToken();
        $user->save();

        return $user->access_token;
    }

    public function actionView()
    {

        $userId = \Yii::$app->user->id;

        $post = Post::find('title')->where(['created_by' => $userId])->one();

        return $post;
    }
}