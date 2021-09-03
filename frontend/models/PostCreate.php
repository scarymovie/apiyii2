<?php

namespace frontend\models;

use common\models\Post;
use common\models\User;
use yii\base\Model;

class PostCreate extends Model
{
    public $title;
    public $body;
    public $access_token;

    public function rules()
    {
        return [
            ['title', 'trim'],
            ['title', 'required'],
            ['title', 'unique', 'targetClass' => '\common\models\Post', 'message' => 'This title has already been used.'],
            ['title', 'string', 'min' => 2, 'max' => 255],

            ['body', 'trim'],
            ['body', 'required'],
            ['body', 'string', 'max' => 255],
            ['body', 'unique', 'targetClass' => '\common\models\Post', 'message' => 'This email address has already been used.'],

            ['access_token', 'required'],
            ['access_token', 'string'],
        ];
    }

    public function createPost()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }
        $post = new Post();
        $user = new User();
        $user = $user->findIdentityByAccessToken($this->access_token);
        $userId = $user->id;
        $post->body = $this->body;
        $post->title = $this->title;
        $post->created_by = $userId;
        if (!$post->save()) {
            return $user->getErrors();
        } else {
            return true;
        }
    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['title'] = $this->title;
        $serializedData['body'] = $this->body;

        return $serializedData;
    }

}