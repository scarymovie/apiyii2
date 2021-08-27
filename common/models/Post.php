<?php

namespace common\models;

use Yii;
use yii\db\BatchQueryResult;

class Post extends BasePost
{
    public function rules()
    {
        return [
            ['title','unique'],
            [['title', 'body'], 'required']
        ];
    }


    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['postId'] = $this->id;
        $serializedData['title'] = $this->title;
        $serializedData['createdBy'] = $this->created_by;

        return $serializedData;
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        if (empty($this->created_at) && (empty($this->updated_at)) && $insert) {
            $this->created_at = time();
            $this->updated_at = time();
        }
        $this->updated_at = time();
        $this->created_at = time();
        return true;

    }

}