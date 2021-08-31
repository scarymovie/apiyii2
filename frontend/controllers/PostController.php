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

        $access_token = Yii::$app->request->get('access_token');
        $limit = Yii::$app->request->get('limit');
        $offset = Yii::$app->request->get('offset');

        if (!empty($access_token)) {
            $user = new User();
            $user = $user->findIdentityByAccessToken($access_token);
            $userId = $user->id;
        } else {
            return [
                'error' => 'User not found',
            ];
        }

        $postQuery = Post::find()
            ->andWhere(['created_by' => $userId])
            ->limit($limit)
            ->offset($offset);

        if (empty($postQuery)) {
            return [
                'error' => 'Пост не найден',
            ];
        } else {
            $result = [];

            foreach ($postQuery->each() as $post) {
                $result[] = $post->serializeToArray();
            }
            return $result;
        }
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $title = Yii::$app->request->post('title');
        $body = Yii::$app->request->post('body');
        $access_token = Yii::$app->request->post('access_token');

        if (!empty($access_token)) {
            $post = new Post();
            $user = new User();
            $user = $user->findIdentityByAccessToken($access_token);
            $userId = $user->id;
            $post->body = $body;
            $post->title = $title;
            $post->created_by = $userId;
            $post->save();
            return $post->serializeToArray();
        } else {
            return [
                'error' => 'User not found',
            ];
        }


       /* if ($post->validate()) {
            $user = $user->findIdentityByAccessToken($access_token);
            $userId = $user->id;
            $post->created_by = $userId;
            $post->save();

            return $post->serializeToArray();
        } else {
            return $errors = $post->errors;
        }*/


    }

    public function actionListPost()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $postQuery = Post::find()->limit(10)->offset(0);

        $result = [];

        foreach ($postQuery->each() as $post) {
            $result[] = $post->serializeToArray();
        }

        return $result;

    }



}