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

public function behaviors()
{
    $behaviors = parent::behaviors();
    $behaviors['authenticator']['only'] = ['create','update','delete'];
    /*    $behaviors['authenticator']['authMethods'] = [
            HttpBearerAuth::class
        ];*/
    $behaviors['authenticator'] = [
        'class' => HttpBasicAuth::class,
        'auth' => function($username,$password){
            if ($user = User::find()->where(['username'=>$username,'password'=>$password])->one() and
                $user->validatePassword($password)){
                return $user->access_token;
            }
            return null;
        }
    ];
    return $behaviors;

}


    /**
     * @param string $action
     * @param Post $model
     * @param array $params
     * @throws ForbiddenHttpException
     */
    public function checkAccess($action, $model = null, $params = [])
{
    if (in_array($action,['update','delete'])&& $model->created_by !==\Yii::$app->user->id){
        throw new ForbiddenHttpException("У вас нет доступа");
    }
}
}