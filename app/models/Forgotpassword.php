<?php

namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class Forgotpassword extends Model
{
  public $username;


  /**
   * @inheritdoc
   */
  public function rules()
  {
    return [
      ['username', 'filter', 'filter' => 'trim'],
      ['username', 'required'],
      ['username', 'string', 'min' => 2, 'max' => 255],
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
  public function forgotpassword($username)
  {
    if ($this->validate()) {
      //comment this for temporary if email down/limit
      $randomstring = Yii::$app->utils->generateRandomString(6);

      // $randomstring = 'bypassreset';
      // $modelsave = Userdata::find()->where(['username' => $username, 'role' => 2])->one();
      $modelsave = Userdata::find()->where(['or', ['email' => $username], ['username' => $username]])->one();
      if ($modelsave) {
        $modelsave->password_reset_token = $randomstring;
        if ($modelsave->save(false)) {
          $to = $modelsave->email;
          // $to = 'khusnul.hisyam@ish.co.id';
          $subject = 'Password Reset token';
          $body = Yii::$app->params['mailForgotPassword'];
          $body = str_replace('{token}', $randomstring, $body);

          // added by kaha 21-04-2025
          $verification = Yii::$app->utils->sendmailbrevo($to, $subject, $body, 3);

          if ($verification['error'] === 0) {
            Yii::$app->session->setFlash('success', 'Email sent check your inbox');
            return $modelsave->id;
          }
          
          // Brevo failed, fallback to SMTP
          $verification2 = Yii::$app->utils->sendmail($to, $subject, $body, 3);
          if ($verification2['error'] === 0) {
            Yii::$app->session->setFlash('success', 'Email sent check your inbox or spam');
            return $modelsave->id;
          }

          // Both failed
          Yii::$app->session->setFlash('error', 'Email not sent');
          return null;
        }
      } else {
        return null;
      }
    }
    return null;
  }
}
