<?php
/**
 * Created by PhpStorm.
 * User: mariusngaboyamahina
 * Date: 11/16/18
 * Time: 4:54 PM
 */

namespace app\components;

use app\models\User;
use yii\filters\AccessRule as BaseAccessRule;

class AccessRule extends BaseAccessRule
{
    public $role;
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        $role = '@';

        if ($role == '?') {
            if ($user->getIsGuest()) {
                return false;
            }
        }  elseif (!$user->getIsGuest() && $role == $user->identity->role) {
            return true;
        }
    }
}