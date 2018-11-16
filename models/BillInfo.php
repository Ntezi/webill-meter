<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 10/26/18
 * Time: 4:01 PM
 */

namespace app\models;

use \app\models\base\BillInfo as BaseBillInfo;
use yii\behaviors\BlameableBehavior;

class BillInfo  extends BaseBillInfo
{
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
}