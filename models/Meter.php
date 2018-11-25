<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/19/18
 * Time: 3:12 PM
 */

namespace app\models;

use app\helpers\QRCodeHelper;
use app\helpers\UploadHelper;
use Yii;
use \app\models\base\Meter as BaseMeter;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "meter".
 *
 * @property string $qr_code_image
 */
class Meter extends BaseMeter
{
    public $qr_code_image;

    public function behaviors()
    {
        return [
            'blameable' => [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    public function rules()
    {
        return [
            [['address_id', 'reading'], 'required'],
            [['address_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['latitude', 'longitude', 'reading'], 'number'],
            [['created_at', 'update_at'], 'safe'],
            [['serial_number', 'qr_code_file'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],

//            [['qr_code_image'], 'required', 'on' => 'create'],
            [['qr_code_image'], 'safe'],
            [['qr_code_image'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024 * 1024],
        ];
    }

    public function getAddressName()
    {
        return Address::findOne(['id' => $this->address_id])->building_name;
    }

    public static function getMeter($post)
    {
        $address = Address::getAddressByName($post);
        if (!empty($address)) {
            Yii::warning('$address_: ' . print_r($address, true));
            return self::findOne(['address_id' => $address->id]);
        }
    }

    public function beforeValidate()
    {
        $this->qr_code_image = preg_replace('/\s+/', '', $this->qr_code_image);

        return parent::beforeValidate();
    }

    public function uploadQRCode($uploaded_file)
    {
        if ($uploaded_file) {
            $file_name = rand() . rand() . date("Ymdhis") . '.' . $uploaded_file->extension;
            $path = Yii::getAlias('@app') . '/web/uploads/meters/';
            $file_dir = $path . $this->id . '/';

            if (UploadHelper::upload($uploaded_file, $this, 'qr_code_file', $file_name, $file_dir)) {
                return true;
            } else {
                return false;
            }
        }

    }

    public function readMeterQRCode()
    {
        Yii::warning('qr_code_image : ' . $this->qr_code_file);
        $path = Yii::getAlias('@app') . '/web/uploads/meters/' . $this->id . '/' . $this->qr_code_file;
        Yii::warning('meters path: ' . $path);
        return QRCodeHelper::ReadQRCode($path);
    }
}