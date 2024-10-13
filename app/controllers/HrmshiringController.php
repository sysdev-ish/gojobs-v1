<?php

namespace app\controllers;

use Yii;
use app\models\Hiring;
use app\models\Transrincian;
use app\models\Transjo;
use app\models\Userprofile;
use app\models\Useremergencycontact;
use app\models\Userfamily;
use app\models\Userformaleducation;
use app\models\Usernonformaleducation;
use app\models\Userabout;
use app\models\Hiringsearch;
use app\models\Chagerequestjo;
use app\models\Recruitmentcandidatefhsearch;
use app\models\Userlogin;
use app\models\User;
use app\models\Maillog;
use app\models\MappingCity;
use app\models\Province;
use app\models\Saparea;
use app\models\Sapjob;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use linslin\yii2\curl;
use yii\filters\AccessControl;

/**
 * HrmsHiringController implements the CRUD actions for Hiring model.
 */
class HrmshiringController extends Controller
{
  /**
   * @inheritdoc
   */
  // hiring process insert to HRMS trigger by id hiring
  public function actionHiring($id = null)
  {
    $raw = Hiring::find()->where(['id' => $id, 'statushiring' => 4])->orderBy(['id' => SORT_DESC])->one();
    // var_dump($raw);die();
    if ($raw) {
      $model = $this->findModel($raw->id);
      $trans_rincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
      $city_id = MappingCity::find()->where(['city_id' => $trans_rincian->lokasi])->one();
      $province_id = Province::find()->where(['id' => $city_id->province_id])->one();
      $user_profile = Userprofile::find()->where(['userid' => $model->userid])->one();
      $hiring = Hiring::find()->where(['userid' => $model->userid])->one();

      $join_date = date_create($model->tglinput);
      $contract_startdate = date_create($model->awalkontrak);
      // $contract_enddate = date_create($model->akhirkontrak);

      $curl = new curl\Curl();
      // initial get access token
      $check_token1 = $curl->setPostParams([
        'username' => 'gojobs',
        'password' => 'u3p5bL1E3'
      ])->post('https://hrpay.ish.co.id/middleware/auth/login');
      $access_token1 = json_decode($check_token1);

      if ($access_token1->status == 1) {
        // initital check payroll controll hrpay
        $curl->setHeaders([
          'token' => $access_token1->data->access_token
        ]);
        $paycontroll_check = $curl->setPostParams([
          'code' => $trans_rincian->abkrs_sap,
        ])->post('https://hrpay.ish.co.id/middleware/parea/check');
        $payrollcontroll_result = json_decode($paycontroll_check);
        // var_dump($payrollcontroll_result);die();
        if ($payrollcontroll_result->status == 1) {
          // initial get access token
          $curl2 = new curl\Curl();
          $check_token2 = $curl2->setPostParams([
            'username' => 'gojobs',
            'password' => 'u3p5bL1E3'
          ])->post('https://hrpay.ish.co.id/middleware/auth/login');
          $access_token2 = json_decode($check_token2);
          // var_dump($access_token2);die();
          if ($access_token2->status == 1) {
            // initial check position hrpay
            $curl2->setHeaders([
              'token' => $access_token2->data->access_token
            ]);
            // var_dump($trans_rincian->persa_sap, $trans_rincian->hire_jabatan_sap, $trans_rincian->area_sap, $trans_rincian->level_sap);die();
            $position_check =  $curl2->setPostParams([
              'personel_area_code' => $trans_rincian->persa_sap,
              'job_code' => $trans_rincian->hire_jabatan_sap,
              'skill_code' => $trans_rincian->skill_sap,
              'area_code' => $trans_rincian->area_sap,
              'level_code' => $trans_rincian->level_sap,
              // 'debug' => 1
            ])->post('https://hrpay.ish.co.id/middleware/position/check');
            $position_result = json_decode($position_check);
            // var_dump($position_result);die();
            if ($position_result->status == 1) {
              if ($position_result->code == 1) {
                if ($user_profile->gender == 'male') {
                  $gender = 'laki-laki';
                } else {
                  $gender = 'perempuan';
                }
                if ($user_profile->maritalstatus == 'single') {
                  $marital_status = 'belum menikah';
                } else {
                  $marital_status = 'menikah';
                }
                if ($user_profile->religion == 'islam') {
                  $religion = 'islam';
                } elseif ($user_profile->religion == 'christian') {
                  $religion = 'kristen';
                } elseif ($user_profile->religion == 'protestant') {
                  $religion = 'protestan';
                } elseif ($user_profile->religion == 'hindu') {
                  $religion = 'hindu';
                } elseif ($user_profile->religion == 'buddha') {
                  $religion = 'buddha';
                } elseif ($user_profile->religion == 'catholic') {
                  $religion = 'catolic';
                } else {
                  $religion = 'not found';
                }
                if ($trans_rincian->kontrak == 'PKWT') {
                  $contract_type = 'PKWT';
                } elseif ($trans_rincian->kontrak == 'PARTTIME' or $trans_rincian->kontrak == 'Part Time') {
                  $contract_type = 'PARTTIME';
                } elseif ($trans_rincian->kontrak == 'MAGANG') {
                  $contract_type = 'MAGANG';
                } elseif ($trans_rincian->kontrak == 'KEMITRAAN') {
                  $contract_type = 'KEMITRAAN';
                } elseif ($trans_rincian->kontrak == 'THL') {
                  $contract_type = 'THL';
                } elseif ($trans_rincian->kontrak == 'PKWT-KEMITRAAN PB') {
                  $contract_type = 'PKWT-KEMITRAAN PB';
                }

                if ($trans_rincian->typejo == 1) {
                  $massg = "new";
                } else {
                  $massg = "replacement";
                }
                $birth_date = date_create($user_profile->birthdate);

                // initial hiring
                // initial get access token
                $curl3 = new curl\Curl();
                $check_token3 = $curl3->setPostParams([
                  'username' => 'gojobs',
                  'password' => 'u3p5bL1E3'
                ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                $access_token3 = json_decode($check_token3);
                // var_dump($access_token3);die();
                if ($access_token3->status == 1) {
                  // initial check position hrpay
                  $curl3->setHeaders([
                    'token' => $access_token3->data->access_token
                  ]);

                  // array data insert hiring
                  $array = [
                    'action_type' => 'Z1',
                    'jo_type' => $massg,
                    'contract_type' => $contract_type,
                    'contract_startdate' => date_format($contract_startdate, 'Y-m-d'),
                    'contract_enddate' => '9999-12-31',
                    'personel_area_code' => $trans_rincian->persa_sap,
                    'area_code' => $trans_rincian->area_sap,
                    'payroll_area_code' => $trans_rincian->abkrs_sap,
                    'job_code' => $trans_rincian->hire_jabatan_sap,
                    'skill_code' => $trans_rincian->skill_sap,
                    'level_code' => $trans_rincian->level_sap,
                    'province_name' => $province_id->name_province,
                    'city_name' => $city_id->city_name,
                    'joindate' => date_format($join_date, 'Y-m-d'),
                    'nationality' => 'Indonesia',
                    // 'sap_perner' => $hiring->perner,
                    'position_id' => $position_result->data->code,
                    'fullname' => $user_profile->fullname,
                    'birthplace' => $user_profile->birthplace,
                    'birthdate' => date_format($birth_date, 'Y-m-d'),
                    'religion' => $religion,
                    'gender' => $gender,
                    'marital_status' => $marital_status,
                    'ktp_number' => $user_profile->identitynumber,
                    'kk_number' => $user_profile->kknumber,
                    'debug' => 1
                  ];
                  // var_dump($array);die();
                  $hiring_check = $curl3->setPostParams($array)->post('https://hrpay.ish.co.id/middleware/hraction/hiring');
                  // var_dump($hiring);die();
                  $hiring_result = json_decode($hiring_check);

                  // echo '<pre>';
                  // var_dump($hiring_result);die();
                  // echo '</pre>';

                  // result hiring -> update biodata
                  if ($hiring_result->status == 1) {
                    // initial check payroll
                    $curl4 = new curl\Curl();
                    // initial get access token
                    $check_token4 = $curl4->setPostParams([
                      'username' => 'gojobs',
                      'password' => 'u3p5bL1E3'
                    ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                    $access_token4 = json_decode($check_token4);

                    if ($access_token4->status == 1) {
                      // 
                      $curl4->setHeaders([
                        'token' => $access_token4->data->access_token
                      ]);
                      // initiate get data all biodata from gojobs
                      $user = User::find()->where(['id' => $model->userid])->one();
                      $user_profile = Userprofile::find()->where(['userid' => $model->userid])->one();
                      $user_econtact = Useremergencycontact::find()->where(['userid' => $model->userid])->one();
                      $user_family = Userfamily::find()->where(['userid' => $model->userid])->all();
                      $user_feduca = Userformaleducation::find()->where(['userid' => $model->userid])->all();
                      $user_nonfeduca = Usernonformaleducation::find()->where(['userid' => $model->userid])->all();
                      $user_about = Userabout::find()->where(['userid' => $model->userid])->one();
                      // var_dump($user_about);die();
                      $birth_date = date_create($user_profile->birthdate);
                      $join_date = date_create($model->tglinput);
                      $contract_startdate = date_create($model->awalkontrak);
                      // 
                      if ($user_profile->gender == 'male') {
                        $gender = 'laki-laki';
                      } else {
                        $gender = 'perempuan';
                      }

                      if ($user_profile->maritalstatus == 'single') {
                        $marital_status = '0';
                      } else {
                        $marital_status = '1';
                      }

                      $address_data = $this->findAddressdata($model, $user_profile, $user_econtact);
                      // echo '<pre>';
                      // var_dump($address_data);die();
                      // echo '</pre>';

                      $family_data = $this->findUserfamily($model, $user_family);
                      $user_education = $this->findUsereducation($model, $user_feduca, $user_nonfeduca);

                      // initial request data to post insert biodata
                      $request_data = [
                        'perner' => $hiring_result->data->personal_number,
                        'address' => $address_data,
                        'family' => $family_data,
                        'education' => $user_education,
                        'tax' => [
                          [
                            'npwp_registration_date' => date_format($join_date, 'Y-m-d'),
                            'company_tax_id' => '000000000000000',
                            // 'personal_card_id' => $user_profile->identitynumber,
                            'personal_tax_id' => ($user_profile->npwpnumber) ? $user_profile->npwpnumber : '000000000000000', // validasi max character 15
                          ],
                        ],
                        'jamsostek' => [
                          [
                            'id_number' => ($user_profile->jamsosteknumber) ? $user_profile->jamsosteknumber : '00000000000', // validasi max character 11
                            'married' => $marital_status,
                          ]
                        ],
                        'bank' => [
                          [
                            'startdate' => date_format($join_date, 'Y-m-d'),
                            'enddate' => '9999-12-31',
                            'bank_key' => $user_about->bankname->sapid, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
                            'bank_type' => 'main', //validasi max character 11
                            'bank_account' => $user_about->bankaccountnumber
                          ]
                        ],

                        'email' => [
                          [
                            'email' => $user->email,
                            'type' => 'main'
                          ]
                        ],
                        'mobile' => [
                          [
                            'mobile' => $user->mobile,
                            'type' => 'main',
                          ]
                        ],
                      ];


                      // initiate hit biodata update/ insert
                      $curl6 = new curl\Curl();
                      // initial get access token
                      $check_token6 = $curl6->setPostParams([
                        'username' => 'gojobs',
                        'password' => 'u3p5bL1E3'
                      ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                      $access_token6 = json_decode($check_token6);
                      // var_dump($access_token6);die();
                      // initiate post biodata update
                      // $biodata_array = json_encode($request_data);
                      // echo '<pre>';
                      // var_dump($request_data);die();
                      // echo '</pre>';
                      // 
                      $curl6->setHeaders([
                        'token' => $access_token6->data->access_token
                      ]);
                      $raw_biodata = $curl6->setPostParams($request_data)->post('https://hrpay.ish.co.id/middleware/employee/bio');
                      var_dump($raw_biodata);
                      die();
                      $ret = json_decode($raw_biodata);
                      var_dump($ret);
                      die();

                      // 
                      if ($ret->status == 1) {
                        $model->flaginfotype022 = 1;
                        $model->save();
                        // print_r(json_encode($ret));
                      } else {
                        $model->flaginfotype021 = 1;
                        $model->save();
                        // print_r(json_encode($ret));
                      }
                    } else {
                      $retlogin4 = ['status' => $access_token4->status, 'message' => $access_token4->message];
                      print_r(json_encode($retlogin4));
                    }
                    $hiring->is_hiring_hrms = 1;
                    if ($hiring->save()) {
                      $update_hiring = 'Success Hiring HRMS';
                    }
                    $rethiring = ['status' => $hiring_result->status, 'perner' => $hiring->perner, 'message' => $hiring_result->message . ', ' . $update_hiring];
                  } else {
                    $hiring->is_hiring_hrms = 2;
                    if ($hiring->save()) {
                      $update_hiring = 'Cant Hiring HRMS';
                    }
                    $rethiring = ['status' => $hiring_result->status, 'perner' => $hiring->perner, 'message' => $hiring_result->message . ', ' . $update_hiring];
                  }
                  print_r(json_encode($rethiring));
                } else {
                  $retlogin3 = ['status' => $access_token3->status, 'message' => $access_token3->message];
                  print_r(json_encode($retlogin3));
                }
              } else {
                $retpos = [
                  'status' => $position_result->status, 'message' => $position_result->message,
                  'data' => [
                    'job_code' => $trans_rincian->hire_jabatan_sap,
                    'persa_code' => $trans_rincian->persa_sap,
                    'skill_code' => $trans_rincian->skill_sap,
                    'level_code' => $trans_rincian->level_sap,
                    'area_code' => $trans_rincian->area_sap
                  ]
                ];
                print_r(json_encode($retpos));
              }
            } else {
              $retpos = [
                'status' => $position_result->status, 'message' => $position_result->message,
                'data' => [
                  'job_code' => $trans_rincian->hire_jabatan_sap,
                  'persa_code' => $trans_rincian->persa_sap,
                  'skill_code' => $trans_rincian->skill_sap,
                  'level_code' => $trans_rincian->level_sap,
                  'area_code' => $trans_rincian->area_sap
                ]
              ];
              print_r(json_encode($retpos));
            }
          } else {
            $retlogin2 = ['status' => $access_token2->status, 'message' => $access_token2->message];
            print_r(json_encode($retlogin2));
          }
        } else {
          $retlock = ['status' => $payrollcontroll_result->status, 'message' => $payrollcontroll_result->message, 'data' => [
            'payroll_code' => $trans_rincian->abkrs_sap,
          ]];
          print_r(json_encode($retlock));
        }
      } else {
        $retlogin1 = ['status' => $access_token1->status, 'message' => $access_token1->message];
        print_r(json_encode($retlogin1));
      }
    }
  }

  // hiring process insert to HRMS 
  //change by kaha 2/11/22 -> for by pass lock position (Search position on SAP)
  public function actionHiringbypa($client = null)
  {
    // $trans_rincian = Transrincian::find()->select('id')->where(['persa_sap' => $client, 'status_rekrut' => 2])->all();
    $params = [':persa' => $client, ':status' => 2];
    $raw_rincian = Yii::$app->dbjo->createCommand('SELECT id, persa_sap as personal_area, abkrs_sap as payroll_area, hire_jabatan_sap as job, area_sap as area FROM trans_rincian_rekrut WHERE persa_sap=:persa AND status_rekrut=:status', $params)
      ->queryAll();

    // echo '<pre>';
    // var_dump($raw_rincian);
    // die();
    // echo '</pre>';

    $initiate = 0;
    foreach ($raw_rincian as $obj) {
      // 
      $initiate++;
      $parameters = [':recruitreqid' => $obj['id'], ':status_hiring' => 4];
      $objhiring = Yii::$app->db->createCommand('SELECT id, perner FROM hiring WHERE statushiring=:status_hiring AND recruitreqid=:recruitreqid AND is_hiring_hrms IS NULL OR is_hiring_hrms = 2', $parameters)
        ->queryAll();
      // var_dump($objhiring);die();
      // $objhiring = Hiring::find()->where(['recruitreqid' => $obj['id'], 'statushiring' => 4])->orderBy(['id' => SORT_DESC])->all();

      // var_dump($objhiring);die();
      if ($objhiring) {
        // var_dump($objhiring);die();
        foreach ($objhiring as $rawhiring) {
          $model = $this->findModel($rawhiring['id']);
          $trans_rincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
          $city_id = MappingCity::find()->where(['city_id' => $trans_rincian->lokasi])->one();
          $province_id = Province::find()->where(['id' => $city_id->province_id])->one();
          $user_profile = Userprofile::find()->where(['userid' => $model->userid])->one();

          $join_date = date_create($model->tglinput);
          $contract_startdate = date_create($model->awalkontrak);
          // $contract_enddate = date_create($model->akhirkontrak);

          $curl = new curl\Curl();
          // initial get access token
          $check_token1 = $curl->setPostParams([
            'username' => 'gojobs',
            'password' => 'u3p5bL1E3'
          ])->post('https://hrpay.ish.co.id/middleware/auth/login');
          $access_token1 = json_decode($check_token1);

          if ($access_token1->status == 1) {
            // initital check payroll controll hrpay
            $curl->setHeaders([
              'token' => $access_token1->data->access_token
            ]);
            $paycontroll_check = $curl->setPostParams([
              'code' => $trans_rincian->abkrs_sap,
            ])->post('https://hrpay.ish.co.id/middleware/parea/check');
            $payrollcontroll_result = json_decode($paycontroll_check);
            // var_dump($payrollcontroll_result);die();
            if ($payrollcontroll_result->status == 1) {
              // initial get access token
              $curl2 = new curl\Curl();
              $check_token2 = $curl2->setPostParams([
                'username' => 'gojobs',
                'password' => 'u3p5bL1E3'
              ])->post('https://hrpay.ish.co.id/middleware/auth/login');
              $access_token2 = json_decode($check_token2);
              // var_dump($access_token2);die();
              if ($access_token2->status == 1) {
                // initial check position hrpay
                $curl2->setHeaders([
                  'token' => $access_token2->data->access_token
                ]);
                // var_dump($trans_rincian->persa_sap, $trans_rincian->hire_jabatan_sap, $trans_rincian->area_sap, $trans_rincian->level_sap);die();
                $position_check =  $curl2->setPostParams([
                  'personel_area_code' => $trans_rincian->persa_sap,
                  'job_code' => $trans_rincian->hire_jabatan_sap,
                  'skill_code' => $trans_rincian->skill_sap,
                  'area_code' => $trans_rincian->area_sap,
                  'level_code' => $trans_rincian->level_sap,
                  // 'debug' => 1
                ])->post('https://hrpay.ish.co.id/middleware/position/check');
                // var_dump($position_check);die();
                $position_result = json_decode($position_check);
                // var_dump($position_result);die();
                if ($position_result->status == 1) {
                  if ($position_result->code == 1) {
                    if ($user_profile->gender == 'male') {
                      $gender = 'laki-laki';
                    } else {
                      $gender = 'perempuan';
                    }
                    if ($user_profile->maritalstatus == 'single') {
                      $marital_status = 'belum menikah';
                    } else {
                      $marital_status = 'menikah';
                    }
                    if ($user_profile->religion == 'islam') {
                      $religion = 'islam';
                    } elseif ($user_profile->religion == 'christian') {
                      $religion = 'kristen';
                    } elseif ($user_profile->religion == 'protestant') {
                      $religion = 'protestan';
                    } elseif ($user_profile->religion == 'hindu') {
                      $religion = 'hindu';
                    } elseif ($user_profile->religion == 'buddha') {
                      $religion = 'buddha';
                    } elseif ($user_profile->religion == 'catholic') {
                      $religion = 'catolic';
                    } else {
                      $religion = 'not found';
                    }
                    if ($trans_rincian->kontrak == 'PKWT') {
                      $contract_type = 'PKWT';
                    } elseif ($trans_rincian->kontrak == 'PARTTIME' or $trans_rincian->kontrak == 'Part Time') {
                      $contract_type = 'PARTTIME';
                    } elseif ($trans_rincian->kontrak == 'MAGANG') {
                      $contract_type = 'MAGANG';
                    } elseif ($trans_rincian->kontrak == 'KEMITRAAN') {
                      $contract_type = 'KEMITRAAN';
                    } elseif ($trans_rincian->kontrak == 'THL') {
                      $contract_type = 'THL';
                    } elseif ($trans_rincian->kontrak == 'PKWT-KEMITRAAN PB') {
                      $contract_type = 'PKWT-KEMITRAAN PB';
                    }

                    if ($trans_rincian->typejo == 1) {
                      $massg = "new";
                    } else {
                      $massg = "replacement";
                    }
                    $birth_date = date_create($user_profile->birthdate);

                    // initial hiring
                    // initial get access token
                    $curl3 = new curl\Curl();
                    $check_token3 = $curl3->setPostParams([
                      'username' => 'gojobs',
                      'password' => 'u3p5bL1E3'
                    ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                    $access_token3 = json_decode($check_token3);
                    // var_dump($access_token3);die();
                    if ($access_token3->status == 1) {
                      // initial check position hrpay
                      $curl3->setHeaders([
                        'token' => $access_token3->data->access_token
                      ]);

                      // array data insert hiring
                      $array = [
                        'action_type' => 'Z1',
                        'jo_type' => $massg,
                        'contract_type' => $contract_type,
                        'contract_startdate' => date_format($contract_startdate, 'Y-m-d'),
                        'contract_enddate' => '9999-12-31',
                        'personel_area_code' => $trans_rincian->persa_sap,
                        'area_code' => $trans_rincian->area_sap,
                        'payroll_area_code' => $trans_rincian->abkrs_sap,
                        'job_code' => $trans_rincian->hire_jabatan_sap,
                        'skill_code' => $trans_rincian->skill_sap,
                        'level_code' => $trans_rincian->level_sap,
                        'province_name' => $province_id ? $province_id->name_province : '-',
                        'city_name' => $city_id ? $city_id->city_name : '-',
                        'joindate' => date_format($join_date, 'Y-m-d'),
                        'nationality' => 'Indonesia',
                        'sap_perner' => $rawhiring['perner'],
                        'position_id' => $position_result->data->code,
                        'fullname' => $user_profile->fullname,
                        'birthplace' => $user_profile->birthplace,
                        'birthdate' => date_format($birth_date, 'Y-m-d'),
                        'religion' => $religion,
                        'gender' => $gender,
                        'ktp_number' => ($user_profile->identitynumber) ? $user_profile->identitynumber : '0000000000000000',
                        'kk_number' => ($user_profile->kknumber) ? $user_profile->kknumber : '0000000000000000',
                        'marital_status' => $marital_status,
                        // 'debug' => 1
                      ];
                      // var_dump($array);die();
                      $hiring_check = $curl3->setPostParams($array)->post('https://hrpay.ish.co.id/middleware/hraction/hiring');
                      // var_dump($hiring_check);die();
                      $rethiring = json_decode($hiring_check);

                      // echo '<pre>';
                      // var_dump($rethiring->status);
                      // die();
                      // echo '</pre>';

                      if ($rethiring) {

                        // result hiring -> update biodata
                        if ($rethiring->status == 1) {
                          $curl4 = new curl\Curl();
                          // initial get access token
                          $check_token4 = $curl4->setPostParams([
                            'username' => 'gojobs',
                            'password' => 'u3p5bL1E3'
                          ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                          $access_token4 = json_decode($check_token4);

                          if ($access_token4->status == 1) {
                            // 
                            $curl4->setHeaders([
                              'token' => $access_token4->data->access_token
                            ]);
                            // initiate get data all biodata from gojobs
                            $user = User::find()->where(['id' => $model->userid])->one();
                            $user_profile = Userprofile::find()->where(['userid' => $model->userid])->one();
                            $user_econtact = Useremergencycontact::find()->where(['userid' => $model->userid])->one();
                            $user_family = Userfamily::find()->where(['userid' => $model->userid])->all();
                            $user_feduca = Userformaleducation::find()->where(['userid' => $model->userid])->all();
                            $user_nonfeduca = Usernonformaleducation::find()->where(['userid' => $model->userid])->all();
                            $user_about = Userabout::find()->where(['userid' => $model->userid])->one();
                            // var_dump($user_about);die();
                            $birth_date = date_create($user_profile->birthdate);
                            $join_date = date_create($model->tglinput);
                            $contract_startdate = date_create($model->awalkontrak);
                            // 
                            if ($user_profile->gender == 'male') {
                              $gender = 'laki-laki';
                            } else {
                              $gender = 'perempuan';
                            }

                            if ($user_profile->maritalstatus == 'single') {
                              $marital_status = '0';
                            } else {
                              $marital_status = '1';
                            }

                            $address_data = $this->findAddressdata($model, $user_profile, $user_econtact);
                            $family_data = $this->findUserfamily($model, $user_family);
                            $user_education = $this->findUsereducation($model, $user_feduca, $user_nonfeduca);
                            // echo '<pre>';
                            // var_dump($address_data);die();
                            // echo '</pre>';

                            // initial request data to post insert biodata
                            $request_data = [
                              'perner' => $rethiring->data->personal_number,
                              'address' => $address_data,
                              'family' => $family_data,
                              'education' => $user_education,
                              'tax' => [
                                [
                                  'npwp_registration_date' => date_format($join_date, 'Y-m-d'),
                                  'company_tax_id' => '000000000000000',
                                  // 'personal_card_id' => $user_profile->identitynumber,
                                  'personal_tax_id' => ($user_profile->npwpnumber) ? $user_profile->npwpnumber : '000000000000000', // validasi max character 15
                                ],
                              ],
                              'jamsostek' => [
                                [
                                  'id_number' => ($user_profile->jamsosteknumber) ? $user_profile->jamsosteknumber : '00000000000', // validasi max character 11
                                  'married' => $marital_status,
                                ]
                              ],
                              'bank' => [
                                [
                                  'startdate' => date_format($join_date, 'Y-m-d'),
                                  'enddate' => '9999-12-31',
                                  'bank_key' => $user_about->bankname->sapid, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
                                  'bank_type' => 'main', //validasi max character 11
                                  'bank_account' => ($user_about->bankaccountnumber) ? $user_about->bankaccountnumber : '00000000000'
                                ]
                              ],

                              'email' => [
                                [
                                  'email' => $user->email,
                                  'type' => 'main'
                                ]
                              ],
                              'mobile' => [
                                [
                                  'mobile' => $user->mobile,
                                  'type' => 'main',
                                ]
                              ],
                            ];


                            // initiate hit biodata update/ insert
                            $curl6 = new curl\Curl();
                            // initial get access token
                            $check_token6 = $curl6->setPostParams([
                              'username' => 'gojobs',
                              'password' => 'u3p5bL1E3'
                            ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                            $access_token6 = json_decode($check_token6);
                            // var_dump($access_token6);die();
                            // $biodata_array = json_encode($request_data);
                            // echo '<pre>';
                            // var_dump($request_data);die();
                            // echo '</pre>';
                            // 
                            // initiate post biodata update
                            $curl6->setHeaders([
                              'token' => $access_token6->data->access_token
                            ]);
                            $raw_biodata = $curl6->setPostParams($request_data)->post('https://hrpay.ish.co.id/middleware/employee/bio');
                            // var_dump($raw_biodata); die();
                            $ret = json_decode($raw_biodata);
                            // var_dump($ret); die();
                            // 
                            if ($ret) {
                              if ($ret->status == 1) {
                                $model->is_biodata_hrms = 1;
                                $model->save();
                                $retbio = ['status' => $ret->status, 'message' => $ret->message, 'perner' => $rawhiring['perner']];
                                print_r(json_encode($retbio));
                              } else {
                                $model->is_biodata_hrms = 2;
                                $model->save();
                                $retbio = ['status' => $ret->status, 'message' => $ret->message, 'perner' => $rawhiring['perner']];
                                print_r(json_encode($retbio));
                              }
                            }
                          } else {
                            $retlogin4 = ['status' => $access_token4->status, 'message' => $access_token4->message];
                            print_r(json_encode($retlogin4));
                          }

                          // 
                          $model->is_hiring_hrms = 1;
                          $model->save();
                          $update_hiring = 'Success Hiring HRMS';
                          $rethire = ['status' => $rethiring->status, 'message' => $rethiring->message . ', ' . $update_hiring, 'perner' => $rawhiring['perner']];
                          print_r(json_encode($rethire));
                        } else {
                          $model->is_hiring_hrms = 2;
                          $model->save();
                          print_r($rethiring->message);
                          $rethire = ['status' => $rethiring->status, 'message' => $rethiring->message, 'perner' => $rawhiring['perner']];
                          print_r(json_encode($rethire));
                        }
                      }
                    } else {
                      $retlogin3 = ['status' => $access_token3->status, 'message' => $access_token3->message];
                      print_r(json_encode($retlogin3));
                    }
                  } else {
                    $retpos = ['status' => $position_result->status, 'message' => $position_result->message, 'perner' => $rawhiring['perner']];
                    print_r($retpos);
                  }
                } else {
                  $retpos = ['status' => $position_result->status, 'message' => $position_result->message, 'perner' => $rawhiring['perner']];
                  print_r($retpos);
                }
              } else {
                $retlogin2 = ['status' => $access_token2->status, 'message' => $access_token2->message];
                print_r(json_encode($retlogin2));
              }
            } else {
              print_r($paycontroll_check->message);
            }
          } else {
            $retlogin1 = [
              'status' => $access_token1->status, 'message' => $access_token1->message
            ];
            print_r($retlogin1);
          }
        }
      }
    }
  }

  public function actionHiringbysap($client = null)
  {
    // $trans_rincian = Transrincian::find()->select('id')->where(['persa_sap' => $client, 'status_rekrut' => 2])->all();
    $curl_pa = new curl\Curl();
    $getbypa =  $curl_pa->setPostParams([
      'personnalarea' => $client,
      'token' => 'ish**2019',
    ])
      ->post('http://192.168.88.5/service/index.php/sap_profile/getdatapekerjabypa');
    $curl_pa->reset();
    $raw_obj  = json_decode($getbypa);

    $initiate = 0;
    foreach ($raw_obj as $obj) {
      // 
      // $initiate++; // loss limit
      if ($initiate++ == 51) break; // limit
      $curl_worker = new curl\Curl();
      $getdatapekerja =  $curl_worker->setPostParams([
        'perner' => $obj->id,
        // 'perner' => '205210',
        'token' => 'ish**2019',
        'name' => $obj->CNAME,
      ])
        ->post('http://192.168.88.5/service/index.php/sap_profile/getworker');
      // var_dump($getdatapekerja);die();
      $curl_worker->reset();
      $data_pekerja  = json_decode($getdatapekerja);
      // var_dump($data_pekerja);die();

      if ($data_pekerja) {
        // initial get access token
        $curl = new curl\Curl();
        // $check_token1 = $curl->setPostParams([
        //   'username' => 'gojobs',
        //   'password' => 'u3p5bL1E3'
        // ])->post('https://hrpay.ish.co.id/middleware/auth/login');
        // $access_token1 = json_decode($check_token1);

        // if ($access_token1->status == 1) {
          // initital check payroll controll hrpay
          $curl->setHeaders([
            // 'token' => $access_token1->data->access_token
            'token' => '*4mbur4do3l#'
          ]);
          $paycontroll_check = $curl->setPostParams([
            // payroll area code
            'code' => $data_pekerja[0]->payroll_area,
          ])->post('https://hrpay.ish.co.id/middleware/parea/check');
          $curl->reset();
          $payrollcontroll_result = json_decode($paycontroll_check);
          // var_dump($payrollcontroll_result);die();
          if ($payrollcontroll_result->status == 1) {
            // initial get access token
            $curl2 = new curl\Curl();
            // $check_token2 = $curl2->setPostParams([
            //   'username' => 'gojobs',
            //   'password' => 'u3p5bL1E3'
            // ])->post('https://hrpay.ish.co.id/middleware/auth/login');
            // $access_token2 = json_decode($check_token2);
            // var_dump($access_token2);die();
            // if ($access_token2->status == 1) {
              $area = Saparea::find()->where(['value1' => $data_pekerja[0]->area])->one();
              $city = MappingCity::find()->where(['city_id' => $area->value1])->one();
              $job_code = Sapjob::find()->where(['value2' => $data_pekerja[0]->job_name])->one();
              // var_dump($job_code);die();
              // var_dump($city);die();
              if ($city) {
                $res_province = Province::find()->where(['id' => $city->province_id])->one();
                $province = $res_province->name_province;
              } else {
                $province = '-';
              }
              // var_dump($province);die();
              // 
              if ($data_pekerja[0]->start_contract_date) {
                $year = substr($data_pekerja[0]->start_contract_date, 0, 4);
                $month = substr($data_pekerja[0]->start_contract_date, 4, 2);
                $date = substr($data_pekerja[0]->start_contract_date, 6, 2);
                $contract_startdate = $year . "-" . $month . "-" . $date;
              }

              if ($data_pekerja[0]->end_contract_date) {
                $year = substr($data_pekerja[0]->end_contract_date, 0, 4);
                $month = substr($data_pekerja[0]->end_contract_date, 4, 2);
                $date = substr($data_pekerja[0]->end_contract_date, 6, 2);
                $contract_enddate = $year . "-" . $month . "-" . $date;
              }

              if ($data_pekerja[0]->join_date) {
                $year = substr($data_pekerja[0]->join_date, 0, 4);
                $month = substr($data_pekerja[0]->join_date, 4, 2);
                $date = substr($data_pekerja[0]->join_date, 6, 2);
                $join_date = $year . "-" . $month . "-" . $date;
              }
              // 
              if ($data_pekerja[0]->birth_date) {
                $year = substr($data_pekerja[0]->birth_date, 0, 4);
                $month = substr($data_pekerja[0]->birth_date, 4, 2);
                $date = substr($data_pekerja[0]->birth_date, 6, 2);
                $birth_date = $year . "-" . $month . "-" . $date;
              }
              if ($data_pekerja[0]->start_education_date) {
                $year = substr($data_pekerja[0]->start_education_date, 0, 4);
                $month = substr($data_pekerja[0]->start_education_date, 4, 2);
                $date = substr($data_pekerja[0]->start_education_date, 6, 2);
                $start_education_date = $year . "-" . $month . "-" . $date;
              }
              if ($data_pekerja[0]->end_education_date) {
                $year = substr($data_pekerja[0]->end_education_date, 0, 4);
                $month = substr($data_pekerja[0]->end_education_date, 4, 2);
                $date = substr($data_pekerja[0]->end_education_date, 6, 2);
                $end_education_date = $year . "-" . $month . "-" . $date;
              }
              //
              if ($data_pekerja[0]->family_birth_date_1) {
                $year = substr($data_pekerja[0]->family_birth_date_1, 0, 4);
                $month = substr($data_pekerja[0]->family_birth_date_1, 4, 2);
                $date = substr($data_pekerja[0]->family_birth_date_1, 6, 2);
                $family_birth_date_1 = $year . "-" . $month . "-" . $date;
              }
              // var_dump($contract_startdate);die();

              // initial check position hrpay
              $curl2->setHeaders([
                'token' => '*4mbur4do3l#'
                // 'token' => $access_token2->data->access_token
              ]);
              // 
              $request_position = [
                'personel_area_code' => $data_pekerja[0]->personal_area,
                'job_code' => $job_code->value1,
                'skill_code' => $data_pekerja[0]->skill_job,
                'area_code' => $data_pekerja[0]->area,
                'level_code' => $data_pekerja[0]->level_job,
                // 'debug' => 1
              ];
              // var_dump($request_position);die();

              $position_check =  $curl2->setPostParams($request_position)->post('https://hrpay.ish.co.id/middleware/position/check');
              $curl2->reset();
              $position_result = json_decode($position_check);
              // var_dump($position_result);die();

              if ($position_result->status == 1) {
                if ($position_result->code == 1) {
                  if ($data_pekerja[0]->gender == 'male') {
                    $gender = 'LAKI-LAKI';
                  } else {
                    $gender = 'PEREMPUAN';
                  }
                  if ($data_pekerja[0]->marital_status == 0) {
                    $marital_status = 'BELUM MENIKAH';
                  } else {
                    $marital_status = 'MENIKAH';
                  }
                  if ($data_pekerja[0]->religion == '01') {
                    $religion = 'ISLAM';
                  } elseif ($data_pekerja[0]->religion == '02') {
                    $religion = 'KRISTEN';
                  } elseif ($data_pekerja[0]->religion == '03') {
                    $religion = 'PROTESTAN';
                  } elseif ($data_pekerja[0]->religion == '04') {
                    $religion = 'HINDU';
                  } elseif ($data_pekerja[0]->religion == '05') {
                    $religion = 'BUDDHA';
                  } elseif ($data_pekerja[0]->religion == '03') {
                    $religion = 'CATHOLIC';
                  } else {
                    $religion = 'NOT FOUND';
                  }
                  if ($data_pekerja[0]->type_contract == '01') {
                    $contract_type = 'PKWT';
                  } elseif ($data_pekerja[0]->type_contract == '03') {
                    $contract_type = 'PARTTIME';
                  } elseif ($data_pekerja[0]->type_contract == '05') {
                    $contract_type = 'MAGANG';
                  } elseif ($data_pekerja[0]->type_contract == '06') {
                    $contract_type = 'KEMITRAAN';
                  } elseif ($data_pekerja[0]->type_contract == '07') {
                    $contract_type = 'THL';
                  } elseif ($data_pekerja[0]->type_contract == '01') {
                    $contract_type = 'PKWT-KEMITRAAN PB';
                  } else {
                    $contract_type = '';
                  }
                  // 
                  if ($data_pekerja[0]->type_jo == '01') {
                    $massg = "NEW";
                  } else {
                    $massg = "REPLACEMENT";
                  }
                  // 
                  if ($data_pekerja[0]->is_certificate_education == '01') {
                    $is_certificate = "1";
                  } else {
                    $is_certificate = "0";
                  }

                  if ($data_pekerja[0]->family_gender_1 == 'MALE') {
                    $gender_family = "laki-laki";
                  } else {
                    $gender_family = "perempuan";
                  }

                  // initial hiring
                  // initial get access token
                  $curl3 = new curl\Curl();
                  // $check_token3 = $curl3->setPostParams([
                  //   'username' => 'gojobs',
                  //   'password' => 'u3p5bL1E3'
                  // ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                  // $access_token3 = json_decode($check_token3);
                  // var_dump($access_token3);die();
                  // if ($access_token3->status == 1) {
                    // initial check position hrpay
                    $curl3->setHeaders([
                      // 'token' => $access_token3->data->access_token
                      'token' => '*4mbur4do3l#'
                    ]);

                    // array data insert hiring
                    $request_hiring = [
                      'action_type' => 'Z1',
                      'jo_type' => $massg,
                      'contract_type' => $contract_type,
                      'contract_startdate' => $contract_startdate,
                      'contract_enddate' => '9999-12-31',
                      'personel_area_code' => $data_pekerja[0]->personal_area,
                      'area_code' => $data_pekerja[0]->area,
                      'payroll_area_code' => $data_pekerja[0]->payroll_area,
                      'job_code' => $job_code ? $job_code->value1 : '-',
                      'skill_code' => $data_pekerja[0]->skill_job,
                      'level_code' => $data_pekerja[0]->level_job,
                      'province_name' => $province,
                      'city_name' => $city ? $city->city_name : '-',
                      'joindate' => $join_date,
                      'nationality' => 'INDONESIA',
                      'sap_perner' => $data_pekerja[0]->perner,
                      'position_id' => $position_result->data->code,
                      'fullname' => $data_pekerja[0]->fullname,
                      'birthplace' => $data_pekerja[0]->birth_place,
                      'birthdate' => $birth_date,
                      'religion' => $religion,
                      'gender' => $gender,
                      'ktp_number' => ($data_pekerja[0]->id_card_number) ? $data_pekerja[0]->id_card_number : '0000000000000000',
                      'kk_number' => ($data_pekerja[0]->id_card_number) ? $data_pekerja[0]->id_card_number : '0000000000000000',
                      // 'kk_number' => ($data_pekerja[0]->kknumber) ? $data_pekerja[0]->kknumber : '0000000000000000',
                      'marital_status' => $marital_status,
                      // 'debug' => 1
                    ];
                    // var_dump($request_hiring);die();
                    $hiring_check = $curl3->setPostParams($request_hiring)->post('https://hrpay.ish.co.id/middleware/hraction/hiring');
                    // var_dump($hiring_check);die();
                    $curl3->reset();
                    $rethiring = json_decode($hiring_check);

                    // echo '<pre>';
                    // var_dump($rethiring->status);
                    // die();
                    // echo '</pre>';

                    if ($rethiring) {
                      // result hiring -> update biodata
                      if ($rethiring->status == 1) {
                        // $curl4 = new curl\Curl();
                        // initial get access token
                        // $check_token4 = $curl4->setPostParams([
                        //   'username' => 'gojobs',
                        //   'password' => 'u3p5bL1E3'
                        // ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                        // $access_token4 = json_decode($check_token4);
                        // if ($access_token4->status == 1) {
                          // 
                          // $curl4->setHeaders([
                            // 'token' => $access_token4->data->access_token
                            // 'token' => '*4mbur4do3l#'
                          // ]);

                          // initial request data to post insert biodata
                          $request_data = [
                            'perner' => $rethiring->data->personal_number,
                            'address' => [
                              [
                                'type' => 'ktp',
                                'contact_name' => 'default',
                                'address' => ($data_pekerja[0]->family_address_1) ? $data_pekerja[0]->family_address_1 : '-',
                                'city' => ($data_pekerja[0]->family_city_1) ? $data_pekerja[0]->family_city_1 : '-',
                                'zipcode' => ($data_pekerja[0]->family_postal_code_1) ? $data_pekerja[0]->family_postal_code_1 : '00000',
                              ],
                              [
                                'type' => 'emergency',
                                'contact_name' => 'default',
                                'address' => ($data_pekerja[0]->family_address_2) ? $data_pekerja[0]->family_address_2 : '-',
                                'city' => ($data_pekerja[0]->family_city_2) ? $data_pekerja[0]->family_city_2 : '-',
                                'zipcode' => ($data_pekerja[0]->family_postal_code_2) ? $data_pekerja[0]->family_postal_code_2 : '000000',
                              ],
                            ],
                            'family' => [
                              [
                                'type' => 'other',
                                'name' => ($data_pekerja[0]->family_name_1) ? $data_pekerja[0]->family_name_1 : 'undifined',
                                'gender' => ($gender_family) ? $gender_family : 'perempuan',
                                'birthdate' => $family_birth_date_1 ? $family_birth_date_1 : '1900-12-31',
                              ]
                            ],
                            'education' => [
                              [
                                'startdate' => $start_education_date ? $start_education_date : '-',
                                'enddate' => $end_education_date ? $end_education_date : '9999-12-31',
                                'level' => ($data_pekerja[0]->education_level) ? $data_pekerja[0]->education_level : '-',
                                'major' => ($data_pekerja[0]->education_major) ? $data_pekerja[0]->education_major : '-',
                                'certificate' => $is_certificate,
                                'finale_grade' => ($data_pekerja[0]->education_mark) ? $data_pekerja[0]->education_mark : '0',
                              ]
                            ],
                            'tax' => [
                              [
                                'npwp_registration_date' => $join_date,
                                'company_tax_id' => '000000000000000',
                                'personal_tax_id' => ($data_pekerja[0]->tax_number) ? $data_pekerja[0]->tax_number : '000000000000000', // validasi max character 15
                              ],
                            ],
                            'jamsostek' => [
                              [
                                'id_number' => ($data_pekerja[0]->jamsostek_number) ? $data_pekerja[0]->jamsostek_number : '00000000000', // validasi max character 11
                                'married' => $marital_status,
                              ]
                            ],
                            'bank' => [
                              [
                                'startdate' => $join_date,
                                'enddate' => '9999-12-31',
                                'bank_key' => $data_pekerja[0]->bank_type, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
                                'bank_type' => 'main', //validasi max character 11
                                'bank_account' => $data_pekerja[0]->bank_number
                              ]
                            ],

                            'email' => [
                              [
                                'email' => 'default@mail.com',
                                'type' => 'main'
                              ]
                            ],
                            'mobile' => [
                              [
                                'mobile' => $data_pekerja[0]->family_phone_number_1 ? $data_pekerja[0]->family_phone_number_1 : '08123456789',
                                'type' => 'main',
                              ]
                            ],
                          ];

                          // initiate hit biodata update/ insert
                          $curl6 = new curl\Curl();
                          // initial get access token
                          // $check_token6 = $curl6->setPostParams([
                          //   'username' => 'gojobs',
                          //   'password' => 'u3p5bL1E3'
                          // ])->post('https://hrpay.ish.co.id/middleware/auth/login');
                          // $access_token6 = json_decode($check_token6);

                          // initiate post biodata update
                          $curl6->setHeaders([
                            // 'token' => $access_token6->data->access_token
                            'token' => '*4mbur4do3l#'
                          ]);
                          $raw_biodata = $curl6->setPostParams($request_data)->post('https://hrpay.ish.co.id/middleware/employee/bio');
                          // var_dump($raw_biodata);
                          // die();
                          $curl6->reset();
                          $ret = json_decode($raw_biodata);
                          // 
                          if ($ret) {
                            if ($ret->status == 1) {
                              $retbio = ['key' => $initiate, 'status' => $ret->status, 'message' => $ret->message, 'perner' => $data_pekerja[0]->perner];
                              print_r(json_encode($retbio));
                            } else {
                              $retbio = ['key' => $initiate, 'status' => $ret->status, 'message' => $ret->message, 'perner' => $data_pekerja[0]->perner];
                              print_r(json_encode($retbio));                              
                            }
                          }
                        // } else {
                        //   $retlogin4 = ['key' => $initiate, 'status' => $access_token4->status, 'message' => $access_token4->message];
                        //   print_r(json_encode($retlogin4));
                        //   echo "<br>";
                        // }
                        // 
                        $rethire = ['key' => $initiate, 'status' => $rethiring->status, 'message' => $rethiring->message, 'position' => $position_result->data->code, 'perner' => $data_pekerja[0]->perner];
                        print_r(json_encode($rethire));
                      } else {
                        $rethire = ['key' => $initiate, 'status' => $rethiring->status, 'message' => $rethiring->message, 'position' => $position_result->data->code, 'perner' => $data_pekerja[0]->perner];
                        print_r(json_encode($rethire));
                      }
                    }
                  // } else {
                  //   $retlogin3 = ['key' => $initiate, 'status' => $access_token3->status, 'message' => $access_token3->message];
                  //   print_r(json_encode($retlogin3));
                  //   echo "<br>";
                  // }
                } else {
                  $retpos = ['key' => $initiate, 'status' => $position_result->status, 'message' => $position_result->message, 'perner' => $data_pekerja[0]->perner];
                  print_r(json_encode($retpos));
                }
              } else {
                $retpos = ['key' => $initiate, 'status' => $position_result->status, 'message' => $position_result->message, 'perner' => $data_pekerja[0]->perner];
                print_r(json_encode($retpos));
              }
            // } else {
            //   $retlogin2 = ['key' => $initiate, 'status' => $access_token2->status, 'message' => $access_token2->message];
            //   print_r(json_encode($retlogin2));
            //   echo "<br>";
            // }
          } else {
            print_r($paycontroll_check->message);
          }
        // } else {
        //   $retlogin1 = [
        //     'key' => $initiate, 'status' => $access_token1->status, 'message' => $access_token1->message
        //   ];
        //   print_r($retlogin1);
        //   echo "<br>";
        // }
      }
    }
  }

  public function actionBiodatabysap($perner = null)
  {

    // 
    // $initiate++; // loss limit
    $curl_worker = new curl\Curl();
    $getdatapekerja =  $curl_worker->setPostParams([
      'perner' => $perner,
      // 'perner' => '228583',
      'token' => 'ish**2019',
    ])
      ->post('http://192.168.88.5/service/index.php/sap_profile/getworker');
    // var_dump($getdatapekerja);die();
    $data_pekerja  = json_decode($getdatapekerja);

    if ($data_pekerja) {
      $curl = new curl\Curl();
      // initial get access token
      $check_token1 = $curl->setPostParams([
        'username' => 'gojobs',
        'password' => 'u3p5bL1E3'
      ])->post('https://hrpay.ish.co.id/middleware/auth/login');
      $access_token1 = json_decode($check_token1);

      if ($access_token1->status == 1) {
        // initital check payroll controll hrpay

        $area = Saparea::find()->where(['value1' => $data_pekerja[0]->area])->one();
        $city = MappingCity::find()->where(['city_name' => $area->value2])->one();
        $job_code = Sapjob::find()->where(['value2' => $data_pekerja[0]->job_name])->one();
        // var_dump($job_code);die();
        // var_dump($city);die();
        if ($city) {
          $res_province = Province::find()->where(['id' => $city->province_id])->one();
          $province = $res_province->name_province;
        } else {
          $province = '-';
        }
        // 
        if ($data_pekerja[0]->start_contract_date) {
          $year = substr($data_pekerja[0]->start_contract_date, 0, 4);
          $month = substr($data_pekerja[0]->start_contract_date, 4, 2);
          $date = substr($data_pekerja[0]->start_contract_date, 6, 2);
          $contract_startdate = $year . "-" . $month . "-" . $date;
        }

        if ($data_pekerja[0]->end_contract_date) {
          $year = substr($data_pekerja[0]->end_contract_date, 0, 4);
          $month = substr($data_pekerja[0]->end_contract_date, 4, 2);
          $date = substr($data_pekerja[0]->end_contract_date, 6, 2);
          $contract_enddate = $year . "-" . $month . "-" . $date;
        }

        if ($data_pekerja[0]->join_date) {
          $year = substr($data_pekerja[0]->join_date, 0, 4);
          $month = substr($data_pekerja[0]->join_date, 4, 2);
          $date = substr($data_pekerja[0]->join_date, 6, 2);
          $join_date = $year . "-" . $month . "-" . $date;
        }
        // 
        if ($data_pekerja[0]->birth_date) {
          $year = substr($data_pekerja[0]->birth_date, 0, 4);
          $month = substr($data_pekerja[0]->birth_date, 4, 2);
          $date = substr($data_pekerja[0]->birth_date, 6, 2);
          $birth_date = $year . "-" . $month . "-" . $date;
        }
        if ($data_pekerja[0]->start_education_date) {
          $year = substr($data_pekerja[0]->start_education_date, 0, 4);
          $month = substr($data_pekerja[0]->start_education_date, 4, 2);
          $date = substr($data_pekerja[0]->start_education_date, 6, 2);
          $start_education_date = $year . "-" . $month . "-" . $date;
        }
        if ($data_pekerja[0]->end_education_date) {
          $year = substr($data_pekerja[0]->end_education_date, 0, 4);
          $month = substr($data_pekerja[0]->end_education_date, 4, 2);
          $date = substr($data_pekerja[0]->end_education_date, 6, 2);
          $end_education_date = $year . "-" . $month . "-" . $date;
        }
        //
        if ($data_pekerja[0]->family_birth_date_1) {
          $year = substr($data_pekerja[0]->family_birth_date_1, 0, 4);
          $month = substr($data_pekerja[0]->family_birth_date_1, 4, 2);
          $date = substr($data_pekerja[0]->family_birth_date_1, 6, 2);
          $family_birth_date_1 = $year . "-" . $month . "-" . $date;
        }
        // var_dump($contract_startdate);die();

        if ($data_pekerja[0]->gender == 'male') {
          $gender = 'LAKI-LAKI';
        } else {
          $gender = 'PEREMPUAN';
        }
        if ($data_pekerja[0]->marital_status == 0) {
          $marital_status = 'BELUM MENIKAH';
        } else {
          $marital_status = 'MENIKAH';
        }
        if ($data_pekerja[0]->religion == '01') {
          $religion = 'ISLAM';
        } elseif ($data_pekerja[0]->religion == '02') {
          $religion = 'KRISTEN';
        } elseif ($data_pekerja[0]->religion == '03') {
          $religion = 'PROTESTAN';
        } elseif ($data_pekerja[0]->religion == '04') {
          $religion = 'HINDU';
        } elseif ($data_pekerja[0]->religion == '05') {
          $religion = 'BUDDHA';
        } elseif ($data_pekerja[0]->religion == '03') {
          $religion = 'CATHOLIC';
        } else {
          $religion = 'NOT FOUND';
        }
        if ($data_pekerja[0]->type_contract == '01') {
          $contract_type = 'PKWT';
        } elseif ($data_pekerja[0]->type_contract == '03') {
          $contract_type = 'PARTTIME';
        } elseif ($data_pekerja[0]->type_contract == '05') {
          $contract_type = 'MAGANG';
        } elseif ($data_pekerja[0]->type_contract == '06') {
          $contract_type = 'KEMITRAAN';
        } elseif ($data_pekerja[0]->type_contract == '07') {
          $contract_type = 'THL';
        } elseif ($data_pekerja[0]->type_contract == '01') {
          $contract_type = 'PKWT-KEMITRAAN PB';
        } else {
          $contract_type = '';
        }
        // 
        if ($data_pekerja[0]->type_jo == '01') {
          $massg = "NEW";
        } else {
          $massg = "REPLACEMENT";
        }
        // 
        if ($data_pekerja[0]->is_certificate_education == '01') {
          $is_certificate = "1";
        } else {
          $is_certificate = "0";
        }

        if ($data_pekerja[0]->family_gender_1 == 'MALE') {
          $gender_family = "laki-laki";
        } else {
          $gender_family = "perempuan";
        }

        $curl4 = new curl\Curl();
        // initial get access token
        $check_token4 = $curl4->setPostParams([
          'username' => 'gojobs',
          'password' => 'u3p5bL1E3'
        ])->post('https://hrpay.ish.co.id/middleware/auth/login');
        $access_token4 = json_decode($check_token4);

        if ($access_token4->status == 1) {
          // 
          $curl4->setHeaders([
            'token' => $access_token4->data->access_token
          ]);

          // initial request data to post insert biodata
          $request_data = [
            'perner' => '228583',
            'address' => [
              [
                'type' => 'ktp',
                'contact_name' => 'default',
                'address' => ($data_pekerja[0]->family_address_1) ? $data_pekerja[0]->family_address_1 : '-',
                'city' => ($data_pekerja[0]->family_city_1) ? $data_pekerja[0]->family_city_1 : '-',
                'zipcode' => ($data_pekerja[0]->family_postal_code_1) ? $data_pekerja[0]->family_postal_code_1 : '00000',
              ],
              [
                'type' => 'emergency',
                'contact_name' => 'default',
                'address' => ($data_pekerja[0]->family_address_2) ? $data_pekerja[0]->family_address_2 : '-',
                'city' => ($data_pekerja[0]->family_city_2) ? $data_pekerja[0]->family_city_2 : '-',
                'zipcode' => ($data_pekerja[0]->family_postal_code_2) ? $data_pekerja[0]->family_postal_code_2 : '000000',
              ],
            ],
            'family' => [
              [
                'type' => 'other',
                'name' => ($data_pekerja[0]->family_name_1) ? $data_pekerja[0]->family_name_1 : 'undifined',
                'gender' => ($gender_family) ? $gender_family : 'perempuan',
                'birthdate' => $family_birth_date_1 ? $family_birth_date_1 : '1900-12-31',
              ]
            ],
            'education' => [
              [
                'startdate' => $start_education_date ? $start_education_date : '-',
                'enddate' => $end_education_date ? $end_education_date : '9999-12-31',
                'level' => ($data_pekerja[0]->education_level) ? $data_pekerja[0]->education_level : '-',
                'major' => ($data_pekerja[0]->education_major) ? $data_pekerja[0]->education_major : '-',
                'certificate' => $is_certificate,
                'finale_grade' => ($data_pekerja[0]->education_mark) ? $data_pekerja[0]->education_mark : '0',
              ]
            ],
            'tax' => [
              [
                'npwp_registration_date' => $join_date,
                'company_tax_id' => '000000000000000',
                'personal_tax_id' => ($data_pekerja[0]->tax_number) ? $data_pekerja[0]->tax_number : '000000000000000', // validasi max character 15
              ],
            ],
            'jamsostek' => [
              [
                'id_number' => ($data_pekerja[0]->jamsostek_number) ? $data_pekerja[0]->jamsostek_number : '00000000000', // validasi max character 11
                'married' => $marital_status,
              ]
            ],
            'bank' => [
              [
                'startdate' => $join_date,
                'enddate' => '9999-12-31',
                'bank_key' => $data_pekerja[0]->bank_type, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
                'bank_type' => 'main', //validasi max character 11
                'bank_account' => $data_pekerja[0]->bank_number
              ]
            ],

            'email' => [
              [
                'email' => 'default@mail.com',
                'type' => 'main'
              ]
            ],
            'mobile' => [
              [
                'mobile' => $data_pekerja[0]->family_phone_number_1 ? $data_pekerja[0]->family_phone_number_1 : '08123456789',
                'type' => 'main',
              ]
            ],
          ];

          // initiate hit biodata update/ insert
          $curl6 = new curl\Curl();
          // initial get access token
          $check_token6 = $curl6->setPostParams([
            'username' => 'gojobs',
            'password' => 'u3p5bL1E3'
          ])->post('https://hrpay.ish.co.id/middleware/auth/login');
          $access_token6 = json_decode($check_token6);
          // echo '<pre>';
          // var_dump($request_data);die();
          // echo '</pre>';

          // initiate post biodata update
          $curl6->setHeaders([
            'token' => $access_token6->data->access_token
          ]);
          $raw_biodata = $curl6->setPostParams($request_data)->post('https://hrpay.ish.co.id/middleware/employee/bio');
          // var_dump($raw_biodata);
          // die();
          $ret = json_decode($raw_biodata);
          // 
          if ($ret) {
            if ($ret->status == 1) {
              $retbio = ['status' => $ret->status, 'message' => $ret->message, 'perner' => $data_pekerja[0]->perner];
              print_r(json_encode($retbio));
            } else {
              $retbio = ['status' => $ret->status, 'message' => $ret->message, 'perner' => $data_pekerja[0]->perner];
              print_r(json_encode($retbio));
            }
          }
        } else {
          $retlogin4 = ['status' => $access_token4->status, 'message' => $access_token4->message];
          print_r(json_encode($retlogin4));
          echo "<br>";
        }
      } else {
        $retlogin1 = [
          'status' => $access_token1->status, 'message' => $access_token1->message
        ];
        print_r($retlogin1);
        echo "<br>";
      }
    }
  }

  // update biodata hiring hrms trigger by id hiring
  public function actionUpdatebiodata($id = null)
  {
    // flag is_hiring_hrms is set by insert hiring first in HRMS
    $raw = Hiring::find()->where(['id' => $id, 'statushiring' => 4, 'is_hiring_hrms' => 1])->orderBy(['id' => SORT_DESC])->one();
    // var_dump($raw);die();
    // 
    if ($raw) {
      $model = $this->findModel($raw->id);
      $trans_rincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();

      // initial check payroll
      $curl = new curl\Curl();
      // initial get access token
      $check_token1 = $curl->setPostParams([
        'username' => 'gojobs',
        'password' => 'u3p5bL1E3'
      ])->post('https://hrpay.ish.co.id/middleware/auth/login');
      $access_token1 = json_decode($check_token1);

      if ($access_token1->status == 1) {
        // initital check payroll controll hrpay
        $curl->setHeaders([
          'token' => $access_token1->data->access_token
        ]);
        // initital check payroll controll hrpay
        $paycontroll_check = $curl->setPostParams([
          'code' => $trans_rincian->abkrs_sap,
        ])->post('https://hrpay.ish.co.id/middleware/parea/check');
        $payrollcontroll_result = json_decode($paycontroll_check);
        // var_dump($payrollcontroll_result);die();
        if ($payrollcontroll_result->status == 1) {
          // initiate get data all biodata from gojobs
          $user = User::find()->where(['id' => $model->userid])->one();
          $user_profile = Userprofile::find()->where(['userid' => $model->userid])->one();
          $user_econtact = Useremergencycontact::find()->where(['userid' => $model->userid])->one();
          $user_family = Userfamily::find()->where(['userid' => $model->userid])->all();
          $user_feduca = Userformaleducation::find()->where(['userid' => $model->userid])->all();
          $user_nonfeduca = Usernonformaleducation::find()->where(['userid' => $model->userid])->all();
          $user_about = Userabout::find()->where(['userid' => $model->userid])->one();
          $birth_date = date_create($user_profile->birthdate);
          $join_date = date_create($model->tglinput);
          $contract_startdate = date_create($model->awalkontrak);
          $contract_enddate = date_create($model->akhirkontrak);
          $wedingdate = date_create($user_profile->weddingdate);
          // 
          if ($user_profile->gender == 'male') {
            $gender = 'laki-laki';
          } else {
            $gender = 'perempuan';
          }

          if ($user_profile->maritalstatus == 'single') {
            $marital_status = '0';
          } else {
            $marital_status = '1';
          }

          $address_data = $this->findAddressdata($model, $user_profile, $user_econtact);
          $family_data = $this->findUserfamily($model, $user_family);
          $user_education = $this->findUsereducation($model, $user_feduca, $user_nonfeduca);

          // initial request data to post insert biodata
          $request_data = [
            [
              'pernr' => $model->perner,
              'address' => $address_data,
              'family' => $family_data,
              'education' => $user_education,
              'tax' => [
                [
                  'npwp_registration_date' => date_format($join_date, 'Y-m-d'),
                  'company_tax_id' => '000000000000000',
                  // 'personal_card_id' => $user_profile->identitynumber,
                  'personal_tax_id' => ($user_profile->npwpnumber) ? $user_profile->npwpnumber : '000000000000000', // validasi max character 15
                ],
              ],
              'jamsostek' => [
                [
                  'id_number' => ($user_profile->jamsosteknumber) ? $user_profile->jamsosteknumber : '00000000000', // validasi max character 11
                  'married' => $marital_status,
                ]
              ],
              'bank' => [
                [
                  'startdate' => date_format($join_date, 'Y-m-d'),
                  'enddate' => '9999-12-31',
                  'jamid' => "00000000000", //validasi max character 11
                  'bank_type' => $user_about->bankname->sapid, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
                  'bank_account' => $user_about->bankaccountnumber
                ]
              ],

              'email' => [
                [
                  'email' => $user->email,
                  'type' => 'main'
                ]
              ],
              'mobile' => [
                [
                  'mobile' => $user->mobile,
                  'type' => 'main',
                ]
              ],
            ]
          ];

          // echo '<pre>';
          // var_dump($request_data);die();
          // echo '</pre>';

          // initiate hit biodata update/ insert
          $curl2 = new curl\Curl();
          // initial get access token
          $check_token2 = $curl2->setPostParams([
            'username' => 'gojobs',
            'password' => 'u3p5bL1E3'
          ])->post('https://hrpay.ish.co.id/middleware/auth/login');
          $access_token2 = json_decode($check_token2);

          // initiate post biodata update
          $biodata_array = json_encode($request_data);
          // 
          $curl2->setHeaders([
            'Content-Type: application/json',
            'cache-control: no-cache"=',
            'token' => $access_token2->data->access_token
          ]);
          $raw_biodata = $curl2->setPostParams($biodata_array)->post('https://hrpay.ish.co.id/middleware/employee/bio');
          $ret = json_decode($raw_biodata);
          // var_dump($ret);die();

          if ($ret->status == 1) {
            $model->flaginfotype022 = 1;
            $model->save();
          } else {
            $model->flaginfotype021 = 1;
            $model->save();
          }

          // 
          print_r(json_encode($ret));
        } else {
          $retlock = ['status' => "NOK", 'message' => 'lock', 'pernr' => null];
          print_r(json_encode($retlock));
        }
      } else {
        $retlogin1 = ['status' => $access_token1->status, 'message' => $access_token1->message];
        print_r(json_encode($retlogin1));
      }
    } else {
      $retlock = ['status' => "NOK", 'message' => 'Cant Update, Perner is not been Hired on HRMS', 'pernr' => null];
      print_r(json_encode($retlock));
    }
  }

  // bulk update biodata hiring hrms by personal area
  public function actionUpdatebiodatabypa($id)
  {
    $model = $this->findModel($id);
    $trans_rincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $user_profile = Userprofile::find()->where(['userid' => $model->userid])->one();
    $user_econtact = Useremergencycontact::find()->where(['userid' => $model->userid])->one();
    $user_family = Userfamily::find()->where(['userid' => $model->userid])->all();
    $user_feduca = Userformaleducation::find()->where(['userid' => $model->userid])->all();
    $user_nonfeduca = Usernonformaleducation::find()->where(['userid' => $model->userid])->all();
    $user_about = Userabout::find()->where(['userid' => $model->userid])->one();

    // initial check payroll
    $curl = new curl\Curl();
    // initial get access token
    $check_token1 = $curl->setPostParams([
      'username' => 'gojobs',
      'password' => 'u3p5bL1E3'
    ])->post('https://hrpay.ish.co.id/middleware/auth/login');
    $access_token1 = json_decode($check_token1);

    if ($access_token1->status == 1) {
      // initital check payroll controll hrpay
      $curl->setHeaders([
        'token' => $access_token1->data->access_token
      ]);
    } else {

      // initital check payroll controll hrpay
      $curl->setHeaders([
        'token' => $access_token1->data->access_token
      ]);
      $paycontroll_check = $curl->setPostParams([
        'code' => $trans_rincian->abkrs_sap,
      ])->post('https://hrpay.ish.co.id/middleware/parea/check');
      $payrollcontroll_result = json_decode($paycontroll_check);
      if ($payrollcontroll_result->status == 1) {
        $birth_date = date_create($user_profile->birthdate);
        $join_date = date_create($model->tglinput);
        $contract_startdate = date_create($model->awalkontrak);
        $contract_enddate = date_create($model->akhirkontrak);
        $wedingdate = date_create($user_profile->weddingdate);
        // initiate hit biodata update/ insert
        $url = "https://hrpay.ish.co.id/middleware/employee/bio";
        //p0002 = untuk applicant yang sudah menikah (input tanggal pernikahan)
        if ($user_profile->gender == 'male') {
          $gender = '1';
          if ($user_profile->maritalstatus == 'married') {
            $spben = 'X';
          } else {
            $spben = '';
          }
        } else {
          $gender = '2';
          if ($user_profile->maritalstatus == 'married') {
            $spben = 'X';
          } else {
            $spben = '';
          }
        }
        if ($user_profile->religion == 'islam') {
          $religion = '01';
        } elseif ($user_profile->religion == 'christian') {
          $religion = '02';
        } elseif ($user_profile->religion == 'protestant') {
          $religion = '02';
        } elseif ($user_profile->religion == 'hindu') {
          $religion = '04';
        } elseif ($user_profile->religion == 'buddha') {
          $religion = '05';
        } elseif ($user_profile->religion == 'catholic') {
          $religion = '03';
        } else {
          $religion = '07';
        }
        if ($model->flaginfotype022 == 1 and $model->flaginfotype021 == 1) {
          if ($user_profile->maritalstatus == 'single') {
            $marital_status = '0';
            $marrd = '';
            $marst = '';
            $infotype = ['0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          } else {
            $marital_status = '1';
            $marrd = 'X';
            $marst = 'X';
            $infotype = ['0002', '0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          }
        } else if ($model->flaginfotype022 == 1) {
          if ($user_profile->maritalstatus == 'single') {
            $marital_status = '0';
            $marrd = '';
            $marst = '';
            $infotype = ['0041', '0006', '0021', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          } else {
            $marital_status = '1';
            $marrd = 'X';
            $marst = 'X';
            $infotype = ['0002', '0041', '0006', '0021', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          }
        } else if ($model->flaginfotype021 == 1) {
          if ($user_profile->maritalstatus == 'single') {
            $marital_status = '0';
            $marrd = '';
            $marst = '';
            $infotype = ['0041', '0006', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          } else {
            $marital_status = '1';
            $marrd = 'X';
            $marst = 'X';
            $infotype = ['0002', '0041', '0006', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          }
        } else {
          if ($user_profile->maritalstatus == 'single') {
            $marital_status = '0';
            $marrd = '';
            $marst = '';
            $infotype = ['0041', '0006', '0021', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          } else {
            $marital_status = '1';
            $marrd = 'X';
            $marst = 'X';
            $infotype = ['0002', '0041', '0006', '0021', '0022', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];
          }
        }

        if ($trans_rincian->kontrak == 'PKWT') {
          $contract_type = 'PKWT';
        } elseif ($trans_rincian->kontrak == 'PARTTIME' or $trans_rincian->kontrak == 'Part Time') {
          $contract_type = 'PARTTIME';
        } elseif ($trans_rincian->kontrak == 'MAGANG') {
          $contract_type = 'MAGANG';
        } elseif ($trans_rincian->kontrak == 'KEMITRAAN') {
          $contract_type = 'KEMITRAAN';
        } elseif ($trans_rincian->kontrak == 'THL') {
          $contract_type = 'THL';
        } elseif ($trans_rincian->kontrak == 'PKWT-KEMITRAAN PB') {
          $contract_type = 'PKWT-KEMITRAAN PB';
        }

        $address_data = $this->findAddressdata($model, $user_profile, $user_econtact);
        $family_data = $this->findUserfamily($model, $user_family);
        $userfamilyJtdata = $this->findUserfamilyJt($model, $user_family);
        $user_education = $this->findUsereducation($model, $user_feduca, $user_nonfeduca);

        // var_dump($user_education);die;
        $request_data = [
          [
            'pernr' => "$model->perner",
            'inftypList' => $infotype,
            'p00002List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'mod',
                'pernr' => "$model->perner",
                'infty' => '0002',
                'nachn' => $user_profile->fullname,
                'cname' => $user_profile->fullname,
                'knznm' => '',
                'anred' => $gender,
                'gesch' => $gender,
                'gbdat' => date_format($birth_date, 'Y-m-d'),
                'gblnd' => 'ID',
                'gbort' => $user_profile->birthplace,
                'natio' => 'ID',
                'sprsl' => 'ID',
                'konfe' => $religion,
                'famst' => $marital_status,
                'famdt' => date_format($wedingdate, 'Y-m-d'),
                'anzkd' => '',
                'gbpas' => date_format($birth_date, 'Y-m-d'),
                'gbjhr' => date_format($birth_date, 'y'),
                'gbmon' => date_format($birth_date, 'm'),
                'gbtag' => date_format($birth_date, 'd'),
                'nchmc' => $user_profile->fullname
              ]
            ],
            'p00041List' => [
              [
                'endda' => '',
                'begda' => '',
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0041',
                'dar01' => '01',
                'dat01' => date_format($contract_startdate, 'Y-m-d'),
                'dar02' => '',
                'dat02' => ''
              ]
            ],

            // infty 1 = alamat ktp, 2 = alamat tinggal, 4 =  alamat emergencycontact, 5 = alamat anggota keluarga
            'p00006List' => $address_data,
            // subty relationship, 1 = pasangan (suami/istri), 2 = anak, 11 = ayah, 12 = ibu, 91 = saudara kandung
            'p00021List' => $family_data,

            //infotype 318 tidak usah
            'p00318List' => $userfamilyJtdata,
            // formal dan non formal menggunakan infotype yang sama yaitu 0022
            'p00022List' => $user_education,
            'p00028List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0028',
                'subty' => 'Z001',
                'exdat' => date_format($join_date, 'Y-m-d'),
                'resul' => '01',
                'dianr' => '',
                'sbj01' => '01',
                'jnf01' => '',
                'nmf01' => '',
                'dtf01' => '',
                'wtf01' => $user_profile->bloodtype,
                'sbj02' => '',
                'jnf02' => '',
                'nmf02' => '',
                'dtf02' => '',
                'wtf02' => '',
                'sbj03' => '',
                'jnf03' => '',
                'nmf03' => '',
                'dtf03' => '',
                'wtf03' => '',
                'sbj04' => '',
                'jnf04' => '',
                'nmf04' => '',
                'dtf04' => '',
                'wtf04' => '',
                'sbj05' => '',
                'jnf05' => '',
                'nmf05' => '',
                'dtf05' => '',
                'wtf05' => '',
                'sbj06' => '',
                'jnf06' => '',
                'nmf06' => '',
                'dtf06' => '',
                'wtf06' => '',
                'sbj07' => '',
                'jnf07' => '',
                'nmf07' => '',
                'dtf07' => '',
                'wtf07' => '',
                'sbj08' => '',
                'jnf08' => '',
                'nmf08' => '',
                'dtf08' => '',
                'wtf08' => '',
                'sbj09' => '',
                'jnf09' => '',
                'nmf09' => '',
                'dtf09' => '',
                'wtf09' => ''
              ]
            ],
            //01  no ktp, 02  sim a, 03  sim b, 04  sim c, 05  nik, 06  agent id, 07  passport, 08  virtual bpjs, 09  kartu keluarga, 80  application id
            'p00185List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0185',
                'subty' => '01',
                'ictyp' => '01', // haru sama dengan subty
                'icnum' => $user_profile->identitynumber,
                'fpdat' => '',
                'expid' => '',
                'isspl' => '',
                'iscot' => 'ID'
              ],
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0185',
                'subty' => '09',
                'ictyp' => '09', // haru sama dengan subty
                'icnum' => $user_profile->kknumber,
                'fpdat' => '',
                'expid' => '',
                'isspl' => '',
                'iscot' => 'id'
              ]
            ],
            'p00241List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0241',
                'taxid' => $user_profile->npwpnumber, //validasi max character 15
                'marrd' => $marrd,
                'spben' => $spben,
                'depnd' => 'f',
                'rdate' => ''
              ]
            ],
            'p00242List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0242',
                // 'jamid'=> $user_profile->jamsosteknumber, //validasi max character 11
                'jamid' => "00000000000", //validasi max character 11
                'marst' => $marst
              ]
            ],

            'p00009List' => [
              [
                'endda' => '9999-12-31',
                // 'begda'=> "17.02.2019",
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0009',
                'subty' => '0',
                'bnksa' => '0',
                'waers' => 'IDR',
                'zlsch' => 'T',
                'banks' => 'ID',
                'bankl' => $user_about->bankname->sapid, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
                'bankn' => $user_about->bankaccountnumber
              ]
            ],
            'p00008List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0008',
                'trfar' => $trans_rincian->level_sap,
                'trfgb' => 'Z1',
                'trfgr' => $trans_rincian->level_sap,
                'trfst' => '01',
                'waers' => 'IDR'
              ]
            ],
            'p00016List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0016',
                'lfzfr' => '',
                'lfzzh' => '',
                'lfzso' => '',
                'kgzfr' => '',
                'kgzzh' => '',
                'prbzt' => '',
                'prbeh' => '',
                'kdgfr' => '',
                'kdgf2' => '',
                'arber' => date_format($contract_enddate, 'Y-m-d'),
                'konsl' => '59',
                'cttyp' => $contract_type,
                'zwrkpl' => ''
              ]
            ],
            'p00035List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0035',
                'subty' => 'Z1',
                'itxex' => 'X',
                'dat35' => date_format($contract_startdate, 'Y-m-d'),
              ]
            ],
            'p00037List' => [
              [
                'endda' => '9999-12-31',
                'begda' => date_format($join_date, 'Y-m-d'),
                'operation' => 'INS',
                'pernr' => "$model->perner",
                'infty' => '0037',
                'subty' => "0016",
                'vsart' => "0016",
                'vsges' => "11",
                // 'vsnum'=> $user_profile->bpjsnumber, //validasi max character 11
                'vsnum' => "00000000000", //validasi max character 11
                'waers' => "IDR"
              ]
            ],

          ]
        ];

        //var_dump($request_data);

        $json = json_encode($request_data);

        $headers  = [
          'Content-Type: application/json',
          'cache-control: no-cache"=',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //
        $response = curl_exec($ch);

        curl_close($ch);
        $ret = json_decode($response);
        if ($model->flaginfotype022 != 1) {
          if (stripos(json_encode($ret), 'Success when operation infty. 0022') !== false) {
            $model->flaginfotype022 = 1;
            $model->save();
          }
        }
        if ($model->flaginfotype021 != 1) {
          if (stripos(json_encode($ret), 'Success when operation infty. 0021') !== false) {
            $model->flaginfotype021 = 1;
            $model->save();
          }
        }
        // var_dump($ret);die;
        // var_dump($ret[8]->success);die;
        $log = array();
        foreach ($ret as $key => $value) {
          if ($value->success != 1) {
            $log  = $value->message;
          }
        }

        if ($log) {
          $model->statusbiodata = 3;
          $model->message = $log;
          $model->save();
        } else {
          $joindatetglinput = date_format($join_date, 'Ymd');
          $insppjp = Yii::$app->utils->insppjp($model->perner, $joindatetglinput);

          if ($insppjp == "S") {
            // var_dump($insppjp);die;
            $model->statusbiodata = 4;
            $model->message = 'successful';
            // notification email if jo completed (start)
            $modelcountjohiring = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->count();
            $modellisthiring = Hiring::find()->where('recruitreqid = ' . $model->recruitreqid . ' AND statushiring <> 5 AND statushiring <> 6 AND statushiring <> 7')->all();
            $trans_rincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
            $personalarea = (Yii::$app->utils->getpersonalarea($trans_rincian->persa_sap)) ? Yii::$app->utils->getpersonalarea($trans_rincian->persa_sap) : "";
            $area =  (Yii::$app->utils->getarea($trans_rincian->area_sap)) ? Yii::$app->utils->getarea($trans_rincian->area_sap) : "";
            $skilllayanan = (Yii::$app->utils->getskilllayanan($trans_rincian->skill_sap)) ? Yii::$app->utils->getskilllayanan($trans_rincian->skill_sap) : "";
            $payrollarea = (Yii::$app->utils->getpayrollarea($trans_rincian->abkrs_sap)) ? Yii::$app->utils->getpayrollarea($trans_rincian->abkrs_sap) : "";
            $jabatan = (Yii::$app->utils->getjabatan($trans_rincian->hire_jabatan_sap)) ? Yii::$app->utils->getjabatan($trans_rincian->hire_jabatan_sap) : "";
            $curl = new curl\Curl();
            $getlevels = $curl->setPostParams([
              'level' => $trans_rincian->level_sap,
              'token' => 'ish**2019',
            ])->post('http://192.168.88.5/service/index.php/sap_profile/getlevel');
            $level  = json_decode($getlevels);
            $leveljabatan = ($level) ? $level : "";
            if ($modelcountjohiring == $trans_rincian->jumlah) {
              foreach ($modellisthiring as $key => $value) {
                $no = $key + 1;
                $listperner[] =  $no . '. ' . $value->perner;
              }

              $listpernerconv = implode('<br>', $listperner);
              // var_dump($listpernerconv);die;
              $to = 'proman@ish.co.id';
              $subject = 'Job Order Information - Done';
              $body = Yii::$app->params['notificationJoDone'];
              $body = str_replace('{nojo}', $trans_rincian->nojo, $body);
              $body = str_replace('{personal_area}', $personalarea, $body);
              $body = str_replace('{area}', $area, $body);
              $body = str_replace('{skill_layanan}', $skilllayanan, $body);
              $body = str_replace('{payroll_area}', $payrollarea, $body);
              $body = str_replace('{jabatan}', $jabatan, $body);
              $body = str_replace('{level}', $leveljabatan, $body);
              $body = str_replace('{list_worker}', $listpernerconv, $body);

              $sendemail = Yii::$app->utils->sendmail($to, $subject, $body, 12);
            }
          } else {
            $model->statusbiodata = 3;
            $model->message = 'ppjp error';
          }
          $model->save();
          // notification email if jo completed (end)
        }
        print_r(json_encode($ret));
      } else {
        $retlock = ['status' => "NOK", 'message' => 'lock', 'pernr' => null];
        print_r(json_encode($retlock));
      }
    }
  }

  public function actionUpdatebiodatacontractdate($id)
  {
    $model = $this->findModel($id);
    $trans_rincian = Transrincian::find()->where(['id' => $model->recruitreqid])->one();
    $user_profile = Userprofile::find()->where(['userid' => $model->userid])->one();
    $user_econtact = Useremergencycontact::find()->where(['userid' => $model->userid])->one();
    $user_family = Userfamily::find()->where(['userid' => $model->userid])->all();
    $user_feduca = Userformaleducation::find()->where(['userid' => $model->userid])->all();
    $user_nonfeduca = Usernonformaleducation::find()->where(['userid' => $model->userid])->all();
    $user_about = Userabout::find()->where(['userid' => $model->userid])->one();

    $birth_date = date_create($user_profile->birthdate);
    $join_date = date_create($model->tglinput);
    $contract_startdate = date_create($model->awalkontrak);
    $contract_enddate = date_create($model->akhirkontrak);
    $wedingdate = date_create($user_profile->weddingdate);
    $url = "https://hrpay.ish.co.id/middleware/employee/bio";
    //p0002 = untuk applicant yang sudah menikah (input tanggal pernikahan)


    if ($trans_rincian->kontrak == 'PKWT') {
      $cttyp = '02';
    } elseif ($trans_rincian->kontrak == 'PARTTIME' or $trans_rincian->kontrak == 'Part Time') {
      $cttyp = '09';
    } elseif ($trans_rincian->kontrak == 'MAGANG') {
      $cttyp = '10';
    } elseif ($trans_rincian->kontrak == 'KEMITRAAN') {
      $cttyp = '08';
    } elseif ($trans_rincian->kontrak == 'THL') {
      $cttyp = '07';
    } elseif ($trans_rincian->kontrak == 'PKWT-KEMITRAAN PB') {
      $cttyp = '11';
    }


    $infotype = ['0041', '0006', '0028', '0185', '0241', '0242', '0009', '0008', '0016', '0035', '0037'];

    // var_dump($user_education);die;
    $request_data = [
      [
        'pernr' => "$model->perner",
        'inftypList' => $infotype,
        'p00016List' => [
          [
            'endda' => '9999-12-31',
            'begda' => date_format($join_date, 'Y-m-d'),
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0016',
            'lfzfr' => '',
            'lfzzh' => '',
            'lfzso' => '',
            'kgzfr' => '',
            'kgzzh' => '',
            'prbzt' => '',
            'prbeh' => '',
            'kdgfr' => '',
            'kdgf2' => '',
            'arber' => date_format($contract_enddate, 'Y-m-d'),
            'konsl' => '59',
            'cttyp' => $cttyp,
            'zwrkpl' => ''
          ]
        ],
        'p00035List' => [
          [
            'endda' => '9999-12-31',
            'begda' => date_format($join_date, 'Y-m-d'),
            'operation' => 'INS',
            'pernr' => "$model->perner",
            'infty' => '0035',
            'subty' => 'Z1',
            'itxex' => 'X',
            'dat35' => date_format($contract_startdate, 'Y-m-d'),
          ]
        ],

      ]
    ];

    //var_dump($request_data);

    $json = json_encode($request_data);



    $headers  = [
      'Content-Type: application/json',
      'cache-control: no-cache"=',
    ];


    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    //


    $response = curl_exec($ch);

    curl_close($ch);
    $ret = json_decode($response);
    if ($model->flaginfotype022 != 1) {
      if (stripos(json_encode($ret), 'Success when operation infty. 0022') !== false) {
        $model->flaginfotype022 = 1;
        $model->save();
      }
    }
    if ($model->flaginfotype021 != 1) {
      if (stripos(json_encode($ret), 'Success when operation infty. 0021') !== false) {
        $model->flaginfotype021 = 1;
        $model->save();
      }
    }
    // var_dump($ret);die;
    // var_dump($ret[8]->success);die;
    $log = array();
    foreach ($ret as $key => $value) {
      if ($value->success != 1) {
        $log  = $value->message;
      }
    }
    if ($log) {
      $model->statusbiodata = 3;
      $model->message = $log;
      $model->save();
    } else {
      $model->statusbiodata = 4;
      $model->message = 'successful';
      $model->save();
    }
  }

  protected function findAddressdata($model, $user_profile, $user_econtact)
  {
    $addresscount = strlen($user_profile->address);
    // 
    if ($addresscount > 60) {
      $address = substr($user_profile->address, 0, 60);
      $addressl2 = substr($user_profile->address, 60);
    } else {
      $address = $user_profile->address;
      $addressl2 = '';
    };
    $addressktpcount = strlen($user_profile->addressktp);
    if ($addressktpcount > 60) {
      $addressktp = substr($user_profile->addressktp, 0, 60);
      $addressktpl2 = substr($user_profile->addressktp, 60);
    } else {
      $addressktp = $user_profile->addressktp;
      $addressktpl2 = '';
    };
    // var_dump($addressktp);die();
    $addressapplicant = [
      // ktp address
      [
        // 'pernr' => "$model->perner",
        'type' => 'ktp',
        'contact_name' => 'default',
        'address' => ($addressktp) ? $addressktp : $addressktpl2, // address ktp
        'city' => $user_profile->cityktp->kota, //kota ditambahkan pada modul userprofile
        'zipcode' => $user_profile->postalcodektp, //kodepos pada modul userprofile ditambahkan
      ],

      // domisili Address
      [
        'type' => 'domicile',
        'contact_name' => 'default',
        'address' => ($address) ? $address : $addressl2, // address ktp
        'city' => $user_profile->city->kota, //kota ditambahkan pada modul userprofile
        'zipcode' => $user_profile->postalcode, //kodepos pada modul userprofile ditambahkan
      ],
    ];

    $addressuccount = strlen($user_econtact->address);
    if ($addressuccount > 60) {
      $addressuc = substr($user_econtact->address, 0, 60);
      $addressucl2 = substr($user_econtact->address, 60);
    } else {
      $addressuc = $user_econtact->address;
      $addressucl2 = '';
    };
    $useremergencycontact[] = [
      // emergency contact
      'type' => 'emergency',
      'contact_name' => 'default',
      'address' => ($addressuc) ? $addressuc : $addressucl2, //max 60 character, apabila tidak cukup pindahkan ke field locat
      'city' => $user_econtact->city->kota, //kota ditambahkan pada modul userprofile
      'zipcode' => $user_econtact->postalcode, //kodepos pada modul userprofile ditambahkan
    ];

    $address_data = array_merge($addressapplicant, $useremergencycontact);

    return $address_data;
  }

  protected function findUserfamily($model, $user_family)
  {
    foreach ($user_family as $key => $userfamily) {
      // 
      if ($userfamily->relationship == "husband" or $userfamily->relationship == "wife") {
        $type = "other";
      } elseif ($userfamily->relationship == "child") {
        $type = "other";
      } elseif ($userfamily->relationship == "father") {
        $type = "other";
      } elseif ($userfamily->relationship == "mother") {
        $type = "other";
      } else {
        $type = "siblings";
      }
      // 
      if ($userfamily->gender == 'male') {
        $gender = 'laki-laki';
      } else {
        $gender = 'perempuan';
      }
      $birth_date = date_create($userfamily->birthdate);
      $family_data[] =
        [
          'type' => $type, //di isi tergantung data relationship
          'name' => $userfamily->fullname,
          'gender' => $gender,
          'birthdate' => date_format($birth_date, 'Y-m-d'),
        ];
    }
    return $family_data;
  }

  protected function findUsereducation($model, $user_feduca, $user_nonfeduca)
  {
    foreach ($user_feduca as $key => $raw_education) {
      $enddate = date_create($raw_education->enddate);
      if ($raw_education->status == "finished") {
        $is_certificate = "1";
      } else {
        $is_certificate = "0";
      }
      // 
      if ($raw_education->educationallevel == "1") {
        $education_level = "SD";
      } elseif ($raw_education->educationallevel == "2") {
        $education_level = "SMP";
      } elseif ($raw_education->educationallevel == "3") {
        $education_level = "SMA";
      } elseif ($raw_education->educationallevel == "4") {
        $education_level = "D1";
      } elseif ($raw_education->educationallevel == "5") {
        $education_level = "S1";
      } elseif ($raw_education->educationallevel == "6") {
        $education_level = "s2";
      } else {
        $education_level = "s3";
      }
      $raw_education_data[] =
        [
          'startdate' => date_format($enddate, 'Y-m-d'),
          'enddate' => '9999-12-31',
          'level' => $education_level, //untuk yang non fomal tidak perlu di isi
          'major' => $raw_education->majoring ? $raw_education->majoring : 'none', //untuk yang non fomal tidak perlu di isi
          'certificate' => $is_certificate, // menggunakan sertifikat atau tidak, apabila ada kode = 00, tidak ada = 01
          'finale_grade' => $raw_education->gpa ? $raw_education->gpa : '0',
        ];
    }
    // 
    $user_education = $raw_education_data;
    return $user_education;
  }


  /**
   * Finds the Hiring model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Hiring the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Hiring::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }
}
