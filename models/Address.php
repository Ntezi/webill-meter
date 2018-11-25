<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/19/18
 * Time: 9:44 AM
 */

namespace app\models;

use \app\models\base\Address as BaseAddress;
use yii\behaviors\BlameableBehavior;
use Yii;

class Address extends BaseAddress
{
    public $address;

    public function rules()
    {
        return [
            [['zip_code', 'prefecture', 'city', 'ward', 'town', 'district', 'street_number', 'building_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['zip_code', 'prefecture', 'city', 'ward', 'town', 'district', 'street_number', 'building_name', 'full_address'], 'string', 'max' => 255],
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

    public static function getAddressByName($post)
    {
        $address = explode(' # ', $post['address']);
        Yii::warning($address);

        $building_name = $address['0'];
        $street_number = $address['1'];
        $district = $address['2'];
        $town = $address['3'];
        $ward = $address['4'];
        $city = $address['5'];

        if ($building_name != '' && $street_number != '' && $district != '' && $town != '' && $ward != '' && $city != '') {
            $address_ = self::find()
                ->where(['building_name' => $building_name])
                ->andWhere(['street_number' => $street_number])
                ->andWhere(['district' => $district])
                ->andWhere(['town' => $town])
                ->andWhere(['ward' => $ward])
                ->andWhere(['city' => $city])
                ->one();

            return $address_;
        }

    }
}