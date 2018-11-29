<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 4:02 PM
 */

namespace app\models;

use app\helpers\QRCodeHelper;
use app\helpers\UploadHelper;
use Yii;
use \app\models\base\Bill as BaseBill;
use yii\behaviors\BlameableBehavior;

class Bill extends BaseBill
{
    public $image;

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
            [['user_id'], 'required'],
            [['user_id', 'verified_by_user', 'verified_by_admin', 'created_by', 'updated_by', 'paid_flag'], 'integer'],
            [['previous_reading', 'total_amount'], 'number'],
            [['created_at', 'updated_at', 'deadline'], 'safe'],
            [['image_file', 'bill_file_path'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['image'], 'safe'],
            [['image'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg', 'jpeg', 'gif'], 'maxSize' => 1024 * 1024],
        ];
    }

    public function beforeValidate()
    {
        $this->image = preg_replace('/\s+/', '', $this->image);

        return parent::beforeValidate();
    }

    public function uploadImage($uploaded_file)
    {
        $file_name = rand() . rand() . date("Ymdhis") . '.' . $uploaded_file->extension;

        Yii::warning('file name: ' . $file_name);
        $path = Yii::getAlias('@app') . '/web/uploads/bills/';
        $file_dir = $path . Yii::$app->user->identity->id . '/' . $this->id . '/';

        Yii::warning('file dir: ' . $file_name);
        if (UploadHelper::upload($uploaded_file, $this, 'image_file', $file_name, $file_dir)) {
            Yii::warning('After: ' . $file_name);
            return true;
        } else {
            Yii::warning('fail: ' . $file_name);
            return false;
        }
    }

    public function getFlagLabel()
    {
        $label = Yii::t('app', 'Not set');
        if ($this->paid_flag == Yii::$app->params['not_paid_bill_flag']) {
            $label = Yii::t('app', 'Not paid');
        } elseif ($this->paid_flag == Yii::$app->params['paid_bill_flag']) {
            $label = Yii::t('app', 'Paid');
        } elseif ($this->paid_flag == Yii::$app->params['pending_bill_flag']) {
            $label = Yii::t('app', 'Pending');
        } elseif ($this->paid_flag == Yii::$app->params['rejected_bill_flag']) {
            $label = Yii::t('app', 'Rejected');
        }

        return $label;
    }

    public function getImagePath()
    {
        $image = $this->user_id . '/' . $this->id . '/' . $this->image_file;
        return Yii::$app->params['uploads'] . 'bills/' . $image;
    }

    public function getImageAbsolutePath()
    {
        $image = $this->user_id . '/' . $this->id . '/' . 'new_' . $this->image_file;
        return Yii::getAlias('@app') . '/web/uploads/bills/' . $image;
    }

    public function readBillQRCode()
    {
        return QRCodeHelper::ReadQRCode($this->getImageAbsolutePath());
    }

    public function getMeterCurrentReading()
    {
        return UploadHelper::getReadImage($this->getImageAbsolutePath());
    }

    public function saveMeterReading()
    {
        //Read image with OCR
        $current_reading = $this->getMeterCurrentReading();
        if ($current_reading != '') {
            $this->current_reading = $current_reading;
            if ($this->save()) {
                Yii::warning('getMeterCurrentReading: ' . $current_reading);
                return true;
            } else {
                return false;
            }
        }
    }

    public function checkCurrentReading($current_reading)
    {
        if ($current_reading != null) {
            $this->current_reading = (int)$current_reading;
            if ($this->current_reading > $this->previous_reading) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function checkQRCode()
    {
        $current_address = User::getConsumerCurrentAddress(Yii::$app->user->identity->getId());
        Yii::warning('current_address : ' . $current_address);
        Yii::warning('readBillQRCode : ' . $this->readBillQRCode());

        if ($this->readBillQRCode() != '') {
            if ($current_address !== null && $current_address === $this->readBillQRCode()) {
                return 'ok';
            } else {
                return 'no';
            }
        } else {
            return 'no';
        }

    }


    public function checkLocation()
    {
        $meter = User::getConsumerCurrentMeter(Yii::$app->user->identity->getId());
        if (!empty($meter)) {
            $current_latitude = $meter->latitude;
            $current_longitude = $meter->longitude;
            $image_location = UploadHelper::getImageLocationInfo($this->getImagePath());

            if (!empty($image_location)) {
                Yii::warning('image_location: ' . print_r($image_location, true));

                $uploaded_latitude = $image_location['latitude'];
                $uploaded_longitude = $image_location['longitude'];

                if ($current_latitude !== null && $current_longitude !== null) {
                    $distance = $this->vincentyGreatCircleDistance(
                        $current_latitude, $current_longitude,
                        $uploaded_latitude, $uploaded_longitude);

                    Yii::warning('$current_latitude : ' . $current_latitude);
                    Yii::warning('$current_longitude : ' . $current_longitude);

                    Yii::warning('$uploaded_latitude : ' . $uploaded_latitude);
                    Yii::warning('$uploaded_longitude : ' . $uploaded_longitude);

                    Yii::warning('$dinstance : ' . $distance);

                    if ($distance <= 800) {
                        return 'ok';
                    } else {
                        return 'no';
                    }
                }
            } else {

                return 'no';
            }

        }
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Vincenty formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    public static function vincentyGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }


    public function checkBill()
    {
        Yii::warning('checkLocation : ' . $this->checkLocation());
        return array('qr_code_check' => $this->checkQRCode(), 'location_check' => $this->checkLocation());
    }

    //Billing Formula
    //[consumption *unit_price + tax] - discount where
    //consumption = current_reading-previous_reading
    public function calculateBill($bill_info_id)
    {
        $bill_info = BillInfo::findOne($bill_info_id);
        if (!empty($bill_info)) {
            $consumption = $this->current_reading - $this->previous_reading;
            $cost = ($consumption * $bill_info->unit_price + $bill_info->unit_price + 0.08);
            return $cost - $bill_info->discount;
        }
    }

    public function getConsumerEmail()
    {
        $user = User::findOne(['id' => $this->user_id]);
        if (empty($user)) {
            Yii::warning('email : ' . $user->email);
            return $user->email;
        }

    }
}