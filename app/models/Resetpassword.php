<?php
namespace app\models;

use app\models\User;
use yii\base\Model;
use Yii;

/**
* Signup form
*/
class Resetpassword extends Model
{
  public $password_reset_token;
  public $password;
  public $retype_password;
  public $username;


  /**
  * @inheritdoc
  */
  public function rules()
  {
    return [

      ['password_reset_token', 'required'],

      ['password', 'required'],
      ['password', 'string', 'min' => 6],

      ['agree', 'required', 'on' => ['register'], 'requiredValue' => 1, 'message' => 'my test message'],
      ['agree', 'boolean'],

      ['retype_password', 'required'],
      ['retype_password', 'string', 'min' => 6],
      ['retype_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message'=>"Passwords don't match"],


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

}
