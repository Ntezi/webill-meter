<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "user_has_meter".
 *
 * @property int $user_id
 * @property int $meter_id
 * @property string $started_at
 * @property string $ended_at
 * @property int $status 0:inactive;1:active
 * @property int $id
 *
 * @property User $user
 * @property Meter $meter
 */
class UserHasMeter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_has_meter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'meter_id'], 'required'],
            [['user_id', 'meter_id', 'status'], 'integer'],
            [['started_at', 'ended_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['meter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Meter::className(), 'targetAttribute' => ['meter_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'meter_id' => Yii::t('app', 'Meter ID'),
            'started_at' => Yii::t('app', 'Started At'),
            'ended_at' => Yii::t('app', 'Ended At'),
            'status' => Yii::t('app', 'Status'),
            'id' => Yii::t('app', 'ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMeter()
    {
        return $this->hasOne(Meter::className(), ['id' => 'meter_id']);
    }
}
