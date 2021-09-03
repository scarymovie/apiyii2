<?php

namespace frontend\models;

use common\models\Post;
use yii\base\Model;

class ListPostForm extends Model
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
        $this->postQuery = Post::find()->limit($this->limit)->offset($this->offset);

        if (empty($this->postQuery)) {
            $this->getErrors();
        } else {
            return true;
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