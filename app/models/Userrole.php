<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userrole".
 *
 * @property int $id
 * @property string $createtime
 * @property string $updatetime
 * @property string $role
 */
class Userrole extends \yii\db\ActiveRecord
{
    public $countcheck;
    public $m1;
    public $m2;
    public $m3;
    public $m4;
    public $m5;
    public $m6;
    public $m7;
    public $m8;
    public $m9;
    public $m10;
    public $m11;
    public $m12;
    public $m13;
    public $m14;
    public $m15;
    public $m16;
    public $m17;
    public $m18;
    public $m19;
    public $m20;
    public $m21;
    public $m22;
    public $m23;
    public $m24;
    public $m25;
    public $m26;
    public $m27;
    public $m28;
    public $m29;
    public $m30;
    public $m31;
    public $m32;
    public $m33;
    public $m34;
    public $m35;
    public $m36;
    public $m37;
    public $m38;
    public $m39;
    public $m40;
    public $m41;
    public $m42;
    public $m43;
    public $m44;
    public $m45;
    public $m46;
    public $m47;
    public $m48;
    public $m49;
    public $m50;
    public $m51;
    public $m52;
    public $m53;
    public $m54;
    public $m55;
    public $m56;
    public $m57;
    public $m58;
    public $m59;
    public $m60;
    public $m61;
    public $m62;
    public $m63;
    public $m64;
    public $m65;
    public $m66;
    public $m67;
    public $m68;
    public $m69;
    public $m70;
    public $m71;
    public $m72;
    public $m73;
    public $m74;
    public $m75;
    public $m76;
    public $m77;
    public $m78;
    public $m79;
    public $m80;
    public $m81;
    public $m82;
    public $m83;
    public $m84;
    public $m85;
    public $m86;
    public $m87;
    public $m88;
    public $m89;
    public $m90;
    public $m91;
    public $m92;
    public $m93;
    public $m94;
    public $m95;
    public $m96;
    public $m97;
    public $m98;
    public $m99;
    public $m100;
    public $m101;
    public $m102;
    public $m103;
    public $m104;
    public $m105;
    public $m106;
    public $m107;
    public $m108;
    public $m109;
    public $m110;
    public $m111;
    public $m112;
    public $m113;
    public $m114;
    public $m115;
    public $m116;
    public $m117;
    public $m118;
    public $m119;
    public $m120;
    public $m121;
    public $m122;
    public $m123;
    public $m124;
    public $m125;
    public $m126;
    public $m127;
    public $m128;
    public $m129;
    public $m130;
    public $m131;
    public $m132;
    public $m133;
    public $m134;
    public $m135;
    public $m136;
    public $m137;
    public $m138;
    public $m139;
    public $m140;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userrole';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['createtime', 'updatetime', 'role'], 'required'],
            [['createtime', 'updatetime'], 'safe'],
            [['m1', 'm2', 'm3', 'm4', 'm5', 'm6', 'm7', 'm8', 'm9', 'm10', 'm11', 'm12', 'm13', 'm14', 'm15', 'm16', 'm17', 'm18', 'm19', 'm20', 'm21', 'm22', 'm23', 'm24', 'm25', 'm26', 'm27', 'm28', 'm29', 'm30', 'm31', 'm32', 'm33', 'm34', 'm35', 'm36', 'm37', 'm38', 'm39', 'm40', 'm41', 'm42', 'm43', 'm44', 'm45', 'm46', 'm47', 'm48', 'm49', 'm50', 'm51', 'm52', 'm53', 'm54', 'm55', 'm56', 'm57', 'm58', 'm59', 'm60', 'm61', 'm62', 'm63', 'm64', 'm65', 'm66', 'm67', 'm68', 'm69', 'm70', 'm71', 'm72', 'm73', 'm74', 'm75', 'm76', 'm77', 'm78', 'm79', 'm80', 'm81', 'm82', 'm83', 'm84', 'm85', 'm86', 'm87', 'm88', 'm89', 'm90', 'm91', 'm92', 'm93', 'm94', 'm95', 'm96', 'm97', 'm98', 'm99', 'm100','m101', 'm102', 'm103', 'm104', 'm105', 'm106', 'm107', 'm108', 'm109', 'm110', 'm111', 'm112', 'm113', 'm114', 'm115', 'm116', 'm117', 'm118','m119', 'm120', 'm121', 'm122', 'm123', 'm124', 'm125', 'm126', 'm127', 'm128', 'm129', 'm130', 'm131', 'm132', 'm133', 'm134', 'm135', 'm136', 'm137', 'm138', 'm139', 'm140', 'countcheck'], 'integer'],
            [['role'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'createtime' => 'Create Time',
            'updatetime' => 'Update Time',
            'role' => 'Role',
            'm1' => 'View',
            'm2' => 'View',
            'm3' => 'Invite',
            'm4' => 'View Interview',
            'm5' => 'Confirmation',
            'm6' => 'Process',
            'm7' => 'View Psikotest',
            'm8' => 'Confirmation',
            'm9' => 'Process',
            'm10' => 'View User Interview',
            'm11' => 'Confirmation',
            'm12' => 'Process',
            'm13' => 'View',
            'm14' => 'Add Candidate',
            'm15' => 'View',
            'm16' => 'Create',
            'm17' => 'Update',
            'm18' => 'Delete',
            'm19' => 'View',
            'm20' => 'Create',
            'm21' => 'Update',
            'm22' => 'Delete',
            'm23' => 'View',
            'm24' => 'Create',
            'm25' => 'Update',
            'm26' => 'Delete',
            'm27' => 'View',
            'm28' => 'Create',
            'm29' => 'Update',
            'm30' => 'Delete',
            'm31' => 'View',
            'm32' => 'Create',
            'm33' => 'Update',
            'm34' => 'Delete',
            'm35' => 'View Hiring',
            'm36' => 'Hiring',
            'm37' => 'Approval',
            'm38' => 'View',
            'm39' => 'Process',
            'm40' => 'View',
            'm41' => 'Process',
            'm42' => 'View',
            'm43' => 'Process',
            'm44' => 'View',
            'm45' => 'Process',
            'm46' => 'Cancel',
            'm47' => 'Change JO',
            'm48' => 'View',
            'm49' => 'Update',
            'm50' => 'View',
            'm51' => 'View',
            'm52' => 'View',
            'm53' => 'Create',
            'm54' => 'Update',
            'm55' => 'Delete',
            'm56' => 'Approve',
            'm57' => 'View',
            'm58' => 'Create',
            'm59' => 'Update',
            'm60' => 'Delete',
            'm61' => 'Approve',
            'm62' => 'Stop Job Order',
            'm63' => 'Add Candidate',
            'm64' => 'View',
            'm65' => 'Approve',
            'm66' => 'View',
            'm67' => 'View',
            'm68' => 'Create',
            'm69' => 'Update',
            'm70' => 'Delete',
            'm71' => 'Approve',
            'm72' => 'View',
            'm73' => 'Create',
            'm74' => 'Update',
            'm75' => 'Delete',
            'm76' => 'View',
            'm77' => 'Create',
            'm78' => 'Update',
            'm79' => 'Delete',
            'm80' => 'View',
            'm81' => 'Create',
            'm82' => 'Update',
            'm83' => 'Delete',
            'm84' => 'View',
            'm85' => 'Create',
            'm86' => 'Update',
            'm87' => 'Delete',
            'm88' => 'View Cancel Join',
            'm89' => 'Create Cancel Join',
            'm90' => 'Update Cancel Join',
            'm91' => 'Delete Cancel Join',
            'm92' => 'Approve Cancel Join',
            'm93' => 'View Hold Joborder',
            'm94' => 'Create Hold Joborder',
            'm95' => 'Update Hold Joborder',
            'm96' => 'Delete Hold Joborder',
            'm97' => 'Approve Hold Joborder',
            'm98' => 'Report Cancel Join',
            'm99' => 'Report Cancel Hiring',
            'm100' => 'Report',
            'm101' => 'File',
            'm102' => 'View Work Order',
            'm103' => 'Create Work Order',
            'm104' => 'Update Work Order',
            'm105' => 'Delete Work Order',
            'm106' => 'Approve Work Order',
            'm107' => 'View Order Candidate',
            'm108' => 'Create Order Candidate',
            'm109' => 'Process Order Candidate',
            'm110' => 'Delete Order Candidate',
            'm111' => 'Approve Order Candidate',
            'm112' => 'View Order Psikotest',
            'm113' => 'Create Order Psikotest',
            'm114' => 'Process Order Psikotest',
            'm115' => 'Delete Order Psikotest',
            'm116' => 'Approve Order Psikotest',
            'm117' => 'View Order Interview',
            'm118' => 'Create Order Interview',
            'm119' => 'Process Order Interview',
            'm120' => 'Delete Order Interview',
            'm121' => 'Approve Order Interview',
            'm122' => 'View Order User Interview',
            'm123' => 'Create Order User Interview',
            'm124' => 'Process Order User Interview',
            'm125' => 'Delete Order User Interview',
            'm126' => 'Approve Order User Interview',
            'm127' => 'View Order Hiring',
            'm128' => 'Create Order Hiring',
            'm129' => 'Process Order Hiring',
            'm130' => 'Delete Order Hiring',
            'm131' => 'Approve Order Hiring',
            'm132' => 'View CMS',
            'm133' => 'Create CMS',
            'm134' => 'Update CMS',
            'm135' => 'Delete CMS',
            'm136' => 'Approve CMS',
        ];
    }
}
