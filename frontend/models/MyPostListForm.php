<?php

namespace frontend\models;

use common\models\Post;
use common\models\User;
use yii\base\Model;

class MyPostListForm extends Model
{
    public $access_token;
    public $postQuery;
    public $limit = 10;
    public $offset = 0;

    public function rules()
    {
        return [
            ['access_token', 'required'],
            ['access_token', 'string'],

            ['limit', 'integer'],
            ['offset', 'integer'],
        ];
    }

    public function myPosts()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }
        $user = new User();
        $user = $user->findIdentityByAccessToken($this->access_token);
        $userId = $user->id;

        $this->postQuery = Post::find()
            ->andWhere(['created_by' => $userId])
            ->limit($this->limit)
            ->offset($this->offset);

        if (empty($this->postQuery)) {
            $this->getErrors();
        }
        return true;
    }

    public function serializeToArray()
    {
        $serializedData = [];
        foreach ($this->postQuery->each() as $post) {
            $serializedData[] = $post->serializeToArray();
        }
        return $serializedData;
    }
}