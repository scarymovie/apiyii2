<?php

namespace frontend\controllers;

use frontend\models\PostListForm;
use frontend\models\PostMyList;
use frontend\models\PostCreate;
use yii\web\Controller;

class PostController extends Controller
{
    public function actionMyPosts()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new PostMyList();
        $model->load(\Yii::$app->request->get(), '');

        if ($model->validate() && $model->myPosts()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }
    }

    public function actionCreate()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $model = new PostCreate();
        $model->load(\Yii::$app->request->post(), '');

        if ($model->validate() && $model->createPost()) {
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

        if ($model->validate() && $model->listPost()) {
            return $model->serializeToArray();
        } else {
            return $model->getErrors();
        }


    }


}