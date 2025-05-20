<?php
namespace app\components;

use Yii;
use yii\base\Component;
use linslin\yii2\curl;
use app\models\User;
use app\models\Userlogin;




class OauthComponent extends Component {
  //start connect hris
  public function getaccesstoken($code){
    $curl = new curl\Curl();
    $getaccesstoken = $curl->setPostParams([
      'grant_type' => 'authorization_code',
      'code' => $code,
      'redirect_uri' => 'https://gojobs.id/rekrut/site/oauthhris',
      'client_id' => 'goj0bsid',
      'client_secret' => 'e95h0gf8x8mwlek9bqgy',
    ])
    ->post('https://passport.ish.co.id/core/api/sso/token');
    $response = $getaccesstoken;
    return $response;
  }

  public function getuserdata($token){
    $curl = new curl\Curl();
    $getuserdata = $curl->setPostParams([
      'access_token' => $token,
    ])
    ->post('https://passport.ish.co.id/core/api/sso/info');
    $useroauthdata = json_decode($getuserdata);
    if($useroauthdata->code == 1){
      // var_dump(Yii::$app->getUser());die;
      if ($user =  User::findByUsername($useroauthdata->data->username)) {
        if($user->access_token == $token){
          return Yii::$app->user->login($user);
        }else{
          $tokenupdate = Userlogin::findOne($user->id);
          $tokenupdate->auth_key =  $token;
          $tokenupdate->password_hash =  $token;
          $tokenupdate->access_token = $token;
          $tokenupdate->save(false);
          return Yii::$app->user->login($user);
        }
      } else {
        $model = new Userlogin();
        $model->username = $useroauthdata->data->username;
        $model->name = $useroauthdata->data->name;
        $model->email = $useroauthdata->data->email;
        $model->mobile = $useroauthdata->data->mobile;
        $model->status = 10;
        $model->role = 12;
        $model->password_hash = $token;
        $model->auth_key = $token;
        $model->access_token = $token;
        $model->verify_status = 1;
        $model->created_at = date('Y-m-d H-i-s');
        $model->updated_at = date('Y-m-d H-i-s');
        if($model->save(false)){
          if ($user =  User::findByUsername($useroauthdata->data->username)) {
            return Yii::$app->user->login($user);
          }
        }
        return null;
      }
    }
    return null;

  }
  
  public function logout($id){
    $user =  User::findIdentity($id);
    // var_dump($user);die();
    $curl = new curl\Curl();
    $logout = $curl->setPostParams([
      'access_token' => $user->access_token,
    ])
    ->post('https://passport.ish.co.id/core/api/sso/logout');
    // var_dump($getaccesstoken);die;
    $response = $logout;
    return $response;
  }
  //end connect hris
}
