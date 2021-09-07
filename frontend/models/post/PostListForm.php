<?php

namespace frontend\models\post;

use common\models\Post;
use yii\base\Model;

class PostListForm extends Model
{

    public $postQuery;
    public $limit;
    public $offset;

    public function rules()
    {
        return [
            ['limit', 'integer'],
            ['offset', 'integer'],
        ];
    }

    public function listPost()
    {
        if (!$this->validate()) {
            $this->addError('', 'Введены некорректные данные');
            return false;
        }

        $this->postQuery = Post::find()
            ->limit($this->limit)
            ->offset($this->offset);

        if (empty($this->postQuery)) {
            $this->addError('post', 'Post not found');
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