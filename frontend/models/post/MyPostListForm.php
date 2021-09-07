<?php

namespace frontend\models\post;

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

    public function prepareMyPosts()
    {
        if (!$this->validate()) {
            $this->addError('', 'Введены некорректные данные');
            return false;
        }

        $user = User::findIdentityByAccessToken($this->access_token);

        if (empty($user)) {
            $this->addError('access_token', 'User not found');
            return false;
        }
        $userId = $user->id;

        $this->postQuery = Post::find()
            ->andWhere(['created_by' => $userId])
            ->limit($this->limit)
            ->offset($this->offset);

        if (empty($this->postQuery->one())) {
            $this->addError('', 'Post not found');
            return false;
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