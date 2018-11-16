<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/23/18
 * Time: 11:18 AM
 */

namespace app\models;

use Yii;
use \app\models\base\UserHasMeter as BaseUserHasMeter;

class UserHasMeter extends BaseUserHasMeter
{

    public function rules()
    {
        return [
            [['user_id', 'meter_id'], 'required'],
            [['user_id', 'meter_id', 'status'], 'integer'],
            [['started_at', 'ended_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['meter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Meter::className(), 'targetAttribute' => ['meter_id' => 'id']],
            //[['user_id', 'meter_id'], 'unique', 'targetClass' => self::className(), 'message' => 'This meter has already been taken.'],
//            [['user_id', 'meter_id'], 'unique', 'when' => function ($model) {
//                $current_date_time = date("Y-m-d H:i:s");
//                $ended_at = date("Y-m-d H:i:s", strtotime($model->ended_at));
//                return ($ended_at < $current_date_time || $ended_at == null);
//            }, 'message' => 'This meter has already been taken.'],
        ];
    }

    public static function checkTakenMeter()
    {

    }


}