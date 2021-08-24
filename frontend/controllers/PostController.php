<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\db\ActiveQuery;

class PostController extends Controller
{

    public function actionMyPosts()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = new User();
        $user = $user->findIdentityByAccessToken(Yii::$app->request->get('access_token'), $type = null);
        $userId = $user->id;
        $post = Post::find()->where(['created_by' => $userId]);
        //$serialized_array=serialize($post);
        /*var_dump($serialized_array);*/


        foreach ($post->each() as $myPost) {
            echo $myPost->title;
        }
    }
}