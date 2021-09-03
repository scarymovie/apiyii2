<?php

namespace frontend\controllers;

use common\models\Post;
use common\models\BasePost;
use common\models\User;
use frontend\models\PostListForm;
use frontend\models\PostMyList;
use frontend\models\PostCreate;
use Yii;
use yii\web\Controller;
use yii\db\Query;

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