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


      $randomstring = Yii::$app->utils->generateRandomString(6);
      $modelsave = Userdata::find()->where(['username'=>$username, 'role'=>2])->one();
      if($modelsave){
        $modelsave->password_reset_token = $randomstring;

       if ($modelsave->save(false)) {
         $to = $modelsave->email;
         $subject = 'Password Reset token';
         $body = 'Dear User ,
         <br>
         We need to make sure that this is you and not misused by unauthorized parties.
         <br>
         <br>
         This is your Password Reset Token :
         <br>
         '.$randomstring.'<br>
         --You are receiving this email from gojobs.id because you registered on gojobs.id with this email address--';
         $verification = Yii::$app->utils->sendmail($to,$subject,$body,3);
         return $modelsave->id;
       }
     }else{
       return null;
     }



    }

    return null;
  }
}
