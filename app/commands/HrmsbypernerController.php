<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use Codeception\Lib\Di;
use yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\Connection;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class HrmsbypernerController extends Controller
{
  public $_token85 = 'ish**2019';
  public $_token = '*4mbur4do3l#';
  /**
   * This command echoes what you have entered as the message.
   * @param string $message the message to be echoed.
   * @return int Exit code
   */
  public function actionIndex($perner = null, $start = 1, $limit = 10)
  {
    /** Error reporting */
    error_reporting(E_ALL);
    ini_set('memory_limit', '1028M');
    ini_set('max_execution_time', 300);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Asia/Jakarta');

    //try {


    // open connection db
    $db = new Connection(Yii::$app->db);
    $db->open();

    // open connection dbJo
    $dbJo = new Connection(Yii::$app->dbjo);
    $dbJo->open();


    //Get Data Pekerja by Perner
    $url = 'http://192.168.88.5/service/index.php/sap_profile/getdatapekerja';
    $attrs = [
      'perner' => $perner,
      'token' => $this->_token85,
    ];

    $data = $this->baseCurl($url, 'post', $attrs);
    if ($data) {

      // var_dump($data);die();

      $i = 0;
      foreach ($data as $d) {
        $i++;

        //if($i <= $limit){
        if ($i >= $start && $i <= $limit) {

          //Check employee exist
          $url = 'https://hrpay.ish.co.id/middleware/hraction/check';
          $attrs =  [
            'perner' => $d->id,
          ];
          $checkEmployee = $this->baseCurl($url, 'post', $attrs, ['token: ' . $this->_token]);
          if ($checkEmployee) {
            if ($checkEmployee->status) {
              if (!$checkEmployee->code) {

                //Get worker
                $url = 'http://192.168.88.5/service/index.php/sap_profile/getworker';
                $attrs = [
                  'perner' => $d->id,
                  // 'perner' => '205210',
                  'token' => $this->_token85,
                  'name' => $d->CNAME,
                ];
                $worker = $this->baseCurl($url, 'post', $attrs);
                // var_dump($worker);die();
                if ($worker) {

                  //Check payroll area
                  $url = 'https://hrpay.ish.co.id/middleware/parea/check';
                  $attrs = [
                    'code' => $worker[0]->payroll_area,
                  ];
                  $checkPa = $this->baseCurl($url, 'post', $attrs, ['token: ' . $this->_token]);
                  if ($checkPa) {
                    if ($checkPa->status) {

                      $jobCode = '-';
                      $city = '-';
                      $province = null;
                      $contractStartdate = null;
                      $contractEnddate = null;
                      $joinDate = null;
                      $birthDate = null;
                      $startEducationDate = null;
                      $endEducationDate = null;
                      $familyBirthDate1 = null;

                      //Get sap area
                      $sql = 'SELECT * FROM `saparea` WHERE `value1` = "' . $worker[0]->area . '"';
                      $area = $dbJo->createCommand($sql)->queryOne();
                      if ($area) {

                        //Get mapping_city
                        $sql = 'SELECT * FROM `mapping_city` WHERE `city_id` = "' . $area['value1'] . '"';
                        $getCity = $dbJo->createCommand($sql)->queryOne();
                        if ($getCity) {

                          $city = $getCity['city_name'];

                          //Get sapjob
                          $sql = 'SELECT * FROM `sapjob` WHERE `value2` = "' . $worker[0]->job_name . '"';
                          $getSapJob = $dbJo->createCommand($sql)->queryOne();
                          if ($getSapJob) $jobCode = $getSapJob['value1'];

                          //Get province
                          $sql = 'SELECT * FROM `province` WHERE `id` = ' . $getCity['province_id'];
                          $getProvince = $dbJo->createCommand($sql)->queryOne();
                          if ($getProvince) $province = $getProvince['name_province'];

                          if ($worker[0]->start_contract_date) {
                            $year = substr($worker[0]->start_contract_date, 0, 4);
                            $month = substr($worker[0]->start_contract_date, 4, 2);
                            $date = substr($worker[0]->start_contract_date, 6, 2);
                            $contractStartdate = $year . "-" . $month . "-" . $date;
                          }

                          if ($worker[0]->end_contract_date) {
                            $year = substr($worker[0]->end_contract_date, 0, 4);
                            $month = substr($worker[0]->end_contract_date, 4, 2);
                            $date = substr($worker[0]->end_contract_date, 6, 2);
                            $contractEnddate = $year . "-" . $month . "-" . $date;
                          }

                          if ($worker[0]->join_date) {
                            $year = substr($worker[0]->join_date, 0, 4);
                            $month = substr($worker[0]->join_date, 4, 2);
                            $date = substr($worker[0]->join_date, 6, 2);
                            $joinDate = $year . "-" . $month . "-" . $date;
                          }
                          // 
                          if ($worker[0]->birth_date) {
                            $year = substr($worker[0]->birth_date, 0, 4);
                            $month = substr($worker[0]->birth_date, 4, 2);
                            $date = substr($worker[0]->birth_date, 6, 2);
                            $birthDate = $year . "-" . $month . "-" . $date;
                          }
                          if ($worker[0]->start_education_date) {
                            $year = substr($worker[0]->start_education_date, 0, 4);
                            $month = substr($worker[0]->start_education_date, 4, 2);
                            $date = substr($worker[0]->start_education_date, 6, 2);
                            $startEducationDate = $year . "-" . $month . "-" . $date;
                          }
                          if ($worker[0]->end_education_date) {
                            $year = substr($worker[0]->end_education_date, 0, 4);
                            $month = substr($worker[0]->end_education_date, 4, 2);
                            $date = substr($worker[0]->end_education_date, 6, 2);
                            $endEducationDate = $year . "-" . $month . "-" . $date;
                          }
                          //
                          if ($worker[0]->family_birth_date_1) {
                            $year = substr($worker[0]->family_birth_date_1, 0, 4);
                            $month = substr($worker[0]->family_birth_date_1, 4, 2);
                            $date = substr($worker[0]->family_birth_date_1, 6, 2);
                            $familyBirthDate1 = $year . "-" . $month . "-" . $date;
                          }
                        }
                      }

                      $gender = 'LAKI-LAKI';
                      if ($worker[0]->gender == 'female') $gendder = 'PEREMPUAN';

                      $maritalStatus = 'BELUM MENIKAH';
                      if ($worker[0]->marital_status == 0) $maritalStatus = 'MENIKAH';

                      if ($worker[0]->religion) {
                        switch ($worker[0]->religion) {
                          case '01':
                          case '06':
                            $religion = 'ISLAM';
                            break;
                          case '02':
                            $religion = 'KRISTEN';
                            break;
                          case '03':
                            //$religion = 'PROTESTAN';
                            $religion = 'KATOLIK';
                            break;
                          case '04':
                            $religion = 'HINDU';
                            break;
                          case '05':
                            $religion = 'BUDHA';
                            break;
                          default:
                            $religion = 'NOT FOUND';
                        }
                      }

                      if ($worker[0]->type_contract) {
                        switch ($worker[0]->type_contract) {
                          case '01':
                            $contractType = 'PKWT';
                            //$contractType = 'PKWT-KEMITRAAN PB';
                            break;
                          case '03':
                            $contractType = 'PARTTIME';
                            break;
                          case '05':
                            $contractType = 'MAGANG';
                            break;
                          case '06':
                            $contractType = 'KEMITRAAN';
                            break;
                          case '07':
                            $contractType = 'THL';
                            break;
                          case '12':
                            $contractType = 'PKWT ke THL';
                            break;
                          default:
                            $contractType = '';
                        }
                      }


                      $massg = 'REPLACEMENT';
                      if ($worker[0]->type_jo == '01') $massg = 'NEW';

                      $isCertificate = '0';
                      if ($worker[0]->is_certificate_education == '01') $isCertificate = '1';

                      $genderFamily = 'perempuan';
                      if ($worker[0]->family_gender_1 == 'MALE') $genderFamily = 'laki-laki';



                      //Check position
                      $url = 'https://hrpay.ish.co.id/middleware/position/check';
                      $attrs = [
                        'personel_area_code' => $worker[0]->personal_area,
                        'job_code' => $jobCode,
                        'skill_code' => $worker[0]->skill_job,
                        'area_code' => $worker[0]->area,
                        'level_code' => $worker[0]->level_job,
                      ];
                      // var_dump($attrs);die();
                      $checkPosition = $this->baseCurl($url, 'post', $attrs, ['token: ' . $this->_token]);
                      if ($checkPosition) {

                        if ($checkPosition->code) {
                          if ($checkPosition->status) {


                            //Insert hiring
                            $url = 'https://hrpay.ish.co.id/middleware/hraction/hiring';
                            $attrs = [
                              'action_type' => 'Z1',
                              'jo_type' => $massg,
                              'contract_type' => $contractType,
                              'contract_startdate' => $contractStartdate,
                              'contract_enddate' => '9999-12-31',
                              'personel_area_code' => $worker[0]->personal_area,
                              'area_code' => $worker[0]->area,
                              'payroll_area_code' => $worker[0]->payroll_area,
                              'job_code' => $jobCode,
                              'skill_code' => $worker[0]->skill_job,
                              'level_code' => $worker[0]->level_job,
                              'province_name' => ($province) ? $province : '-',
                              'city_name' => ($city) ? $city : '-',
                              'joindate' => $joinDate,
                              'nationality' => 'INDONESIA',
                              'sap_perner' => $worker[0]->perner,
                              'position_id' => $checkPosition->data->code,
                              'fullname' => $worker[0]->fullname,
                              'birthplace' => $worker[0]->birth_place,
                              'birthdate' => $birthDate,
                              'religion' => $religion,
                              'gender' => $gender,
                              'ktp_number' => ($worker[0]->id_card_number) ? $worker[0]->id_card_number : '0000000000000000',
                              'kk_number' => ($worker[0]->id_card_number) ? $worker[0]->id_card_number : '0000000000000000',
                              // 'kk_number' => ($data_pekerja[0]->kknumber) ? $data_pekerja[0]->kknumber : '0000000000000000',
                              'marital_status' => $maritalStatus,
                              // 'debug' => 1
                            ];
                            $reqHiring = $this->baseCurl($url, 'post', $attrs, ['token: ' . $this->_token]); //var_dump($reqHiring);die;
                            if ($reqHiring) {
                              if ($reqHiring->status) {

                                $rethire = ['key' => $i, 'status' => $reqHiring->status, 'message' => $reqHiring->message, 'position' => $checkPosition->data->code, 'perner' => $worker[0]->perner];
                                echo json_encode($rethire) . "\n";

                                $educationLevel = $worker[0]->education_level;
                                if (!in_array($worker[0]->education_level, ['sd', 'sltp', 'slta', 'd1', 'd2', 'd3', 's1', 's2', 's3', 'training', 'workshop', 'smp', 'sma'])) $educationLevel = 'training';

                                //Insert bio
                                $url = 'https://hrpay.ish.co.id/middleware/employee/bio';
                                $attrs = [
                                  'perner' => $reqHiring->data->personal_number,
                                  'address' => [
                                    [
                                      'type' => 'ktp',
                                      'contact_name' => 'default',
                                      'address' => ($worker[0]->family_address_1) ? $worker[0]->family_address_1 : '-',
                                      'city' => ($worker[0]->family_city_1) ? $worker[0]->family_city_1 : '-',
                                      'zipcode' => ($worker[0]->family_postal_code_1) ? $worker[0]->family_postal_code_1 : '00000',
                                    ],
                                    [
                                      'type' => 'emergency',
                                      'contact_name' => 'default',
                                      'address' => ($worker[0]->family_address_2) ? $worker[0]->family_address_2 : '-',
                                      'city' => ($worker[0]->family_city_2) ? $worker[0]->family_city_2 : '-',
                                      'zipcode' => ($worker[0]->family_postal_code_2) ? $worker[0]->family_postal_code_2 : '000000',
                                    ],
                                  ],
                                  'family' => [
                                    [
                                      'type' => 'other',
                                      'name' => ($worker[0]->family_name_1) ? $worker[0]->family_name_1 : 'undifined',
                                      'gender' => $genderFamily,
                                      'birthdate' => $familyBirthDate1 ? $familyBirthDate1 : '1900-12-31',
                                    ]
                                  ],
                                  'education' => [
                                    [
                                      'startdate' => $startEducationDate ? $startEducationDate : '-',
                                      'enddate' => $startEducationDate ? $startEducationDate : '9999-12-31',
                                      'level' => $educationLevel,
                                      'major' => ($worker[0]->education_major) ? $worker[0]->education_major : '-',
                                      'certificate' => $isCertificate,
                                      'finale_grade' => ($worker[0]->education_mark) ? $worker[0]->education_mark : '0',
                                    ]
                                  ],
                                  'tax' => [
                                    [
                                      'npwp_registration_date' => $joinDate,
                                      'company_tax_id' => '000000000000000',
                                      'personal_tax_id' => ($worker[0]->tax_number) ? $worker[0]->tax_number : '000000000000000', // validasi max character 15
                                    ],
                                  ],
                                  'jamsostek' => [
                                    [
                                      'id_number' => ($worker[0]->jamsostek_number) ? $worker[0]->jamsostek_number : '00000000000', // validasi max character 11
                                      'married' => $maritalStatus,
                                    ]
                                  ],
                                  'bank' => [
                                    [
                                      'startdate' => $joinDate,
                                      'enddate' => '9999-12-31',
                                      'bank_key' => $worker[0]->bank_type, //nama bank, kode ambil dari master bank ditambahkan kode bank sap
                                      'bank_type' => 'main', //validasi max character 11
                                      'bank_account' => $worker[0]->bank_number
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
                                      'mobile' => $worker[0]->family_phone_number_1 ? $worker[0]->family_phone_number_1 : '08123456789',
                                      'type' => 'main',
                                    ]
                                  ],
                                ];
                                //echo json_encode($attrs) . "\n";
                                $insertBio = $this->baseCurl($url, 'post', $attrs, ['token: ' . $this->_token]);
                                if ($insertBio) {
                                  if ($insertBio->status) {

                                    $retbio = ['key' => $i, 'status' => $insertBio->status, 'message' => $insertBio->message, 'perner' => $worker[0]->perner];
                                    echo json_encode($retbio) . "\n";
                                  } else {

                                    echo "Failed to insert bio status is 0. | ";
                                    $retbio = ['key' => $i, 'status' => $insertBio->status, 'message' => $insertBio->message, 'perner' => $worker[0]->perner];
                                    echo json_encode($retbio) . "\n";
                                  }
                                } else {
                                  echo "Failed to insert bio. \n";
                                }
                              } else {

                                echo "Failed to request hiring status is 0. | ";
                                $rethire = ['key' => $i, 'status' => $reqHiring->status, 'message' => $reqHiring->message, 'position' => $checkPosition->data->code, 'perner' => $worker[0]->perner, 'contract_type' => $attrs['contract_type']];
                                echo json_encode($rethire) . "\n";

                                // INSERT LOG
                                $this->log('error', json_encode($rethire), $worker[0]->perner, $attrs, $checkPosition->message);
                              }
                            } else {

                              echo "Failed to request hiring. | ";
                              $rethire = ['key' => $i, 'status' => $reqHiring->status, 'message' => $reqHiring->message, 'position' => $checkPosition->data->code, 'perner' => $worker[0]->perner];
                              echo json_encode($rethire) . "\n";
                            }
                          } else {

                            echo "Failed to check position status is 0. | ";
                            $rethire = ['key' => $i, 'status' => $checkPosition->status, 'message' => $checkPosition->message, 'perner' => $worker[0]->perner];
                            echo json_encode($rethire) . "\n";

                            // INSERT LOG
                            $this->log('error', json_encode($rethire), $worker[0]->perner, $attrs, $checkPosition->message);
                          }
                        } else {

                          echo "Failed to check position code is 0. | ";
                          $rethire = ['key' => $i, 'status' => $checkPosition->status, 'message' => $checkPosition->message, 'perner' => $worker[0]->perner, 'attrs' => json_encode($attrs)];
                          echo json_encode($rethire) . "\n";

                          // INSERT LOG
                          $this->log('error', json_encode($rethire), $worker[0]->perner, $attrs, $checkPosition->message);
                        }
                      } else {
                        echo "Failed to check position. \n";
                      }
                    } else {
                      echo "Payroll Area check: " . $checkPa->message . "\n";
                    }
                  } else {
                    echo "Failed to check payroll area. \n";
                  }
                } else {
                  echo "Failed to get worker. \n";
                }
              } else {
                echo "Employee is exist. | ";
                $rethire = ['key' => $i, 'perner' => $d->id];
                echo json_encode($rethire) . "\n";
              }
            } else {
              echo "Failed to check employee code is 0. \n";
            }
          } else {
            echo "Failed to check employee. \n";
          }
        }
      }
    } else {
      echo "Failed to get data pekerja by PA. \n";
    }


    // Close db Connection
    $db->close();

    // Close dbjo Connection
    $dbJo->close();

    //} catch(\Exception $e) {
    //print_r($e->getMessage());
    //}   

    return ExitCode::OK;
  }

  private function baseCurl($url, $methode = 'get', $attributes, $header = null)
  {
    $ret = null;

    if ($methode == 'get') {

      $params = null;
      if (is_array($attributes)) {
        $countAttr = count($attributes);
        $i = 0;
        foreach ($attributes as $key => $value) {
          $i++;
          $params .= $key . '=' . urlencode($value);
          if ($i < $countAttr) $params .= '&';
        }
        $params = $params;
      }

      $url = $url . '?' . $params;
    }

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_URL, $url);

    if ($methode == 'post') {

      $attributes = http_build_query($attributes);

      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
      //curl_setopt($ch,CURLOPT_POST, 1); //0 for a get request
      curl_setopt($ch, CURLOPT_POSTFIELDS, $attributes);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_ENCODING, '');
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
      curl_setopt($ch, CURLOPT_TIMEOUT, 0);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    }
    if ($header) {
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }

    $response = curl_exec($ch);

    /*if($url == 'https://hrpay.ish.co.id/middleware/hraction/hiring'){
            var_dump($response);die;
        }*/

    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpcode != 200) {
      var_dump($url);
      var_dump($response);
      die;
    }

    $ret = json_decode($response);

    return $ret;
  }


  private function log($type, $body, $perner, $attrs, $msg)
  {
    $ret = true;

    // open connection db
    $db = new Connection(Yii::$app->db);
    $db->open();

    // INSERT LOG
    $db->createCommand()->insert('log_hiring', [
      'create_time' => date('Y-m-d H:i:s'),
      'type' => $type,
      'body' => $body,
      'message' => $msg,
      'perner' => $perner,
      'personel_area_code' => $attrs['personel_area_code'],
      'job_code' => $attrs['job_code'],
      'skill_code' => $attrs['skill_code'],
      'area_code' => $attrs['area_code'],
      'level_code' => $attrs['level_code'],
    ])->execute();

    // Close db Connection
    $db->close();

    return $ret;
  }
}
