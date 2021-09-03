<?php

namespace common\models;

use Yii;
use yii\db\BatchQueryResult;

class Post extends BasePost
{

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['postId'] = $this->id;
        $serializedData['title'] = $this->title;
        $serializedData['body'] = $this->body;
        $serializedData['createdBy'] = $this->created_by;

        return $serializedData;
    }

    public function beforeSave($insert)
    {
        if (empty($this->created_at)) {
            $this->created_at = time();
        }
        $this->updated_at = time();

        return true;

    }

}