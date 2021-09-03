<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $user;

    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    public function loginByUsername()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        };
        $this->user = User::find()
            ->andWhere(['username' => $this->username])
            ->one();

        if (empty($this->user)) {
            return $this->getErrors();
        }

        if (!$this->user->validatePassword($this->password)) {
            return $this->getErrors();
        }
        if (!$this->user->save()) {
            return $this->user->getErrors();
        } else {
            return true;
        }
    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['username'] = $this->username;
        $serializedData['access_token'] = $this->user->access_token;

        return $serializedData;
    }
}