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

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['unit_price', 'tax', 'discount', 'processing_fee'], 'number'],
            [['submission_start', 'submission_end', 'created_at', 'updated_at'], 'safe'],
            [['created_by', 'updated_by', 'status'], 'integer'],
            [['title'], 'string', 'max' => 255],
        ];
    }
}