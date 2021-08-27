<?php

namespace frontend\controllers;

use Cassandra\Date;
use common\models\Post;
use common\models\BasePost;
use common\models\User;
use DateTime;
use Yii;
use yii\web\Controller;
use yii\db\Query;

class PostController extends Controller
{

    public function actionMyPosts()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $user = new User();
        $user = $user->findIdentityByAccessToken(Yii::$app->request->get('access_token'), $type = null);
        $userId = $user->id;
        $postQuery = Post::find()->where(['created_by' => $userId])->limit(10)->offset(0);

        $result = [];

        foreach ($postQuery->each() as $post) {
            $result[] = $post->serializeToArray();
        }

        return $result;

    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $date = new DateTime();
        $post = new Post();
        $user = new User();
        $post->load(\Yii::$app->request->post(), '');
        if ($post->validate()){
            $user = $user->findIdentityByAccessToken(Yii::$app->request->post('access_token'), $type = null);
            $userId = $user->id;
            $post->created_by = $userId;
            $post->beforeSave($post);
            $post->save();

            return $post->serializeToArray();
        } else {
            return $errors = $post->errors;
        }


    }

    public function actionListPost()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $postQuery = Post::find()->limit(10)->offset(0);

        $result = [];

        foreach ($postQuery->each() as $post)
        {
            $result[] = $post->serializeToArray();
        }

        return $result;

    }


}