<?php

namespace frontend\models\login;

use common\models\User;
use Yii;
use yii\base\Model;

class LoginByUsernameForm extends Model
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

    public function login()
    {
        if (!$this->validate()) {
            $this->addError('', 'Введены некорректные данные');
            return false;
        }

        $this->user = User::find()
            ->andWhere(['username' => $this->username])
            ->one();

        if (empty($this->user)) {
            $this->addError('username', 'User not found');
            return false;
        }

        if (!$this->user->validatePassword($this->password)) {
            $this->addError('password', 'Incorrect password');
            return false;
        }
        if (!$this->user->save()) {
            $this->addErrors($this->user->getErrors());
            return false;
        }
            return true;
    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['username'] = $this->username;
        $serializedData['access_token'] = $this->user->access_token;

        return $serializedData;
    }
}