<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "address".
 *
 * @property int $id
 * @property string $zip_code YUUBINBANGOU
 * @property string $prefecture TO    FU (Metropolis)     KEN or DO (Prefecture)
 * @property string $city SHI (City)    GUN (Rural area)
 * @property string $ward KU (Ward)
 * @property string $town CHOU=MACHI (Town)     MURA (Village)
 * @property string $district CHOUME (District)
 * @property string $street_number BANCHI (Block)  BAN (Block)
 * @property string $building_name Building name - *GO (Room/Apt #, etc.)
 * @property string $created_at
 * @property string $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $status
 *
 * @property Meter[] $meters
 */
class Address extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'address';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['zip_code', 'prefecture', 'city', 'ward', 'town', 'district', 'street_number', 'building_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['zip_code', 'prefecture', 'city', 'ward', 'town', 'district', 'street_number', 'building_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'zip_code' => Yii::t('app', 'Zip Code'),
            'prefecture' => Yii::t('app', 'Prefecture'),
            'city' => Yii::t('app', 'City'),
            'ward' => Yii::t('app', 'Ward'),
            'town' => Yii::t('app', 'Town'),
            'district' => Yii::t('app', 'District'),
            'street_number' => Yii::t('app', 'Street Number'),
            'building_name' => Yii::t('app', 'Building Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeters()
    {
        return $this->hasMany(Meter::className(), ['address_id' => 'id']);
    }
}
