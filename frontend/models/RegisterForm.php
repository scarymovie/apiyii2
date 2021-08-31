<?php

namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class RegisterForm extends Model
{
    public $username;
    public $email;
    public $password;

    public $user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => Yii::$app->params['user.passwordMinLength']],
        ];
    }

    public function loginByUsername()
    {
        if (!$this->validate()) {
            return $this->getErrors();
        }

        $this->validate($this->username);

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->generateEmailVerificationToken();
        $user->beforeSave($user);
        if (!$user->save()) {
            return $user->getErrors();
        } else {
            return true;
        }

    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['username'] = $this->username;
        $serializedData['email'] = $this->email;

        return $serializedData;
    }

}