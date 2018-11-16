<?php

namespace app\models;

use app\helpers\EmailHelper;
use Yii;
use app\models\base\User as BaseUser;
use yii\behaviors\BlameableBehavior;
use yii\web\IdentityInterface;

class User extends BaseUser implements IdentityInterface
{
    const ROLE_USER = 1;
    const ROLE_ADMIN = 0;

    public $password;
    public $confirm_password;

    public function rules()
    {
        return [
            ['email', 'required', 'message'=>Yii::t('app', "Email is required")],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['role', 'default', 'value' => self::ROLE_USER],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by', 'role'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'first_name', 'last_name'], 'string', 'max' => 255],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'compare', 'compareAttribute'=>'password', 'skipOnEmpty' => false, 'message' => Yii::t('app', "Passwords don't match")],
        ];
    }

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

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::find()
            ->where(['password_reset_token' => $token])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->andWhere(['role' => self::ROLE_USER])
            ->orWhere(['role' => self::ROLE_ADMIN])
            ->one();
    }

    public static function registeredMessage($email, $password, $role)
    {
        $subject = 'Webill Admin';

        $body = "Your account was successfully created <br/>";
        $body .= "Please use this password: <b>" . $password . " </b>";

        if ($role == Yii::$app->params['consumer_role']){
            $body .=" to login at <a href=". Yii::$app->params['client_url'] .">Webill</a> " . "<br/>";
        }

        if ($role == Yii::$app->params['admin_role']){
            $body .=" to login at <a href=". Yii::$app->params['admin_url'] .">Webill Admin</a>  as an admin user. " . "<br/>";
        }

        $body .="You may change it later after successfully logged in";

        EmailHelper::sendEmail($email, $subject , $body);
    }

    public function getConsumerCurrentAddress($user_id)
    {
        $meter = self::getConsumerCurrentMeter($user_id);
        if (!empty($meter))
            return Address::findOne(['id' => $meter->address_id]);
    }

    public static function getConsumerCurrentMeter($user_id)
    {
        $user_has_meter = UserHasMeter::findOne(['user_id' => $user_id, 'ended_at' => null]);
        if (!empty($user_has_meter))
            $meter = Meter::findOne(['id' => $user_has_meter->meter_id]);

            if (!empty($meter))
                return $meter;
    }

}
