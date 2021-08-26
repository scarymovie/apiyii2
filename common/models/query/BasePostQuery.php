<?php

namespace common\models\query;
use common\models\BasePost;
use common\models\Post;


class BasePostQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\BasePost[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\BasePost|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }


}