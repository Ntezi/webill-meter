<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "meter".
 *
 * @property int $id
 * @property int $address_id
 * @property string $serial_number
 * @property string $qr_code_file
 * @property double $latitude
 * @property double $longitude
 * @property double $reading
 * @property string $created_at
 * @property string $update_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $status 0:inactive; 1:active
 *
 * @property Address $address
 * @property UserHasMeter[] $userHasMeters
 */
class Meter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['address_id', 'qr_code_file', 'latitude', 'longitude'], 'required'],
            [['address_id', 'created_by', 'updated_by', 'status'], 'integer'],
            [['latitude', 'longitude', 'reading'], 'number'],
            [['created_at', 'update_at'], 'safe'],
            [['serial_number', 'qr_code_file'], 'string', 'max' => 255],
            [['address_id'], 'exist', 'skipOnError' => true, 'targetClass' => Address::className(), 'targetAttribute' => ['address_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'address_id' => Yii::t('app', 'Address ID'),
            'serial_number' => Yii::t('app', 'Serial Number'),
            'qr_code_file' => Yii::t('app', 'Qr Code File'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'reading' => Yii::t('app', 'Reading'),
            'created_at' => Yii::t('app', 'Created At'),
            'update_at' => Yii::t('app', 'Update At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAddress()
    {
        return $this->hasOne(Address::className(), ['id' => 'address_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserHasMeters()
    {
        return $this->hasMany(UserHasMeter::className(), ['meter_id' => 'id']);
    }
}
