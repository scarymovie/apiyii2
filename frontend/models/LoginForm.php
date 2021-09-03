<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;

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
        $user = User::find()
            ->andWhere(['username' => $this->username])
            ->one();

        if (empty($user)) {
            return [
                'error' => 'User not found',
            ];
        }

        if (!$user->validatePassword($this->password)) {
            return [
                'error' => 'Wrong password',
            ];
        }
        if (!$user->save()) {
            return $user->getErrors();
        }

        return [
            'user' => $user->serializeToArray(),
            'accessToken' => $user->access_token,
        ];

    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['username'] = $this->username;

        return $serializedData;
    }
}