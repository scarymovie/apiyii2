<?php

namespace common\models;

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
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (empty($this->created_at) && $insert) {
            $this->created_at = time();
        }
        $this->updated_at = time();
        return true;
    }

}