<?php

namespace frontend\models\post;

use common\models\Post;
use common\models\User;
use yii\base\Model;

class CreatePostForm extends Model
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
            $this->addError('', 'Введены некорректные данные');
            return false;
        }
        $post = new Post();
        $user = User::findIdentityByAccessToken($this->access_token);
        $userId = $user->id;
        $post->body = $this->body;
        $post->title = $this->title;
        $post->created_by = $userId;
        if (!$post->save()) {
            $post->addErrors($post->getErrors());
            return false;
        }
        return true;
    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['title'] = $this->title;
        $serializedData['body'] = $this->body;

        return $serializedData;
    }

}