<?php

namespace frontend\models\registration;

use common\models\User;
use Yii;
use yii\base\Model;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $user;

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

    public function registerUser()
    {
        if (!$this->validate()) {
            $this->addError('', 'Введены некорректные данные');
            return false;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAccessToken();
        $user->generateAuthKey();
        /*$user->beforeSave((bool)$user);*/
        $user->generateEmailVerificationToken();
        if (!$user->save()) {
            $this->addErrors($user->getErrors());
            return false;
        }
        return true;
    }

    public function serializeToArray()
    {
        $serializedData = [];
        $serializedData['username'] = $this->username;
        $serializedData['email'] = $this->email;

        return $serializedData;
    }

}