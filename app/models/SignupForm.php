<?php

namespace app\models;

use app\models\User;
use app\models\Userlogin;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
  public $username;
  public $email;
  public $password;
  public $role;
  public $retype_password;
  public $agree;
  public $name;
  public $mobile;

  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      // ['username', 'filter', 'filter' => 'trim'],
      // ['username', 'required'],
      // ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
      // ['username', 'string', 'min' => 2, 'max' => 255],

      ['email', 'filter', 'filter' => 'trim'],
      [['email', 'name', 'mobile'], 'required'],
      [['mobile'], 'integer'],
      ['email', 'email'],
      ['email', 'string', 'max' => 255],
      ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],

      ['password', 'required'],
      ['password', 'string', 'min' => 6],

      ['agree', 'required', 'on' => ['register'], 'requiredValue' => 1, 'message' => 'my test message'],
      ['agree', 'boolean'],

      ['retype_password', 'required'],
      ['retype_password', 'string', 'min' => 6],
      ['retype_password', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => false, 'message' => "Passwords don't match"],


    ];
  }

  /**
   * Signs user up.
   *
   * @return User|null the saved model or null if saving fails
   */
  public function generateValKey()
  {
    $this->auth_key = Yii::$app->security->generateRandomString();
  }
  public function signup()
  {
    if ($this->validate()) {
      $user = new User();
      $user->name = $this->name;
      $user->mobile = $this->mobile;
      $user->username = $this->email;
      $user->email = $this->email;
      $user->role = 2;
      $user->setPassword($this->password);
      $user->generateAuthKey();
      $randomstring = Yii::$app->utils->generateRandomString(6);
      // $randomstring = 'bypass'; //comment this for temporary if email down/limit
      $user->verify_code = $randomstring;
      // $user->verify_status = 1; //comment this for temporary if email down/limit
      $user->verify_status = 0;
      if ($user->save()) {
        $timeupdate = Userlogin::findOne($user->id);
        $timeupdate->created_at = date('Y-m-d H-i-s');
        $timeupdate->updated_at = date('Y-m-d H-i-s');
        $timeupdate->createdat = date('Y-m-d H-i-s');
        $timeupdate->updatedat = date('Y-m-d H-i-s');
        $timeupdate->save(false);

        $to = $this->email;
        $subject = 'Verify email';
        $body = Yii::$app->params['mailSignUp'];
        $body = str_replace('{fullname}', $this->name, $body);
        $body = str_replace('{token}', $randomstring, $body);

        // added by kaha 21-04-2025
        $verification = Yii::$app->utils->sendmailbrevo($to, $subject, $body, 1);
        if ($verification['error'] === 0) {
          Yii::$app->session->setFlash('success', 'Email sent check your inbox');
          return $user;
        }

        // Brevo failed, fallback to SMTP
        $verification2 = Yii::$app->utils->sendmail($to, $subject, $body, 1);

        if ($verification2['error'] === 0) {
          Yii::$app->session->setFlash('success', 'Email sent check your inbox or spam');
          return $user;
        }

        // Both failed
        Yii::$app->session->setFlash('error', 'Email not sent');
        return null;
      }
    }

    return null;
  }
}
