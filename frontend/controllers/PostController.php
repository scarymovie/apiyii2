<?php

namespace frontend\controllers;

use frontend\models\post\PostListForm;
use frontend\models\post\MyPostListForm;
use frontend\models\post\CreatePostForm;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionMyPosts()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new MyPostListForm();
        $model->load(\Yii::$app->request->get(), '');

        if ($model->prepareMyPosts()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new CreatePostForm();
        $model->load(\Yii::$app->request->post(), '');

        if ($model->createPost()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }
    }

    public function actionListPost()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new PostListForm();
        $model->load(\Yii::$app->request->get(), '');

        if ($model->listPost()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }


    }


}