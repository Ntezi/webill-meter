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
    /**
     * @inheritdoc
     */
    protected function matchRole($user)
    {
        if (empty($this->roles)) {
            return true;
        }
        foreach ($this->roles as $role) {
            if ($role == '?') {
                if ($user->getIsGuest()) {
                    return true;
                }
            } elseif ($role == User::ROLE_USER) {
                if (!$user->getIsGuest()) {
                    return true;
                }
                // Check if the user is logged in, and the roles match
            } elseif (!$user->getIsGuest() && $role == $user->identity->role) {
                return true;
            }
        }

        return false;
    }
}